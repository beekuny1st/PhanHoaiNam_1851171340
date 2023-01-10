<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionProductMappingsTable extends Migration
{
    public function up()
    {
        Schema::create('promotion_product_mappings', function (Blueprint $table) {
            $table->bigInteger('promotion_id');
            $table->bigInteger('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotion_product_mappings');
    }
}
