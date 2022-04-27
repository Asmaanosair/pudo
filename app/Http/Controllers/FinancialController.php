<?php

namespace App\Http\Controllers;

use App\ApplicationStatus;
use App\Enums\DriverApply;
use App\Fleet;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    public function orders(Request $request)
    {
        $user = auth('api')->user();
        $query = Fleet::query();
        if ($user->menuroles == 'user' || $user->menuroles == 'dispatcher' || $user->menuroles == 'support') {
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
            $column = $sorter->column == '' ? 'last_login' : $sorter->column;
            $query->orderBy($column, $by);
        }
        $fleets = $query->where('application_status_id', DriverApply::APPROVED_BY_PUDO)

            ->paginate($request->get('itemsLimit'));
        $onlineCount  = $query->where("status", 'online')->count();

        foreach ($fleets as $fleet) {
            $order = Order::where('fleet_id', $fleet->id);
            $totalPrice = $order->sum('total_price');
            $totalCount = $order->count();
            $totalDamagePrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [54])->sum('total_price');
            $totalDamageCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [54])->count();
            $totalCanceledPrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [11, 41, 40, 4])->sum('total_price');
            $totalCanceledCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [11, 41, 40, 4])->count();
            $totalReturnedPrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [10, 43, 42, 45, 44])->sum('total_price');
            $totalReturnedCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [10, 43, 42, 45, 44])->count();
            $totalFReturnedPrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [5])->sum('total_price');
            $totalFReturnedCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [5])->count();
            $fleet['totalCount'] = $totalCount;
            $fleet['totalPrice'] = $totalPrice;
            $fleet['totalDamageCount'] = $totalDamageCount;
            $fleet['totalDamagePrice'] = $totalDamagePrice;
            $fleet['totalCanceledCount'] = $totalCanceledCount;
            $fleet['totalCanceledPrice'] = $totalCanceledPrice;
            $fleet['totalReturnedCount'] = $totalReturnedCount;
            $fleet['totalReturnedPrice'] = $totalReturnedPrice;
            $fleet['totalFReturnedCount'] = $totalFReturnedCount;
            $fleet['totalFReturnedPrice'] = $totalFReturnedPrice;
        }



        return response()->json(compact('fleets', 'onlineCount'));
    }


    public function chart(Request $request)
    {

        $user = auth('api')->user();
        $query = Fleet::query();
        if ($user->menuroles == 'user' || $user->menuroles == 'dispatcher' || $user->menuroles == 'support') {
            $query->where('user_id', $user->id);
        }

        $fleets = $query->where('application_status_id', DriverApply::APPROVED_BY_PUDO)->get();

        foreach ($fleets as $fleet) {
            $order = Order::where('fleet_id', $fleet->id);
            $totalPrice = $order->sum('total_price');
            $totalCount = $order->count();
            $totalDamagePrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [54])->sum('total_price');
            $totalDamageCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [54])->count();
            $totalCanceledPrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [11, 41, 40, 4])->sum('total_price');
            $totalCanceledCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [11, 41, 40, 4])->count();
            $totalReturnedPrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [10, 43, 42, 45, 44])->sum('total_price');
            $totalReturnedCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [10, 43, 42, 45, 44])->count();
            $totalFReturnedPrice = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [5])->sum('total_price');
            $totalFReturnedCount = Order::where('fleet_id', $fleet->id)->whereIn('order_status_id', [5])->count();
            $fleet['totalCount'] = $totalCount;
            $fleet['totalPrice'] = $totalPrice;
            $fleet['totalDamageCount'] = $totalDamageCount;
            $fleet['totalDamagePrice'] = $totalDamagePrice;
            $fleet['totalCanceledCount'] = $totalCanceledCount;
            $fleet['totalCanceledPrice'] = $totalCanceledPrice;
            $fleet['totalReturnedCount'] = $totalReturnedCount;
            $fleet['totalReturnedPrice'] = $totalReturnedPrice;
            $fleet['totalFReturnedCount'] = $totalFReturnedCount;
            $fleet['totalFReturnedPrice'] = $totalFReturnedPrice;
        }
        return response()->json(compact('fleets'));
    }
}
