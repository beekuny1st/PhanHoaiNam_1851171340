<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->integer('parent_id')->default(0);
            $table->string('summary', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('alt', 255)->nullable();
            $table->integer('order')->default(0);
            $table->boolean('published')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_categories');
    }
}
