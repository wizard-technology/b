<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('noti_title');
            $table->string('noti_content');
            $table->boolean('noti_state')->default(0);
            $table->unsignedBigInteger('noti_user');
            $table->unsignedBigInteger('noti_id_opened');
            $table->boolean('noti_type')->comment('0 => Report Message , 1 => Order State');
            $table->foreign('noti_user')->references('id')->on('users');
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
        Schema::dropIfExists('notifications');
    }
}
