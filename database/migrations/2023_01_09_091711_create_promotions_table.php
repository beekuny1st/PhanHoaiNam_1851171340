<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->double('min_order_value', 20, 2);
            $table->integer('min_products_count');
            $table->double('discount_value', 20, 2);
            $table->double('discount_percent', 20, 2);
            $table->boolean('enable')->default(true);
            $table->date('expired_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
