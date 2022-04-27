<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChangeStatusToAmarai implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderStatusChanged  $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        Helper::AlmaraiCahngeOrderStatus($event->order_code,$event->status);
    }
}
