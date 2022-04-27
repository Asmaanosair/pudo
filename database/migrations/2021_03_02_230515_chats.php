<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Chats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('chats');

        Schema::create('chats', function (Blueprint $table) {

        $table->id();

        $table->bigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        $table->bigInteger('friend_id');
        $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade');

        $table->text('chat');
        $table->enum('seen', [0, 1])->default(0);
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
        Schema::dropIfExists('chats');
    }
}
