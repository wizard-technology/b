<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tg_name');
            $table->string('tg_name_ku');
            $table->string('tg_name_ar');
            $table->string('tg_name_pr');
            $table->string('tg_name_kr');
            $table->boolean('tg_state')->default(0)->comment('State to active deactive');
            $table->unsignedBigInteger('tg_admin');
            $table->foreign('tg_admin')->references('id')->on('users');
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
        Schema::dropIfExists('tags');
    }
}
