<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('t_name');
            $table->string('t_name_ku');
            $table->string('t_name_ar');
            $table->string('t_name_pr');
            $table->string('t_name_kr');
            $table->string('t_image')->nullable();
            $table->boolean('t_state')->default(0)->comment('State to active deactive');
            $table->unsignedBigInteger('t_admin');
            $table->foreign('t_admin')->references('id')->on('users'); 
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
        Schema::dropIfExists('types');
    }
}
