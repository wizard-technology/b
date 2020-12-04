<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageproductcompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imageproductcompanies', function (Blueprint $table) {
            $table->id();
            $table->string('ipc_image');
            $table->unsignedBigInteger('ipc_produc');
            $table->foreign('ipc_produc')->references('id')->on('productcompanies');
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
        Schema::dropIfExists('imageproductcompanies');
    }
}
