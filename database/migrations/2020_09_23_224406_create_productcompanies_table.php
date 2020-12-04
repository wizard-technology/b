<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductcompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productcompanies', function (Blueprint $table) {
            $table->id();
            $table->string('pc_name');
            $table->text('pc_disc');
            $table->double('pc_price');
            $table->unsignedBigInteger('pc_company');
            $table->foreign('pc_company')->references('id')->on('users');
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
        Schema::dropIfExists('productcompanies');
    }
}
