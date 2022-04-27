<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Client;
use App\Commission;
use App\Console\Commands\AssignOrder;
use App\Enums\AOrderStatus;
use App\Enums\DriverApply;
use App\Enums\OrderReason;
use App\Enums\PaymentMethod;
use App\Enums\RouteNumberStatus;
use App\Events\AgentEvent;
use App\Events\NewOrder;
use App\Events\OrderAssigned;
use App\Events\OrderOperation;
use App\Fleet;
use App\Helper;
use App\Http\Controllers\Driver\FCMController;
use App\Http\Controllers\Driver\WalletController;
use App\Invoice;
use App\Jobs\ReassignOrder;
use App\Jobs\RouteNumber;
use App\Order;
use App\OrderStatus;
use App\Products;
use App\RealCommission;
use App\User;
use Bavix\Wallet\Interfaces\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Importer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;


class OrderController extends Controller
{
    public function currentOrders(Request $request)
    {
        $user = auth()->user();
        $query = Order::with('status');
        if ($user->hasRole('user')) {
            if ($user->menuroles == 'client-branch') {
                $branch = Branch::where('manager_id', $user->id)->first();
                $query->where('branch_id', $branch->id);
            } else {
                $query->where('user_id', $user->id);
            }
        }
        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {

                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
                if ($key == "reason")
                    $query->where($key, $value);
                if ($key == "order_status_id")
                    $query->where($key, $value);
            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $query->with('user');
        $currentOrders = $query->paginate($request->get('itemsLimit'));
        return response()->json(compact('currentOrders'));
    }

    public function issueOrders(Request $request)
    {


        $user = auth()->user();
        $query = Order::with('status');
        if ($user->hasRole('user')) {
            if ($user->menuroles == 'client-branch') {
                $branch = Branch::where('manager_id', $user->id)->first();
                $query->where('branch_id', $branch->id);
            } else {
                $query->where('user_id', $user->id);
            }
        }
        $cat = OrderStatus::select('id')->where('category_id', 2)->get();
        $catID = [];
        foreach ($cat as $test) {
            array_push($catID, $test->id);
        }
        $query->whereIn(
            'order_status_id',
            $catID
        );

        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {
                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
                if ($key == "reason")
                    $query->where($key, $value);
                if ($key == "order_status_id")
                    $query->where($key, $value);

            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $query->with('user');

        $issueOrders = $query->paginate($request->get('itemsLimit'));


        return response()->json(compact('issueOrders'));
    }

    public function progressOrder(Request $request)
    {
        $user = auth()->user();
        $query = Order::with('status');
        if ($user->hasRole('user')) {
            if ($user->menuroles == 'client-branch') {
                $branch = Branch::where('manager_id', $user->id)->first();
                $query->where('branch_id', $branch->id);
            } else {
                $query->where('user_id', $user->id);
            }
        }
        $cat = OrderStatus::select('id')->where('category_id', 3)->get();
        $catID = [];
        foreach ($cat as $test) {
            array_push($catID, $test->id);
        }
        $query->whereIn(
            'order_status_id',
            $catID
        );

        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {
                if ($value != "")
                    $query->where($key, 'LIKE', '%' . $value . '%');
                if ($key == "reason")
                    $query->where($key, $value);
                if ($key == "order_status_id")
                    $query->where($key, $value);

            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $query->with('user');

        $progressOrders = $query->paginate($request->get('itemsLimit'));

        return response()->json(compact('progressOrders'));
    }

    public function previousOrder(Request $request)
    {
        $user = auth()->user();
        $query = Order::with('status');
        if ($user->hasRole('user')) {
            if ($user->menuroles == 'client-branch') {
                $branch = Branch::where('manager_id', $user->id)->first();
                $query->where('branch_id', $branch->id);
            } else {
                $query->where('user_id', $user->id);
            }
        }
        $cat = OrderStatus::select('id')->where('category_id', 1)->get();
        $catID = [];
        foreach ($cat as $test) {
            array_push($catID, $test->id);
        }
        $query->whereIn(
            'order_status_id',
            $catID
        );
        if ($request->has('columnFilter')) {
            $columnFilters = json_decode($request->columnFilter, true);
            foreach ($columnFilters as $key => $value) {
                if ($value != "")

                    $query->where($key, 'LIKE', '%' . $value . '%');
                if ($key == "reason")
                    $query->where($key, $value);
                if ($key == "order_status_id")
                    $query->where($key, $value);

            }
        }
        if ($request->has('sorter')) {
            $sorter = json_decode($request->sorter);
            $by = $sorter->asc == true ? 'ASC' : 'DESC';
            $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $query->with('user');
        $previousOrders = $query->paginate($request->get('itemsLimit'));

        return response()->json(compact('previousOrders'));
    }

    public function allStatuses()
    {
        $statuses = OrderStatus::all()->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 68, 54, 53]);
        $user = auth('api')->user();
        return response()->json(compact('statuses', 'user'));
    }

    public function create()
    {
        $clients = User::all()->whereIn('menuroles', ['client']);
        $user = auth('api')->user();
        return response()->json(compact('clients', 'user'));
    }

    public function changeStatus($orderId, Request $request)
    {
        if ($request->get('status_id') == AOrderStatus::FAILED) {
            return response()->json(['message' => 'no Changes']);
        }
        $query = Order::where('id', $orderId);
        $query->update(["order_status_id" => $request->get('status_id')]);
        $order = $query->first();

        $order->user;
        $order->status;
        event(new OrderOperation($order));
        event(new AgentEvent($order));
        $wallet = new WalletController();
        if ($order->payment_method == PaymentMethod::ONLINE_PAYMENT) {
            $wallet->PrepaidWallet($order->payment_type, $order);
        } elseif ($order->payment_method == PaymentMethod::CASH_ON_DELIVERY) {

            $wallet->CODWallet($order->payment_type, $order);
        }
        return response()->json(compact('order'));
    }

    public function show($id)
    {
        $order = Order::with('products','fleet','branch','invoice')->find($id);
        $last_driver = $order->last_driver;
        $order['Order Status'] = $order->status->name;
        if($order->city!=null){
            $order['City'] = $order->city->name;
            if($order->city->country!=null) {
                $order['Country'] = $order->city->country->name;
            }
            }
        if($order->patch!=null) {
            $order['Route Number'] = $order->patch->route_number;
        }
        $order['shipment_number'] = $order->code;
        $order ->makeHidden(['created_at','updated_at','code','patch','city','status',
            'city_id','fleet_id','order_status_id','user_id','pdf_status','branch_id','route_number_id','status:status.category_id'
        ]);
        if ($last_driver!=null) {
            $fleet_name = Fleet::find($order->last_driver);
           if($fleet_name!=null) {
               $order->last_driver_name = $fleet_name->name;
           }
        }
        if ($order->fleet_id!=null) {
            $current_fleet = Fleet::find($order->fleet_id);
            if($current_fleet!=null) {
                $order->current_driver_name = $current_fleet->name;
            }

        }
        return response()->json(compact('order'));
    }

    public function assignToDriver(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|min:1|max:32',
            'fleet_id' => 'required|min:1|max:32',
        ]);
        $user = auth()->user();
        $order = Order::find($request->order_id);
        $routeNumber = random_int(1111111, 999999999);
        $patch = new \App\RouteNumber();
        $patch->route_number = $routeNumber;
        $patch->save();
        $fleet = Fleet::find($request->fleet_id);
        if ($order->fleet_id != null) {
            $order->last_driver = $order->fleet_id;
            $order->assign_order = $order->reassign_order;
            $order->reassign_order = Carbon::now()->format('Y-m-d H:i:s');
        } else {
            $order->assign_order = Carbon::now()->format('Y-m-d H:i:s');
        }
//                if ($order->fleet_id != null){
//                    return response()->json(['message'=>'the order already assigned to a driver','error'=>true],400);
//                }
        $order->fleet_id = $request->fleet_id;
        $order->route_number_id = $patch->id;
        $order->save();
        $order->patch;
        $order->user;
        $order->city;
        $order->branchWithCity;
        $order->status;
        $order->branch;
        $order->order_status_id = AOrderStatus::ASSIGNED_TO_DRIVER;
        Storage::disk('s3')->delete($order->pdf_url);
        $pdf = \PDF::loadView('shipment', compact('order'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a6', 'landscape');
        $fileName = "Order_" . $order->id . '_' . $routeNumber . '.pdf';
        $pdfFilePath = 'orderPatch/';
        Storage::disk('s3')->put($pdfFilePath . $fileName, $pdf->output(), 'public');
        $order->pdf_url = $fileName;
        $order->pdf_status = 1;
        $order->save();
        $patch->branch_id = $order->branch_id;
        $patch->fleet_id = $request->fleet_id;
        $patch->pdf_status = 1;
        $patch->status = RouteNumberStatus::ASSIGNED;
        $patch->save();
        $commission = new WalletController();
        $commission->Commission($order->kilos_count, $fleet->user_id, $order->id);
        event(new OrderAssigned($order));
        event(new OrderOperation($order));
        event(new AgentEvent($order));
        return response()->json(compact('order', 'fleet'));
    }

    public function reassignToDriver(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|min:1|max:32',
            'fleet_id' => 'required|min:1|max:32',
        ]);
        $user = $request->client;
        $order = Order::where('user_id', $user->id)->where('id', $request->get('order_id'))->first();
        $fleet = Fleet::where('id', $request->get('fleet_id'))->first();
        $order->fleet_id = $fleet->id;
        $order->order_status_id = AOrderStatus::ASSIGNED_TO_DRIVER;
        $order->save();
        $order->user;
        $order->status;
        $commission = new WalletController();
        $commission->Commission($order->kilos_count, $fleet->user_id, $order->id);
        event(new OrderAssigned($order));
        event(new AgentEvent($order));
        event(new OrderOperation($order));
        return response()->json(compact('order', 'fleet'));
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if (!$validator->fails()) {
            $file = $request->file('file');
            $excel = Importer::make('Excel');
            $excel->Load($file);
            $collection = $excel->getCollection();

            for ($row = 1; $row < sizeof($collection); $row++) {
                try {
                    $main_inputs = [];
                    $inputs_text = $collection[0];
                    $inputs_value = $collection[$row];
                    for ($j = 0; $j < sizeof($collection[0]); $j++) {
                        $main_inputs[trim($inputs_text[$j])] = $inputs_value[$j];
                    }
                    $branch = [];
                    $city = Helper::getCityByPoint($main_inputs['delivery_lng'] . ' ' . $main_inputs['delivery_lat']);

                    if (!isset($city->id)) {
                        return response()->json(['message' => ['time' => ['the location of delivery not Valid']]], 400);
                    }
                    $main_inputs['city_id'] = $city->id;
                    $user = auth('api')->user();
                    if ($user->menuroles == 'client-branch') {
                        // manager_id is the id of Manager Of branch
                        $client = '';
                        $branch = Branch::where('manager_id', $user->id)->first();
                        $main_inputs['user_id'] = $branch->user_id;
                        $main_inputs['branch_id'] = $branch->id;
                    } elseif ($user->menuroles == 'client') {
                        $client = '';
                        $main_inputs['user_id'] = $user->id;
                    } else {
                        $client = ['required', 'exists:users,id'];
                        if (isset($main_inputs['client_id'])) {
                            $main_inputs['user_id'] = $main_inputs['client_id'];
                        }
                    }
                    $branch = ['required', 'exists:branches,id'];
                    $validation_inputs = Validator::make($main_inputs, [
                        'customer_name' => 'required',
                        'customer_mobile' => 'required',
                        'order_price' => 'required',
                        'discount' => 'required',
                        "address" => 'required',
                        'delivery_time' => 'required',
                        'deliver_fees' => 'required',
                        'pay_on_pickup' => 'required',
                        'collect_on_delivery' => 'required',
                        'delivery_lat' => 'required',
                        'delivery_lng' => 'required',
                        'payment_method' => 'required',
                        'payment_type' => 'required',
                        "user_id" => $client,
                        "branch_id" => $branch
                    ]);

                    $findBranch = Branch::find($main_inputs['branch_id']);
                    $main_inputs['pick_up_lat'] = $findBranch->pickup_lat;
                    $main_inputs['pick_up_lng'] = $findBranch->pickup_lng;
                    if ($validation_inputs->fails()) {
                        $errors = $validation_inputs->errors();
                        return view('errors', ['my_errors' => $errors]);
                    }
                    $latFrom = $main_inputs['pick_up_lat'];
                    $lonFrom = $main_inputs['pick_up_lng'];
                    $latTo = $main_inputs['delivery_lat'];
                    $lonTo = $main_inputs['delivery_lng'];
                    $result = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=heading=90:" . $latFrom . "," . $lonFrom . "&destinations=" . $latTo . "," . $lonTo . "&key=AIzaSyBChUzS-ZK4363fr2b_CAvd-zMYugstSWQ")->json();
                    if ($result["status"] == "OK") {
                        $kilos_count = $result["rows"][0]["elements"][0]["distance"]["value"] / 1000;
                        $main_inputs['kilos_count'] = $kilos_count;
                        $clientdata = User::find($main_inputs['user_id']);
                        $fees_id = $clientdata->commission_id;
                        $fees = Commission::find($fees_id);
                        $diffrence = $main_inputs['kilos_count'] - $fees->distance;
                        if ($fees->type == 1) {
                            $kilos_total_price = $fees->price;
                            if ($diffrence > 0) {
                                $kilos_total_price = $fees->price + ($diffrence * $fees->price_more_kilo);
                            }
                            $main_inputs['kilos_total_price'] = substr($kilos_total_price, 0, 5);
                        } else {
                            $main_inputs['kilos_total_price'] = $fees->price;
                        }
                        if ($main_inputs['deliver_fees'] == '0' || $main_inputs['deliver_fees'] == 'null') {

                            $main_inputs['deliver_fees'] = $main_inputs['collect_on_delivery'] - $main_inputs['pay_on_pickup'];
                        }
                        $main_inputs['order_status_id'] = 1;
                        $main_inputs['total_price'] = ($main_inputs['order_price'] - $main_inputs['discount']) + $main_inputs['deliver_fees'];
                        $main_inputs['code'] = $main_inputs['shipment_number'];
                        $main_inputs['commission'] = '0';
                        Order::create($main_inputs);
                        $job = (new RouteNumber());
                        dispatch($job);
                    }
                } catch (\Exception  $e) {
                    return response()->json([$e->getMessage()], 500);
                }
            }
            return redirect('/#/orders');
            {
            }
        } else {
            return redirect()->back()->with(['errors' => $validator->errors()->all()]);
        }
    }

