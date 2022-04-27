<?php

namespace App\Http\Controllers\Driver;


use App\Country;
use App\Device;
use App\Enums\AOrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\RouteNumberStatus;
use App\Events\AgentEvent;
use App\Events\DriverAccepted;
use App\Events\LocationNow;
use App\Events\OrderOperation;
use App\Events\OrderStatusChanged;
use App\Fleet;
use App\FleetFile;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Money;
use App\Order;
use App\Products;
use App\RealCommission;
use App\RequestMoney;
use App\RouteNumber;
use App\User;
use App\Enums\DriverApply;
use Carbon\Carbon;
use DB;
use Doctrine\DBAL\Event\SchemaAlterTableRemoveColumnEventArgs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Rules\AgeValidationRule;
use Tymon\JWTAuth\Facades\JWTAuth;

class DriverControllerV2 extends Controller
{
    /**
     * new version
     *
     * @group  Driver Mobile API
     * Orders
     * this api will return the list of orders in process
     *
     *
     */
    public function newOrders(Request $request)
    {
        $fleet = auth('fleet')->user();
        $orders= [];
        if($fleet->application_status_id == DriverApply::APPROVED_BY_PUDO ){
        $orders = $fleet->newOrders->where("order_status_id",AOrderStatus::NEW_ORDER);
            //$orders = $fleet->newOrders()->where("order_status_id",AOrderStatus::NEW_ORDER)->paginate(3);
        }

        return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
    }
    public function BatchOrders(Request $request)
    {
        $fleet = auth('fleet')->user();
        $orders= [];
        if($fleet->application_status_id == DriverApply::APPROVED_BY_PUDO ){
//        $orders = $fleet->newOrders->where("order_status_id",AOrderStatus::NEW_ORDER);
//            //$orders = $fleet->newOrders()->where("order_status_id",AOrderStatus::NEW_ORDER)->paginate(3);
            $orders=Order::where('route_number_id',$request->batch_id)->get();
        }

        return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
    }
    public function newBatches(Request $request)
    {
        $fleet = auth('fleet')->user();
        $orders= [];
        if($fleet->application_status_id == DriverApply::APPROVED_BY_PUDO ){
            $orders = $fleet->newPatches;
            $orders = $orders->makeHidden(['pivot', 'created_at', 'updated_at']);
            return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
        }

        return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
    }
    public function acceptBatches($id)
    {
        $fleet = auth('fleet')->user();
        $batch = RouteNumber::find($id);
        if ($batch->status == RouteNumberStatus::ACCEPTED) {
            return response()->json(['status' => false, 'message' => 'the order accepted by another driver '],500);
        }
        $fleet->status='busy';
        $fleet->save();
        $data =$batch->update(['fleet_id' => $fleet->id,"status" => RouteNumberStatus::ACCEPTED]);
        $orders=$batch->orders;
       foreach ($orders as $order){
           $order->order_status_id = AOrderStatus::DRIVER_ACCEPTED;
           $order->fleet_id = $fleet->id;
           $order->save();
           $order->status;
           $order->user;
           $commission=new WalletController();
           $commission->Commission($order->kilos_count,$fleet->user_id,$order->id);
           event(new DriverAccepted($order->id, $order->fleet_id));
           event(new AgentEvent($order));
       }


        return response()->json(['status' => true, 'message' => 'succefully', 'data' => $batch]);
    }
    public function rejectBatches($id)
    {
        $fleet = auth('fleet')->user();
        $batch = RouteNumber::find($id);
        $fleet->status='free';
        $fleet->save();
        $data =$batch->update(['fleet_id' => $fleet->id,"status" => RouteNumberStatus::NOT_ACCEPT]);
        $orders=$batch->orders;
        foreach ($orders as $order) {
            $order->order_status_id = AOrderStatus::DRIVER_REJECTED;
            $order->fleet_id = $fleet->id;
            $order->save();
            $order->status;
            $order->user;
            event(new AgentEvent($order));
            event(new OrderOperation($order));
        }
        return response()->json(['status' => true, 'message' => 'succefully', 'data' => $batch]);
    }
    public function scanBatch(Request $request)
    {
        $fleet = auth('fleet')->user();
        $batch = RouteNumber::where(
            [
                'route_number'=>$request->route_number,
                'fleet_id'=>$fleet->id
            ]
        )->first();
        if($batch==[]){
            return response()->json(['status' => false, 'message' => 'no batch', 'data' => []]);
        }

        return response()->json(['status' => true, 'message' => 'succefully', 'data' => $batch]);
    }
    public function scanOrder(Request $request)
    {
        $fleet = auth('fleet')->user();
        $order = Order::where(
            [
                'id'=>$request->order_id,
                'fleet_id'=>$fleet->id
            ])->first();
        if($order==[]){
            return response()->json(['status' => false, 'message' => 'no order', 'data' => []]);
        }

        return response()->json(['status' => true, 'message' => 'succefully', 'data' => $order]);
    }


