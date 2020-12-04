<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducttagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producttags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pt_product');
            $table->unsignedBigInteger('pt_tag');
            $table->unsignedBigInteger('pt_admin');
            $table->foreign('pt_product')->references('id')->on('products');
            $table->foreign('pt_tag')->references('id')->on('tags'); 
            $table->foreign('pt_admin')->references('id')->on('users');
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
        Schema::dropIfExists('producttags');
    }
}