    public function createOrder(Request $request)
    {
        $user = auth('api')->user();
        $client = [];
        $branch = [];
        $client_id = '';
        $branch_id = '';
        // user_id is the id of client
        // manager_id is the id of Manager Of branch
        if ($user->menuroles == 'client') {
            $branch = ['required'];
            $client_id = $user->id;
            $branch_id = $request->branch_id;
        } elseif ($user->menuroles == 'client-branch') {
            $branch = Branch::where('manager_id', $user->id)->first();
            $client_id = $branch->user_id;
            $branch_id = $branch->id;
        } else {
            $branch_id = $request->branch_id;
            $client_id = $request->client_id;
            $client = ['required'];
            $branch = ['required'];
        }
        $validator = Validator::make($request->all(), [  //validate inputs
            "customer_name" => 'required',
            "customer_mobile" => 'required',
            "order_price" => 'required|numeric',
            "payment_type" => 'required',
            "address" => 'required',
            "payment_method" => 'required',
            "timeNow" => 'required',
            "client_id" => $client,
            "branch_id" => $branch,
            "delivery_time" => 'required|date|after_or_equal:now|date_format:m/d/Y H:i',
            "delivery_lng" => 'required',
            "delivery_lat" => 'required',

        ]);
        if ($validator->fails()) {
            // in case validator failed

            return response()->json(['message' => $validator->errors()], 500);
        }
        $city = Helper::getCityByPoint($request->delivery_lng . ' ' . $request->delivery_lat);
        if (!isset($city->id)) {
            return response()->json(['message' => ['error' => ['the location of delivery not Valid']]], 400);
        }

        $TimeNow = Carbon::parse($request->timeNow)->format('m/d/Y H:i');

        $Delivery_time = Carbon::parse($request->delivery_time)->format('m/d/Y H:i');
        if ($TimeNow >= $Delivery_time) {  // in case validator failed
            return response()->json(['message' => ['time' => ['the Delivery Time is not correct']]], 500);
        }
        $inputs = $request->all();
        $inputs['city_id'] = $city->id;
        $findBranch = Branch::find($branch_id);
        $inputs['pick_up_lat'] = $findBranch->pickup_lat;
        $inputs['pick_up_lng'] = $findBranch->pickup_lng;
        $result = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=heading=90:" . $findBranch->pickup_lat . "," . $findBranch->pickup_lng . "&destinations=" . $request->delivery_lat . "," . $request->delivery_lng . "&mode=driving&key=AIzaSyBChUzS-ZK4363fr2b_CAvd-zMYugstSWQ")->json();
        if ($result["status"] == "OK") {
            $kilos_count = $result["rows"][0]["elements"][0]["distance"]["value"] / 1000;
            $inputs['kilos_count'] = $kilos_count;
            $inputs['user_id'] = $client_id;
            $inputs['branch_id'] = $branch_id;
            $client = User::find($client_id);
            $fees_id = $client->commission_id;
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
            if ($inputs['deliver_fees'] == '0' || $inputs['deliver_fees'] == 'null') {
                $inputs['deliver_fees'] = $inputs['collect_on_delivery'] - $inputs['pay_on_pickup'];
            }
            $inputs['total_price'] += $inputs['deliver_fees'];
            $inputs['order_status_id'] = AOrderStatus::NEW_ORDER;
            $inputs['commission'] = '0';

            $order = Order::create($inputs);
            $products = json_decode($request->products);
            if ($products) {
                foreach ($products as $product) {
                    $product = (array)$product;
                    $product['order_id'] = $order->id;
                    Products::create($product);
                }
            }
            $order->status;
            $order->user;

            $job = (new RouteNumber());
            dispatch($job);
            event(new OrderOperation($order));
            return response()->json(['message' => 'created', 'data' => $order], 200);
            //        }
        } else {
            return response()->json(['message' => 'Failed because API_KEY of Map'], 500);
        }
    }