    /**
     * @group  Driver Mobile API
     * OrderHistory
     * this api will return the list of orders finished its process
     *
     */
    public function getOrdersHistory(Request $request)
    {
        $fleet = auth('fleet')->user();
        $status = $request->status;
        $orders = [];
     if($fleet->application_status_id == DriverApply::APPROVED_BY_PUDO ){
        if ($status == 'new') {
            $orders = $fleet->newOrders()->with('invoice')->where("order_status_id",AOrderStatus::NEW_ORDER)->paginate(10);
            return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
        } else if ($status == 'completed') {
            $orders = Order::with('invoice')->where([
                'fleet_id' => $fleet->id,
            ])->where('created_at', 'LIKE', '%' . $request->date . '%')
                ->whereIn('order_status_id', [
                    AOrderStatus::RETURNED,
                    AOrderStatus::DELIVERED,
                    AOrderStatus::FAILED_TO_RETURN,
                    AOrderStatus::CANCELED
                ])->paginate(10);
            return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
        } else if ($status == 'progress') {
            $orders = Order::with('invoice')->where([
                'fleet_id' => $fleet->id,
            ])->where('created_at', 'LIKE', '%' . $request->date . '%')
                ->whereIn('order_status_id', [
                    AOrderStatus::DRIVER_ACCEPTED,
                    AOrderStatus::PICKED_UP,
                    AOrderStatus::TO_BE_PICKED_UP
                ])->paginate(10);
            return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
        }
    }
        return response()->json(['status' => true, 'message' => 'success', 'data' => []]);
    }

    /**
     * @group  Driver Mobile API
     * batchHistory
     * this api will return the list of orders finished its process
     *
     */
    public function getBatchHistory(Request $request)
    {
        $fleet = auth('fleet')->user();
        $status = $request->status;
        $orders = [];
        if($fleet->application_status_id == DriverApply::APPROVED_BY_PUDO ){
            if ($status == 'new') {
                $orders = $fleet->newPatches()->where("status",[RouteNumberStatus::NEW])->paginate(10);
                return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
            } else if ($status == 'completed') {
                $orders = RouteNumber::with('branch')->where([
                    'fleet_id' => $fleet->id,
                ])->where('created_at', 'LIKE', '%' . $request->date . '%')
                    ->whereIn('status', [
                        RouteNumberStatus::COMPLETED,
                        RouteNumberStatus::FAILED,
                    ])->paginate(10);
                return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
            } else if ($status == 'progress') {
                $orders = RouteNumber::with('branch')->where([
                    'fleet_id' => $fleet->id,
                ])->where('created_at', 'LIKE', '%' . $request->date . '%')
                    ->whereIn('status', [
                        RouteNumberStatus::ACCEPTED,
                        RouteNumberStatus::NOT_ACCEPT,
                        RouteNumberStatus::ASSIGNED,

                    ])->paginate(10);
                return response()->json(['status' => true, 'message' => 'success', 'data' => $orders]);
            }
        }
        return response()->json(['status' => true, 'message' => 'success', 'data' => []]);
    }
    /**
     * @group  Driver Mobile API
     * Accept an order
     * use this api to make a driver accept an order
     * send order_id as id parameter
     * @urlParam id int required
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptOrder($id)
    {
        $fleet = auth('fleet')->user();
        $order = Order::where('id', $id)->with('products')->first();

        if ($order->order_status_id == AOrderStatus::DRIVER_ACCEPTED) {
            return response()->json(['status' => false, 'message' => 'the order accepted by another driver '],500);
        }
        $fleet->status='busy';
        $fleet->save();
        $orders=Order::whereNotNull('route_number_id')->where('route_number_id',$order->route_number_id);
        $data=$orders->update(['fleet_id' => $fleet->id,"order_status_id" => AOrderStatus::DRIVER_ACCEPTED]);
        $orderData= $orders->paginate(10);
        $order->order_status_id = AOrderStatus::DRIVER_ACCEPTED;
        $order->fleet_id = $fleet->id;
        $order->save();
        $order->status;
        $order->user;
        $commission=new WalletController();
        $commission->Commission($order->kilos_count,$fleet->user_id,$order->id);
        event(new DriverAccepted($order->id, $order->fleet_id));
        event(new AgentEvent($order));
        return response()->json(['status' => true, 'message' => 'succefully', 'data' => $orderData]);
    }


}
