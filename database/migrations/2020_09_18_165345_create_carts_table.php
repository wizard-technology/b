<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('c_amount');
            $table->double('c_price');
            $table->double('c_price_all');
            $table->integer('c_doc_id');
            $table->boolean('c_state');
            $table->unsignedBigInteger('c_product');
            $table->unsignedBigInteger('c_user');
            $table->foreign('c_product')->references('id')->on('products');
            $table->foreign('c_user')->references('id')->on('users');
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
        Schema::dropIfExists('carts');
    }
}
