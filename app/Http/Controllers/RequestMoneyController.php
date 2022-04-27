<?php

namespace App\Http\Controllers;

use App\Enums\AOrderStatus;
use App\Fleet;
use App\Http\Controllers\Driver\FCMController;
use App\Money;
use App\Order;
use App\RequestMoney;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestMoneyController extends Controller
{
    public  function index(Request $request)
    {
        try {
            $user = auth()->user();
            $query = RequestMoney::with( 'fleet:id,name');
            if ($user->hasRole('user')) {
                $query->where('user_id', $user->id);
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
                $column = $sorter->column;
                $query->orderBy('balance', $by);
            }
            $orders = $query->paginate($request->get('itemsLimit'));
            return response()->json(compact('orders'));
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public  function update(Request $request)
    {
        try {
            $money=RequestMoney::find($request->id);
            if($request->status==1){
                $fleet=Fleet::find($money->fleet_id);
                if($money->balance > $fleet->balanceFloat ){
                    return response()->json(['message' => 'the amount of money not available on his Wallet'], 500);
                }

                $fleet->withdrawFloat($money->balance,['description'=>$request->get('note')]);
            }
            $money->status=$request->status;
            $money->note=$request->note;
            $money->save();
            $tokens=[];
            array_push($tokens, $fleet->device_token);
            $title = "Pudo";
            $body = $request->status;
            $fcm=new FCMController();
            $fcm->sendNotification($tokens, $body, $title);

            return response()->json($money);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public  function show(Request $request,$id)
    {
        try {
            $user = auth()->user();
            $fleet =Fleet::find($id);
            $balance =$fleet->balanceFloat;
            $query = RequestMoney::where('fleet_id',$id);
            if ($user->hasRole('user')) {
                $query->where('user_id', $user->id);
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
                $column = $sorter->column;
                $query->orderBy('balance', $by);
            }
            $orders = $query->paginate($request->get('itemsLimit'));
            return response()->json(compact('orders','balance','fleet'));
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public  function rules(Request $request)
    {
        $validator = Validator::make($request->all(), [  //validate inputs
            'max_money' => 'required|numeric',
            'week' => 'required|numeric'
        ]);
        if ($validator->fails()) {  // in case validator failed
            return response()->json(['status' => false, 'message' => 'required inputs', 'data' => $validator->errors()], 400);
        }
            $user = auth()->user();
            if ($user->hasRole('user')) {
               return abort(401);
            }
            $role= Money::find(1);
            $role->max_money=$request->max_money;
            $role->week=$request->week;
            $role->save();
             return response()->json([$role]);

    }
    public  function edit(Request $request)
    {
            $user = auth()->user();
            if ($user->hasRole('user')) {
               return abort(401);
            }
            $role= Money::find(1);
            return response()->json([compact('role')]);

    }
}
