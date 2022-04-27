<?php

namespace App\Http\Controllers;

use App\ApplicationStatus;
use App\Enums\AOrderStatus;
use App\Enums\DriverApply;
use App\Fleet;
use App\Order;
use App\User;
use Carbon\Carbon;
use http\Client;
use DB;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $fleet=DB::table('fleets')->selectRaw('id as value ,name as text')->where('application_status_id',DriverApply::APPROVED_BY_PUDO)->get();
        $client=DB::table('users')->selectRaw('id as value ,company_name as text')->where('menuroles','client')->get();

        return response()->json(compact('client','fleet'));
    }

    public function wallet($id, Request $request){
        $fleet  = Fleet::find($id);
        $user=auth()->user();
        try {
            $balance = $fleet->balanceFloat;
            $transactions = $fleet->transactions();
            if ($request->has('columnFilter')) {
                $columnFilters = json_decode($request->columnFilter, true);
                foreach ($columnFilters as $key => $value) {
                    if ($value != "")
                        $transactions->where($key, 'LIKE', '%' . $value . '%');
                }
            }
            $transactions=  $transactions->orderBy('created_at','DESC')->paginate(20);
            foreach ($transactions as $transaction) {
                $transaction->amount = $transaction->amount / 100;
            }
            $wallet['balance'] = $balance;
            $wallet['transactions'] = $transactions;

            return response()->json(compact('wallet','user'));
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }

    public function withdraw($id, Request $request){
        $fleet  = Fleet::find($id);
        if ($request->get('amount') == 0)
            return response()->json(["message'=>'the Amount mustn't be 0"],400);

        $fleet->withdrawFloat($request->get('amount'),['description'=>$request->get('description')]);
        return response()->json([]);
    }
    public function deposit($id, Request $request){
        $fleet  = Fleet::find($id);
        if ($request->get('amount') == 0)
            return response()->json(["message'=>'the Amount mustn't be 0"],400);

        $fleet->depositFloat($request->get('amount'),['description'=>$request->get('description')]);
        return response()->json([]);
    }
    public function depositClient($id, Request $request){

        $client  = User::find($id);
        if ($request->get('amount') == 0)
            return response()->json(["message'=>'the Amount mustn't be 0"],400);

        $client->depositFloat($request->get('amount'),['description'=>$request->get('description')]);
        return response()->json([]);
    }
    public function withdrawClient($id, Request $request){
        $client  = User::find($id);
        if ($request->get('amount') == 0)
            return response()->json(["message'=>'the Amount mustn't be 0"],400);

        $client->withdrawFloat($request->get('amount'),['description'=>$request->get('description')]);
        return response()->json([]);
    }
    public function walletClient(Request $request,$id){
        $client= User::find($id);
        try {
            $balance = $client->balanceFloat;
            $transactions = $client->transactions();
            if ($request->has('columnFilter')) {
                $columnFilters = json_decode($request->columnFilter, true);
                foreach ($columnFilters as $key => $value) {
                    if ($value != "")
                        $transactions->where($key, 'LIKE', '%' . $value . '%');
                }
            }
            $transactions=  $transactions->orderBy('created_at','DESC')->paginate(20);
            foreach ($transactions as $transaction) {
                $transaction->amount = $transaction->amount / 100;
            }

            $wallet['balance'] = $balance;
            $wallet['transactions'] = $transactions;

            return response()->json(compact('wallet'));
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public function mainWallet(Request $request){
        try {

            $user = auth()->user();
            $query = Order::with('status','fleet','user')->whereNotNull('fleet_id')->whereNotNull('user_id')->whereIn('order_status_id',[
                AOrderStatus::DELIVERED,AOrderStatus::PICKED_UP,AOrderStatus::RETURNED,AOrderStatus::FAILED]);
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
            if ($request->from_date!=null || $request->to_date !=null ) {

                       $startDate = Carbon::parse($request->from_date)->toDateTimeString();
                       $endDate = Carbon::parse($request->to_date)->toDateTimeString();
                        $query->whereBetween('created_at', array($startDate, $endDate));
            }
            if ($request->has('sorter')) {
                $sorter = json_decode($request->sorter);
                $by = $sorter->asc == true ? 'ASC' : 'DESC';
                $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
                $query->orderBy($column, $by);
            }
            $orders =  $query->paginate($request->get('itemsLimit'));
            return response()->json(compact('orders'));
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public function ordersClient(Request $request,$id){
        try {

              $user=User::find($id);
            $query = Order::with('status','fleet')->where('user_id',$id)->whereNotNull('fleet_id');
            if ($request->has('columnFilter')) {
                $columnFilters = json_decode($request->columnFilter, true);
                foreach ($columnFilters as $key => $value) {
                    if ($value != "")
                        $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
            if ($request->from_date!=null || $request->to_date !=null ) {

                       $startDate = Carbon::parse($request->from_date)->toDateTimeString();
                       $endDate = Carbon::parse($request->to_date)->toDateTimeString();
                        $query->whereBetween('created_at', array($startDate, $endDate));
            }
            if ($request->has('sorter')) {
                $sorter = json_decode($request->sorter);
                $by = $sorter->asc == true ? 'ASC' : 'DESC';
                $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
                $query->orderBy($column, $by);
            }
            $orders =  $query->paginate($request->get('itemsLimit'));
            return response()->json(compact('orders','user'));
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
    public function ordersFleet(Request $request,$id){
        try {
              $user=Fleet::find($id);
            $query = Order::with('status','user')->where('fleet_id',$id)->whereNotNull('user_id');
            if ($request->has('columnFilter')) {
                $columnFilters = json_decode($request->columnFilter, true);
                foreach ($columnFilters as $key => $value) {
                    if ($value != "")
                        $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
            if ($request->from_date!=null || $request->to_date !=null ) {

                       $startDate = Carbon::parse($request->from_date)->toDateTimeString();
                       $endDate = Carbon::parse($request->to_date)->toDateTimeString();
                        $query->whereBetween('created_at', array($startDate, $endDate));
            }
            if ($request->has('sorter')) {
                $sorter = json_decode($request->sorter);
                $by = $sorter->asc == true ? 'ASC' : 'DESC';
                $column = $sorter->column == '' ? 'delivery_time' : $sorter->column;
                $query->orderBy($column, $by);
            }
            $orders =  $query->paginate($request->get('itemsLimit'));
            return response()->json(compact('orders','user'));
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage(), 'data' => []], 500);
        }
    }
}
