<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->string('category_slug');
            $table->string('name');
            $table->string('code');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('alt', 255)->nullable();
            $table->text('summary')->nullable();
            $table->bigInteger('quantity')->default(0);
            $table->double('sale_price', 20, 2);
            $table->double('price', 20, 2);
            $table->string('brand')->nullable();
            $table->bigInteger('order')->default(0);
            $table->boolean('published')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
