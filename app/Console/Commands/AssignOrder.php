<?php

namespace App\Console\Commands;

use App\Enums\AOrderStatus;
use App\Enums\RouteNumberStatus;
use App\Events\NewOrder;
use App\Http\Controllers\Driver\FCMController;
use App\Order;
use App\OrderStatus;
use App\RouteNumber;
use Illuminate\Console\Command;

class AssignOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = Order::where("order_status_id", AOrderStatus::NEW_ORDER);
        $allOrders = $data->get();
        $route_number_id = array_column($allOrders->unique('route_number_id')->toArray(), 'route_number_id');
        $fcm = new FCMController();
        $fleet = '';
        foreach ($route_number_id as $id) {
            $routNumber = RouteNumber::find($id);
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $routNumber->updated_at);
            $from = \Carbon\Carbon::now();
            $diff_in_sec = $to->diffInSeconds($from);
            $orders_same_batch = $data->where('route_number_id', $id)->get();
            $arrayOrders = array_column($orders_same_batch->toArray(), 'id');
            if ($diff_in_sec < 30) {
                $fcm->assignOrder($arrayOrders, $routNumber->branch_id, $routNumber->id, 3);
            } elseif (($diff_in_sec > 30 && $diff_in_sec <= 120)) {
                $fcm->assignOrder($arrayOrders, $routNumber->branch_id, $routNumber->id, 6);

            } elseif (($diff_in_sec > 120 && $diff_in_sec <= 360)) {
                $fcm->assignOrder($arrayOrders, $routNumber->branch_id, $routNumber->id, 8);

            } elseif (($diff_in_sec > 360 && $diff_in_sec <= 720)) {
                $fcm->assignOrder($arrayOrders, $routNumber->branch_id, $routNumber->id, 10);

            } elseif (($diff_in_sec > 720 && $diff_in_sec <= 1200)) {
                $fcm->assignOrder($arrayOrders, $routNumber->branch_id, $routNumber->id, 15);

            } else {
                $data->update(['order_status_id' => AOrderStatus::FAILED_TO_ASSIGN]);
                $routNumber->update(['status' => RouteNumberStatus::FAILED]);
            }

        }
    }


}
