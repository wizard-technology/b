<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedeemCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem_codes', function (Blueprint $table) {
            $table->id();
            $table->string('rc_qrcode');
            $table->string('rc_code');
            $table->string('rc_currency');
            $table->string('rc_txid');
            $table->double('rc_price');
            $table->unsignedBigInteger('rc_user');
            $table->unsignedBigInteger('rc_company');
            $table->foreign('rc_user')->references('id')->on('users');
            $table->foreign('rc_company')->references('id')->on('users');
            $table->boolean('rc_state')->default(0)->comment('0=>Active, 1=>Used');
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
        Schema::dropIfExists('redeem_codes');
    }
}
