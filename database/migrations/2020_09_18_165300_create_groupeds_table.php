<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupeds', function (Blueprint $table) {
            $table->id();
            $table->string('gr_name');
            $table->string('gr_name_ku');
            $table->string('gr_name_ar');
            $table->string('gr_name_pr');
            $table->string('gr_name_kr');
            $table->string('gr_image')->nullable();
            $table->boolean('gr_state')->default(0)->comment('State to active deactive');
            $table->unsignedBigInteger('gr_subcategory');
            $table->foreign('gr_subcategory')->references('id')->on('subcategories'); 
            $table->unsignedBigInteger('gr_admin');
            $table->foreign('gr_admin')->references('id')->on('users'); 
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
        Schema::dropIfExists('groupeds');
    }
}
