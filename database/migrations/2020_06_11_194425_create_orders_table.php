<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('user_id')->index();
            $table->integer('order_status_id')->index();
            $table->integer('fleet_id')->index()->nullable();
            $table->integer('number_of_products')->nullable();
            $table->double('order_price')->nullable();
            $table->double('discount')->nullable();
            $table->double('deliver_fees')->nullable();
            $table->double('total_price')->nullable();
            $table->string('pick_up_lng')->nullable();
            $table->string('pick_up_lat')->nullable();
            $table->string('delivery_lng')->nullable();
            $table->string('delivery_lat')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->timestamp('delivery_time')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
