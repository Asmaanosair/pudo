<?php

namespace App\Listeners;

use App\Events\DriverAccepted;
use App\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDriverAcceptedToAmarai implements ShouldQueue
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
     * @param  DriverAccepted  $event
     * @return void
     */
    public function handle(DriverAccepted $event)
    {
        Helper::AlmaraiDriverAccepted($event->order_code, $event->driverId);
    }
}
