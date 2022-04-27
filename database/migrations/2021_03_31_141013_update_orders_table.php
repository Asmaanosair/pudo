<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->float('pick_up_lng',20,10)->default(46.675297);
            $table->float('pick_up_lat',20,10)->default(24.713552);
            $table->float('delivery_lng',20,10)->default(46.675297);
            $table->float('delivery_lat',20,10)->default(24.713552);
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
