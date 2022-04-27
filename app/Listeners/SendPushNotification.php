<?php

namespace App\Listeners;

use App\Events\OrderAssigned;
use App\Fleet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPushNotification implements ShouldQueue
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
     * @param  OrderAssigned  $event
     * @return void
     */
    public function handle(OrderAssigned $event)
    {
        $fleet = Fleet::find($event->order->fleet_id);
        foreach ($fleet->devices as $device) {
            try {
                \OneSignal::sendNotificationToUser(
                    "you have a new order on PUDO",
                    $device->player_id,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null
                );
            }catch (\Exception $exception){



            }

        }
    }
}
