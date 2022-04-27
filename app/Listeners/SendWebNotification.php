<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWebNotification implements ShouldQueue
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
     * @param  NewOrder  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
        $admins = User::role('admin')->get();
        $user = User::find($event->order->user_id);
        foreach ($user->devices as $device) {
            try {
                \OneSignal::sendNotificationToUser(
                    "New Order came on PUDO",
                    $device->player_id,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null
                );
            }catch (\Exception $exception){

            }

        }

        foreach ($admins as $admin) {
            foreach ($admin->devices as $device) {
                try {
                    \OneSignal::sendNotificationToUser(
                        "New Order came on Pudo",
                        $device->player_id,
                        $url = null,
                        $data = null,
                        $buttons = null,
                        $schedule = null
                    );
                } catch (\Exception $exception) {

                }
            }
        }
    }
}
