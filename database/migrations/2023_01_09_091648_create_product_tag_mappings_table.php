<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTagMappingsTable extends Migration
{
    public function up()
    {
        Schema::create('product_tag_mappings', function (Blueprint $table) {
            $table->bigInteger('product_id');
            $table->bigInteger('tag_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_tag_mappings');
    }
}
