<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->integer('category_id');
            $table->string('category_slug', 255);
            $table->string('image', 255)->nullable();
            $table->string('alt', 255)->nullable();
            $table->text('summary')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('published')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
