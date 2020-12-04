<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('p_name');
            $table->string('p_name_ku');
            $table->string('p_name_ar');
            $table->string('p_name_pr');
            $table->string('p_name_kr');
            $table->string('p_image')->nullable();
            $table->double('p_price');
            $table->text('p_info');
            $table->text('p_info_ku');
            $table->string('p_info_ar');
            $table->string('p_info_pr');
            $table->string('p_info_kr');
            $table->integer('p_order_by');
            $table->boolean('p_state')->default(0);
            $table->boolean('p_has_info')->default(0);
            $table->unsignedBigInteger('p_type');
            $table->unsignedBigInteger('p_subcategory');
            $table->unsignedBigInteger('p_grouped');
            $table->unsignedBigInteger('p_admin');
            $table->foreign('p_type')->references('id')->on('types');
            $table->foreign('p_grouped')->references('id')->on('groupeds');
            $table->foreign('p_subcategory')->references('id')->on('subcategories');
            $table->foreign('p_admin')->references('id')->on('users');
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
        Schema::dropIfExists('products');
    }
}
