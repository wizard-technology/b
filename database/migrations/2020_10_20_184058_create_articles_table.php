<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->json('ar_article')->nullable();
            $table->json('ar_article_ku')->nullable();
            $table->json('ar_article_ar')->nullable();
            $table->json('ar_article_pr')->nullable();
            $table->json('ar_article_kr')->nullable();
            $table->string('ar_type');
            $table->unsignedBigInteger('ar_admin');
            $table->foreign('ar_admin')->references('id')->on('users');
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
        Schema::dropIfExists('articles');
    }
}
