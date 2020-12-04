<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardinfos', function (Blueprint $table) {
            $table->id();
            $table->string('ci_code');
            $table->boolean('ci_state');
            $table->unsignedBigInteger('ci_product');
            $table->unsignedBigInteger('ci_admin');
            $table->foreign('ci_product')->references('id')->on('products');
            $table->foreign('ci_admin')->references('id')->on('users');
            $table->timestamps();
            $table->unique(['ci_code','ci_product']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cardinfos');
    }
}
