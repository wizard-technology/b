<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('co_name');
            $table->string('co_image')->nullable();
            $table->string('co_phone');
            $table->text('co_address');
            $table->text('co_info');
            $table->unsignedBigInteger('co_user');
            $table->foreign('co_user')->references('id')->on('users');
            $table->unsignedBigInteger('co_admin');
            $table->foreign('co_admin')->references('id')->on('users');
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
        Schema::dropIfExists('companies');
    }
}
