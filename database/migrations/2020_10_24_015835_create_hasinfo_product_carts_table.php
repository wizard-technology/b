<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasinfoProductCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasinfo_product_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hpc_order');
            $table->unsignedBigInteger('hpc_user');
            $table->foreign('hpc_user')->references('id')->on('users');
            $table->unsignedBigInteger('hpc_cardinfo');
            $table->foreign('hpc_cardinfo')->references('id')->on('cardinfos');
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
        Schema::dropIfExists('hasinfo_product_carts');
    }
}
