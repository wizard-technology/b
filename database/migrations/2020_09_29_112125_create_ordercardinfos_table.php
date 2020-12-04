<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdercardinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordercardinfos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oci_order');
            $table->unsignedBigInteger('oci_card');
            $table->foreign('oci_order')->references('id')->on('carts');
            $table->foreign('oci_card')->references('id')->on('cardinfos');
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
        Schema::dropIfExists('ordercardinfos');
    }
}
