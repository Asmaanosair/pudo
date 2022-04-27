<?php

namespace App\Http\Controllers\Agent;

use App\Branch;
use App\Commission;
use App\Enums\AOrderStatus;
use App\Events\NewOrder;
use App\Events\OrderAssigned;
use App\Events\OrderOperation;
use App\Fleet;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Driver\FCMController;
use App\Http\Controllers\Driver\WalletController;
use App\Order;
use App\Products;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Gd\Driver;

class OrderController extends Controller
{
    /**
     * @group Integration API
     * Create an Order
     *  use this API to send an order to Pudo control panel
     * @bodyParam  api_id string required your API ID Example: GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.
     * @bodyParam  branch_id  string required The branch_id of the Branch to be the same on your system Example: 342334.
     * @bodyParam  order_price double required the price of the order products without any discounts or fees Example: 40.
     * @bodyParam  discount double the discount amount Example: 0.
     * @bodyParam  address string  required the string  Example: street Address
     * @bodyParam  number_of_products number the discount amount Example: 4
     * @bodyParam  deliver_fees double required the delivery fees amount Example: 10.
     * @bodyParam  pay_on_pickup double required the pay on pickup amount Example: 10.
     * @bodyParam  collect_on_delivery double required the collect on delivery amount Example: 10.
     * @bodyParam Payment Method
            COD =>Cash On Delivery = 1
            PaymentType should be 1 or 2 or 3
            1 => Pay Cash
            2 => Pay By Driver Wallet
            3 => Not Paying

            Payment Method
            Prepaid = 2
            PaymentType should be 3 or 4
            3 => Not Paying
            4 => Paying on picked up
     * @bodyParam  pick_up_lng string the longitude value for the pickup location Example: 21.24354345.
     * @bodyParam  pick_up_lat string the latitude value for the pickup location Example: 21.24354345.
     * @bodyParam  shipment_number number required the shipment_number Example: 44343.
     * @bodyParam  shipment_weight string optional the shipment_weight Example: 2kg.
     * @bodyParam  delivery_lng string required the longitude value for the delivery location Example: 21.24354345.
     * @bodyParam  delivery_lat string required the latitude value for the delivery location Example: 22.134566566.
     * @bodyParam  customer_name string the name of the customer needs the order Example salem:.
     * @bodyParam  customer_mobile string the mobile of the customer needs the order Example: 1234567890.
     * @bodyParam  delivery_time dateTime required must be like  Example: 2020-03-01 16:22:11.
     * @bodyParam  products Array the list of products will be in this order Example: [{"name":"product name","quantity": 2,"note":"if any note or leave it null"},{"name":"product name","quantity": 2,"note":"if any note or leave it null"}].
     */
    public function create(Request $request){
        $validatedData = Validator::make($request->all(),[
            'order_price' => 'required|numeric',
            'api_id' => 'required',
            'address' => 'required',
            'shipment_number' => 'required|numeric',
            'number_of_products' => 'required|numeric',
            'discount' => 'required|numeric',
            'deliver_fees' => 'required|numeric',
            'pay_on_pickup' => 'required|numeric',
            'collect_on_delivery' => 'required|numeric',
            'delivery_lng' => 'required|min:1',
            'delivery_lat' => 'required|numeric|min:1',
            'pick_up_lng' => 'required|numeric|min:1',
            'pick_up_lat' => 'required|numeric|min:1',
            'customer_name' => 'required|min:1',
            'customer_mobile' => 'required|min:1',
            'delivery_time' => 'required|min:1',
            'payment_method'=> 'required|min:1',
            'payment_type'=> 'required|min:1',
            'branch_id'=> 'required|numeric',
            'products'=> 'array',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validatedData->errors()], 402);
        }

        $inputs = $request->all();
        $user = $request->client;
        $city = Helper::getCityByPoint($inputs['delivery_lng'].' '.$inputs['delivery_lat']);
         if (!isset($city->id)){
             return response()->json(['error'=>"the location of delivery you set doesn't refer to any point inside Saudi Arabia"],400);
         }
        $inputs['user_id'] = $user->id;
        $inputs['order_status_id'] = 1;
        $inputs['code'] =$request->shipment_number;
        $inputs['city_id'] = $city->id;
        $result = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=heading=90:" . $request->pick_up_lat . "," . $request->pick_up_lng . "&destinations=" . $request->delivery_lat . "," . $request->delivery_lng . "&mode=driving&key=AIzaSyBChUzS-ZK4363fr2b_CAvd-zMYugstSWQ")->json();

