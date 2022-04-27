<?php

namespace App\Listeners;

use App\Api_key;
use App\Client;
use App\EndPoint;
use App\Events\AgentEvent;
use App\Helper;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\WebhookServer\WebhookCall;

class OrderUpdates
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
     * @param  object  $event
     * @return void
     */
    public function handle( AgentEvent $event)
    {

        $user_id=$event->order->user_id;
       $url=EndPoint::where('client_id',$user_id)->first();

       if($url!=null) {

           WebhookCall::create()
               ->url($url->endpoint)
               ->payload([$event->order])
               ->useSecret($event->order->user->api_id)
               ->dispatch();
       }
    }
}
