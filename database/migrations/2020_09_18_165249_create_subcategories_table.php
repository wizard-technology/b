<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('st_name');
            $table->string('st_name_ku');
            $table->string('st_name_ar');
            $table->string('st_name_pr');
            $table->string('st_name_kr');
            $table->string('st_image')->nullable();
            $table->boolean('st_state')->default(0)->comment('State to active deactive');
            $table->unsignedBigInteger('st_type');
            $table->foreign('st_type')->references('id')->on('types'); 
            $table->unsignedBigInteger('st_admin');
            $table->foreign('st_admin')->references('id')->on('users'); 
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
        Schema::dropIfExists('subcategories');
    }
}