        if ($result["status"] == "OK") {
            $kilos_count = $result["rows"][0]["elements"][0]["distance"]["value"] / 1000;
            // $kilos_count = 10;
            $inputs['kilos_count'] = $kilos_count;
            $client = User::find($user->id);
            $fees_id = $client->commission_id;
            $fees = Commission::find($fees_id);
            $diffrence = $inputs['kilos_count'] - $fees->distance;
            $inputs['commission'] = '0';
            if ($fees->type == 1) {
                $kilos_total_price = $fees->price;
                if ($diffrence > 0) {
                    $kilos_total_price = $fees->price + ($diffrence * $fees->price_more_kilo);
                    if ($kilos_total_price > $fees->max_cost) {
                        $kilos_total_price = $fees->max_cost;
                    }
                }
                $inputs['kilos_total_price'] = substr($kilos_total_price, 0, 5);
            } else {
                $inputs['kilos_total_price'] = $fees->price;
            }

            if ($inputs['deliver_fees'] == '0' || $inputs['deliver_fees'] == 'null') {

                $inputs['deliver_fees'] = $inputs['collect_on_delivery'] - $inputs['pay_on_pickup'];
            }
            $inputs['total_price']=$inputs['order_price']-$inputs['discount'];
            $inputs['total_price'] += $inputs['deliver_fees'];

            $inputs['order_status_id'] = 1;

            // $inputs['delivery_time']  = '2021-07-12 08:53:42';

            // $inputs['kilos_total_price']  = 150;

            $order = Order::create($inputs);
                    if ($request->has('products')){
            foreach ($inputs['products'] as $product){
                $product['order_id']= $order->id;
                Products::create($product);
            }
        }
            $order->status;
            $order->user;

            $fcm = new FCMController();
            $fcm->assignOrder($order->id, $request->pick_up_lat, $request->pick_up_lng, 4);

            event(new OrderOperation($order));
            return response()->json(['message' => 'created', 'data' => $order], 200);
            //        }
        } else {
            return response()->json(['message' => 'Failed because API_KEY of Map'], 500);
        }




    }


    /**
     * @group Integration API
     * Update an Order
     *  use this API to update an order programmatically on Pudo.
     * @bodyParam  api_id string required your API ID Example: GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.
     * @bodyParam  Order_id  string required The Order_id of the order to be the same on your system Example: 342334.
     * @bodyParam  order_price double required the price of the order products without any discounts or fees Example: 40.
     * @bodyParam  discount double the discount amount Example: 0.
     * @bodyParam  number_of_products number the discount amount Example: 4
     * @bodyParam  deliver_fees double required the delivery fees amount Example: 10.
     * @bodyParam Payment Method
    COD =>Cash On Delivery = 1
    PaymentType should be 1 or 2 or 3
    1 => Pay Cash
    2 => Pay By Driver Wallet
    3 => Not Paying

    Payment Method
    Prepaid = 2
    PaymentType should be 3 or 4
    3 => Not Paying
    4 => Paying on picked up
     * @bodyParam  pick_up_lng string the longitude value for the pickup location Example: 21.24354345.
     * @bodyParam  pick_up_lat string the latitude value for the pickup location Example: 21.24354345.
     * @bodyParam  delivery_lng string required the longitude value for the delivery location Example: 21.24354345.
     * @bodyParam  delivery_lat string required the latitude value for the delivery location Example: 22.134566566.
     * @bodyParam  customer_name string the name of the customer needs the order Example salem:.
     * @bodyParam  customer_mobile string the mobile of the customer needs the order Example: 1234567890.
     * @bodyParam  delivery_time dateTime required must be like  Example: 2020-03-01 16:22:11
     * @bodyParam  shipment_number number required the shipment_number Example: 44343.
     * @bodyParam  shipment_weight string optional the shipment_weight Example: 2kg.

     */

    public function update(Request $request){
        $validatedData = Validator::make($request->all(),[
            'order_price' => 'required|numeric',
            'api_id' => 'required',
            'shipment_number' => 'required|numeric',
            'order_id' => 'required|numeric',
            'number_of_products' => 'required|numeric',
            'discount' => 'required|numeric',
            'deliver_fees' => 'required|numeric',
            'delivery_lng' => 'required|min:1',
            'delivery_lat' => 'required|numeric|min:1',
            'pick_up_lng' => 'required|numeric|min:1',
            'pick_up_lat' => 'required|numeric|min:1',
            'customer_name' => 'required|min:1',
            'customer_mobile' => 'required|min:1',
            'delivery_time' => 'required|min:1',
            'payment_method'=> 'required|min:1',
            'payment_type'=> 'required|min:1',
            'branch_id'=> 'required|numeric',
            'address'=> 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validatedData->errors()], 402);
        }


        $user = $request->client;

        $result = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=heading=90:" . $request->pick_up_lat . "," . $request->pick_up_lng . "&destinations=" . $request->delivery_lat . "," . $request->delivery_lng . "&key=AIzaSyBChUzS-ZK4363fr2b_CAvd-zMYugstSWQ")->json();

        $inputs = $request->all();

        if ($result["status"] == "OK") {
            $kilos_count = $result["rows"][0]["elements"][0]["distance"]["value"] / 1000;
            $inputs['kilos_count'] = $kilos_count;

            $fees_id = $user->commission_id;
            $fees = Commission::find($fees_id);

            $diffrence = $inputs['kilos_count'] - $fees->distance;

            if ($fees->type == 1) {
                $kilos_total_price = $fees->price;
                if ($diffrence > 0) {
                    $kilos_total_price = $fees->price + ($diffrence * $fees->price_more_kilo);
                    if ($kilos_total_price > $fees->max_cost) {
                        $kilos_total_price = $fees->max_cost;
                    }
                }
                $inputs['kilos_total_price'] = substr($kilos_total_price, 0, 5);
            } else {
                $inputs['kilos_total_price'] = $fees->price;
            }
            $inputs['total_price']=$inputs['order_price']-$inputs['discount'];

            $inputs['total_price'] += $inputs['deliver_fees'];

            $data=  Order::where('user_id',$user->id)->where('id',$request->get('order_id'))->first();

            if($data==null) {
                return response()->json(['message' => 'Id Not Valid', 'data' => $data], 200);
            }
            $inputs['code'] = $request->shipment_number;
            $order =$data->update($inputs);

          //  event(new OrderOperation($order));

            return response()->json(['message' => 'updated', 'data' => $order], 200);
        }
    }

     /**
      * @group Integration API
      * Delete an Order
      *  use this API to delete an order programmatically from Pudo.
      * @bodyParam  api_id string required your API ID Example: GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.
      * @bodyParam  order_id  string required The order_id of the order to be the same on your system Example: 342334.
      * */
    public function delete(Request $request){

        $validatedData = $request->validate([
            'order_id' => 'required|numeric',
        ]);

        $user = $request->client;

      Order::where('user_id',$user->id)->where('id',$request->get('order_id'))->delete();

        return response()->json(['message'=>'deleted', 'data'=>[]],200);
    }

    /**
     * @group Integration API
     * Assign Order to a driver
     *  this api to assign and order already existing on Pudo to a driver
     * @bodyParam  api_id string required your API ID Example: GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.
     * @bodyParam  order_id  string required The order_id of the order to be the same on your system Example: 342334.
     * @bodyParam  driver_id required The order_id of the driver Example: 65435.
     * */
    public function assignToDriver(Request $request){
        $validatedData = $request->validate([
            'order_id' => 'required|numeric',
            'driver_id' => 'required|numeric',
        ]);
        $user = $request->client;
        $order = Order::where('user_id',$user->id)->where('id',$request->get('order_id'))->first();
        $fleet = Fleet::where('id',$request->get('driver_id'))->first();
        if ($order->fleet_id != null){
            return response()->json(['message'=>'the order already assigned to a driver','error'=>true],400);
        }
        if ($fleet == null){
            return response()->json(['message'=>'Driver Id Is In correct','error'=>true],400);
        }
        $order->fleet_id = $fleet->id;
        $order->order_status_id = AOrderStatus::ASSIGNED_TO_DRIVER;
        $order->save();
        $order->status;
        $commission = new WalletController();
        $commission->Commission($order->kilos_count, $fleet->user_id, $order->id);

        event(new OrderAssigned($order));
        event(new OrderOperation($order));

        return response()->json(['message'=>'assigned', 'data'=>$order],200);
    }


    /**
     * @group Integration API
     * Reassign Order to another Driver
     *  this api to reassign and order already existing on Pudo and assigned to a driver to another driver
     * @bodyParam  api_id string required your API ID Example: GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.
     * @bodyParam  order_id  string required The order_id of the order to be the same on your system Example: 342334.
     * @bodyParam  driver_id required The code of the driver Example: 65435.
     * */
    public function reassignToDriver(Request $request){
        $validatedData = $request->validate([
            'order_id' => 'required|numeric',
            'driver_id' => 'required|numeric',
        ]);
        $user = $request->client;
        $order = Order::where('user_id',$user->id)->where('id',$request->get('order_id'))->first();
        $fleet = Fleet::where('id',$request->get('driver_id'))->first();
        if ($fleet == null){
            return response()->json(['message'=>'Driver Id Is In correct','error'=>true],400);
        }
        $order->fleet_id = $fleet->id;
        $order->order_status_id = AOrderStatus::ASSIGNED_TO_DRIVER;
        $order->save();
        $order->status;
        $commission = new WalletController();
        $commission->Commission($order->kilos_count, $fleet->user_id, $order->id);
        event(new OrderAssigned($order));
        event(new OrderOperation($order));
        return response()->json(['message'=>'assigned', 'data'=>$order],200);
    }

    /**
     * @group Integration API
     *  Show  Order Details
     * @bodyParam  api_id string required your API ID Example: GZUdkhoBCB28zVZRdljnwMUs67S2kNz821r4yKX3QzUWLnvWEM8tIlulfU4UMkHY.
     * @bodyParam  order_id  string required The order_id of the order to be the same on your system Example: 342334.

     * */
    public function show(Request $request){
        $validatedData = $request->validate([
            'order_id' => 'required|min:1|max:32',
            'api_id' => 'required',
        ]);
        $user = $request->client;
        $order = Order::with('fleet','products','status','user')->where('user_id',$user->id)->whereId($request->order_id)->get();
        return response()->json(['message'=>'success', 'data'=>$order],200);
    }
}