    public function editOrder($id)
    {
        $order = Order::find($id);
        $order->products;
        return response()->json(['message' => 'created', 'data' => $order], 200);
    }

    public function updateOrder(Request $request, $id)
    {
        $result = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=heading=90:" . $request->pick_up_lat . "," . $request->pick_up_lng . "&destinations=" . $request->delivery_lat . "," . $request->delivery_lng . "&key=AIzaSyBChUzS-ZK4363fr2b_CAvd-zMYugstSWQ")->json();
        $inputs = $request->all();
        if ($result["status"] == "OK") {
            $kilos_count = $result["rows"][0]["elements"][0]["distance"]["value"] / 1000;
            $inputs['kilos_count'] = $kilos_count;
            $order = Order::find($id);
            $user = auth()->user();
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
            $inputs['total_price'] += $inputs['deliver_fees'];
            $order->update($inputs);
            return response()->json(['message' => 'created', 'data' => $order], 200);
        }
    }

    public function allOrders()
    {
        $orders = Order::all();
        return response()->json(['message' => 'created', 'data' => $orders], 200);
    }

    public function removeOrder($id)
    {
        $order = Order::find($id);
        Storage::disk('s3')->delete($order->pdf_url);
        $order->delete();
        $products = Products::where('order_id', $id)->get();
        $invoices= Invoice::where('order_id', $id)->get();
        foreach ($products as $product) {
            $product->delete();
        }
        foreach ($invoices as $invoice) {
                 Storage::disk('s3')->delete($invoice->file_path);
                $invoice->delete();
        }
        return response()->json(['message' => 'created', 'data' => 'success remove'], 200);
    }

