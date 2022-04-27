<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Enums\AOrderStatus;
use App\Enums\RouteNumberStatus;
use App\Events\AgentEvent;
use App\Events\OrderAssigned;
use App\Events\OrderOperation;
use App\Fleet;
use App\Http\Controllers\Driver\FCMController;
use App\Http\Controllers\Driver\WalletController;
use App\Invoice;
use App\Order;
use App\Products;
use App\RouteNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RouteNUmberController extends Controller
{
    public function index(Request $request){
        try {
            $user = auth()->user();
            $query = RouteNumber::query();
            if ($user->hasRole('user')) {
                if($user->menuroles=='client-branch'){
                    $branch=Branch::where('manager_id',$user->id)->pluck('id')->toArray();
                    $query->whereIn('branch_id', $branch);
                }elseif($user->menuroles=='client') {
                    $branch=Branch::where('user_id',$user->id)->pluck('id')->toArray();
                    $query->whereIn('branch_id',$branch);
                }
            }
            if ($request->has('columnFilter')) {
                $columnFilters = json_decode($request->columnFilter, true);
                foreach ($columnFilters as $key => $value) {
                    if ($value != "")
                        $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
            if ($request->has('sorter')) {
                $sorter = json_decode($request->sorter);
                $by = $sorter->asc == true ? 'ASC' : 'DESC';
                $column = $sorter->column == '' ? 'created_at' : $sorter->column;
                $query->orderBy($column, $by);
            }
            $orders =  $query->paginate($request->get('itemsLimit'));
            return response()->json(compact('orders'));
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public function orders(Request $request,$id)
    {
        $user = auth()->user();
        $query = Order::with('status')->where('route_number_id',$id);
        if ($user->hasRole('user')) {
            if($user->menuroles=='client-branch'){
                $branch=Branch::where('manager_id',$user->id)->first();
                $query->where('branch_id', $branch->id);
            }else {
                $query->where('user_id', $user->id);
            }
        }
        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {

                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
                if ($key == "reason")
                    $query->where($key,$value );
                if ($key == "order_status_id")
                    $query->where($key,$value );
            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $query->with('user');
        $currentOrders =  $query->paginate($request->get('itemsLimit'));
        return response()->json(compact('currentOrders'));
    }
    public function zipFile($id)
    {
        $pdf = Order::select('pdf_url')->where('route_number_id',$id)->get();
        return response()->json(compact('pdf'));
    }
    public function assignToDriver(Request $request)
    {
        $validatedData = $request->validate([
            'route_number_id' => 'required|min:1|max:32',
            'fleet_id' => 'required|min:1|max:32',
        ]);
        $batch = RouteNumber::find($request->route_number_id);
        $fleet = Fleet::find($request->fleet_id);
        $data =$batch->update(['fleet_id' => $fleet->id,"status" => RouteNumberStatus::ASSIGNED]);
        $fleet->status='busy';
        $fleet->save();
        $orders=$batch->orders;
        foreach ($orders as $order){
            if ($order->fleet_id != null) {
                $order->last_driver = $order->fleet_id;
                $order->assign_order = $order->reassign_order;
                $order->reassign_order = Carbon::now()->format('Y-m-d H:i:s');
            } else {
                $order->assign_order = Carbon::now()->format('Y-m-d H:i:s');
            }
            $order->order_status_id = AOrderStatus::ASSIGNED_TO_DRIVER;
            $order->fleet_id = $fleet->id;
            $order->save();
            $order->status;
            $order->user;
            $commission=new WalletController();
            $commission->Commission($order->kilos_count,$fleet->user_id,$order->id);
            event(new OrderAssigned($order));
            event(new OrderOperation($order));
            event(new AgentEvent($order));
        }
        $message="New Batch Assigned to you ";
        $note=new FCMController();
        $note->SendSignalNotification($fleet->device_token,$message);

        return response()->json(compact('batch'));
    }

    public function reassignToDriver(Request $request)
    {
        $validatedData = $request->validate([
            'route_number_id' => 'required|min:1|max:32',
            'fleet_id' => 'required|min:1|max:32',
        ]);
        $batch = RouteNumber::find($request->route_number_id);
        $fleet = Fleet::find($request->fleet_id);
        $data =$batch->update(['fleet_id' => $fleet->id,"status" => RouteNumberStatus::ASSIGNED]);
        $fleet->status='busy';
        $fleet->save();
        $orders=$batch->orders;
        foreach ($orders as $order){
            if ($order->fleet_id != null) {
                $order->last_driver = $order->fleet_id;
                $order->assign_order = $order->reassign_order;
                $order->reassign_order = Carbon::now()->format('Y-m-d H:i:s');
            } else {
                $order->assign_order = Carbon::now()->format('Y-m-d H:i:s');
            }
            $order->order_status_id = AOrderStatus::ASSIGNED_TO_DRIVER;
            $order->fleet_id = $fleet->id;
            $order->save();
            $order->status;
            $order->user;
            $commission=new WalletController();
            $commission->Commission($order->kilos_count,$fleet->user_id,$order->id);
            event(new OrderAssigned($order));
            event(new OrderOperation($order));
            event(new AgentEvent($order));
        }
        $message="New Batch Assigned to you ";
        $note=new FCMController();
        $note->SendSignalNotification($fleet->device_token,$message);
        return response()->json(compact('batch'));
    }
    public function removeBatch($id)
    {
        $batch = RouteNumber::find($id);
        $batch->delete();
        $orders= Order::where('route_number_id', $id)->get();
        foreach ($orders as $order) {
         $remove=new OrderController();
         $remove->removeOrder($order->id);
        }
        return response()->json(['message' => 'created', 'data' => 'success remove'], 200);
    }
}
