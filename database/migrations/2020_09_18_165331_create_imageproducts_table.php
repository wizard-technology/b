<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imageproducts', function (Blueprint $table) {
            $table->id();
            $table->string('i_link');
            $table->unsignedBigInteger('i_product');
            $table->unsignedBigInteger('i_admin');
            $table->foreign('i_product')->references('id')->on('products');
            $table->foreign('i_admin')->references('id')->on('users');
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
        Schema::dropIfExists('imageproducts');
    }
}
