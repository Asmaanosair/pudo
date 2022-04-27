<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiAccessEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('api_key_access_events');

        Schema::create('api_key_access_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('api_key_id');
            $table->ipAddress('ip_address');
            $table->text('url');
            $table->timestamps();

            $table->index('ip_address');
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
