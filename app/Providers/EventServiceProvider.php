<?php

namespace App\Providers;

use App\Events\AgentEvent;
use App\Events\DriverAccepted;
use App\Events\NewOrder;
use App\Events\OrderAssigned;
use App\Events\OrderStatusChanged;
use App\Listeners\OrderUpdates;
use App\Listeners\SendChangeStatusToAmarai;
use App\Listeners\SendDriverAcceptedToAmarai;
use App\Listeners\SendPushNotification;
use App\Listeners\SendWebNotification;
use App\OrderStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],

        AgentEvent::class =>[
          OrderUpdates::class
        ],
        NewOrder::class =>[
            SendWebNotification::class
        ],
        OrderStatusChanged::class =>[
            SendChangeStatusToAmarai::class
        ],
        DriverAccepted::class =>[
            SendDriverAcceptedToAmarai::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
