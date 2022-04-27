<?php

namespace App\Jobs;

use App\Enums\AOrderStatus;
use App\Events\AgentEvent;
use App\Events\OrderOperation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Order;

class ReassignOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id)
    {
        $this->id= $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order=Order::find($this->id);
        $order->update(['order_status_id' => AOrderStatus::NEW_ORDER,'fleet_id'=>null]);
        event(new OrderOperation($order));
        event(new AgentEvent($order));
    }
}