    public function sendReason($orderId, Request $request)
    {
        $order = Order::find($orderId);
        $order->order_status_id = AOrderStatus::FAILED;
        $order->reason = $request->get('reason');
        $order->save();

        if (in_array($request->get('reason'), [OrderReason::Driver_Refused_To_Deliver_Assign_Order, OrderReason::Driver_Is_Not_Responding_Assign_Order])) {
            ReassignOrder::dispatch($orderId)
                ->delay(now()->addMinutes(15));
        } elseif (in_array($request->get('reason'), [OrderReason::Driver_Refused_To_Deliver_On_The_Way_To_Pickup, OrderReason::Driver_Canceled_Assign_Order])) {
            ReassignOrder::dispatch($orderId)
                ->delay(now()->addMinutes(30));
        } elseif (in_array($request->get('reason'), [OrderReason::Driver_Canceled_On_The_Way_To_Pickup])) {
            ReassignOrder::dispatch($orderId)
                ->delay(now()->addMinutes(60));
        } elseif (in_array($request->get('reason'), [OrderReason::Car_Issues_Assign_Order,
            OrderReason::Abnormal_Weather_Assign_Order,
            OrderReason::Order_Disappeared_From_The_Driver_App_Assign_Order,
            OrderReason::Mistake_In_Dispatching_Logic_Assign_Order,
            OrderReason::Car_Issues_On_The_Way_To_Pickup,
            OrderReason::Abnormal_Weather_On_The_Way_To_Pickup,
            OrderReason::Order_Disappeared_From_The_Driver_App_On_The_Way_To_Pickup,
            OrderReason::Mistake_In_Dispatching_Logic_On_The_Way_To_Pickup,
            OrderReason::Missing_Order_Information_In_The_Driver_App_On_The_Way_To_Pickup,
            OrderReason::Driver_Stopped_By_The_Police_On_The_Way_To_Pickup,
        ])) {
            ReassignOrder::dispatch($orderId);
        }
        $wallet = new WalletController();
        if (in_array($request->reason, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])) {
            if ($order->payment_method == PaymentMethod::ONLINE_PAYMENT) {
                $wallet->PrepaidWallet($order->payment_type, $order);
            } elseif ($order->payment_method == PaymentMethod::CASH_ON_DELIVERY) {

                $wallet->CODWallet($order->payment_type, $order);
            }
        }

        return response()->json(['message' => 'send reason successfully'], 200);
    }

    public function statusOrder($id, Request $request)
    {
        $order = Order::find($id);
        $order_status = ["on_the_way_to_pickup", "near_pikup_location", "reach_pickup_location", "on_the_way_to_dropoff", "near_dropoff_location", "reach_customer"];
        foreach ($order_status as $key) {
            if ($request[$key] != null and $request[$key] != '' and $request[$key] != 'null') {
                $order->$key = $request[$key];
            }
        }
        $order->save();
        return response()->json(['status' => true, 'message' => 'created', 'data' => $order], 200);
    }

    public function statusOrderDriver($id)
    {
        $order = Order::select('id', 'created_at', 'assign_order', 'on_the_way_to_pickup', 'near_pikup_location', 'reach_pickup_location', 'picked_up_at', 'near_dropoff_location', 'on_the_way_to_dropoff', 'reach_customer', 'delivered_at')->where('id', $id)->first();
        return response()->json(['status' => true, 'message' => 'success', 'data' => $order], 200);
    }
}
