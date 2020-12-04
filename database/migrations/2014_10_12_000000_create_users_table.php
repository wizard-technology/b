<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_first_name');
            $table->string('u_second_name');
            $table->string('u_phone')->unique();
            $table->string('u_email')->unique();
            $table->string('u_code')->nullable();
            $table->string('u_city')->nullable();
            $table->string('password');
            $table->timestamp('u_phone_verified_at')->nullable();
            $table->enum('u_role',['ADMIN','COMPANY','USER'])->default('USER');
            $table->boolean('u_state')->default('0')->comment('0 => pendding ,1 => active , 2 => disable');
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
        Schema::dropIfExists('users');
    }
}
