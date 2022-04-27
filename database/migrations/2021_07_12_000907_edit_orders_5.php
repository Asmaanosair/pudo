<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditOrders5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('assign_order')->nullable();
            $table->timestamp('on_the_way_to_pickup')->nullable();
            $table->timestamp('near_pikup_location')->nullable();
            $table->timestamp('reach_pickup_location')->nullable();
            $table->timestamp('on_the_way_to_dropoff')->nullable();
            $table->timestamp('near_dropoff_location')->nullable();
            $table->timestamp('reach_customer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
