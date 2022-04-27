<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiAdminEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('api_key_admin_events');
        Schema::create('api_key_admin_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('api_key_id');
            $table->ipAddress('ip_address');
            $table->string('event');
            $table->timestamps();

            $table->index('ip_address');
            $table->index('event');
            // $table->foreign('api_key_id')->references('id')->on('api_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
