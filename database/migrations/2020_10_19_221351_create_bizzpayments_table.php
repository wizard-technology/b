<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBizzpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bizzpayments', function (Blueprint $table) {
            $table->id();
            $table->double('bz_price');
            $table->boolean('bz_trading')->default(0);
            $table->boolean('bz_state')->default(0);
            $table->unsignedBigInteger('bz_admin');
            $table->foreign('bz_admin')->references('id')->on('users');
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
        Schema::dropIfExists('bizzpayments');
    }
}
