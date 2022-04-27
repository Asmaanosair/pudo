<?php

namespace App\Jobs;

use App\Enums\AOrderStatus;
use App\Enums\RouteNumberStatus;
use App\Events\AgentEvent;
use App\Events\OrderOperation;
use App\Http\Controllers\Driver\FCMController;
use App\MaxShipmentNumber;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Picqer;

class RouteNumber implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $maxNumber = MaxShipmentNumber::find(1);
        $orders = Order::whereNull(['route_number_id', 'fleet_id'])->where('order_status_id', AOrderStatus::NEW_ORDER)->get()->sortBy('branch_id');
        $branch_id = array_column($orders->unique('branch_id')->toArray(), 'branch_id');
        foreach ($branch_id as $id) {
            $arrangOrder = $orders->where('branch_id', $id);
            foreach ($arrangOrder->chunk($maxNumber->max_number) as $row) {
                $routeNumber = random_int(1111111, 999999999);
                $patch = new \App\RouteNumber();
                $patch->route_number = $routeNumber;
                $patch->save();
                $patch->branch_id = $id;
                $patch->save();
                foreach ($row as $order) {
                    $order->route_number_id = $patch->id;
                    $order->save();
                    $order->patch;
                    $order->user;
                    $order->city;
                    $order->branchWithCity;
                    $pdf = \PDF::loadView('shipment', compact('order'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a6', 'landscape');
                    $fileName = "Order_" . $order->id . '_' . $routeNumber . '.pdf';
                    $pdfFilePath = 'orderPatch/';
                    Storage::disk('s3')->put($pdfFilePath . $fileName, $pdf->output(), 'public');
                    $order->pdf_url = $fileName;
                    $order->pdf_status = 1;
                    $order->save();

                }
                $updatePatch = \App\RouteNumber::find($patch->id);
                $updatePatch->pdf_status = 1;
                $updatePatch->status = RouteNumberStatus::NEW;
                $updatePatch->save();
                $fcm = new FCMController();
                $fcm->assignOrder($row, $updatePatch->branch_id, $updatePatch->id, 3);
            }
        }
    }
}
