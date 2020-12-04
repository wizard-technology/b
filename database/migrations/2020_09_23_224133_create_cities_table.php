<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('ct_name');
            $table->string('ct_name_ku');
            $table->string('ct_name_ar');
            $table->string('ct_name_pr');
            $table->string('ct_name_kr');
            $table->boolean('ct_state')->default(0);
            $table->unsignedBigInteger('ct_admin');
            $table->foreign('ct_admin')->references('id')->on('users');
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
        Schema::dropIfExists('cities');
    }
}
