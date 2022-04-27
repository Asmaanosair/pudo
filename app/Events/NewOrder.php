<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $order;
    public $fleet;
    public function __construct($order, $fleet)
    {
        $this->order = $order;
        $this->fleet = $fleet;
        if ($order->fleet_id != null) {
            $order->last_driver = $order->fleet_id;
            $order->assign_order = $order->reassign_order;
            $order->reassign_order = Carbon::now()->format('Y-m-d H:i:s');
        } else {
            $order->assign_order = Carbon::now()->format('Y-m-d H:i:s');
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('twistNewOrder');
    }
}
