<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDataTable extends Migration
{
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('form_id');
            $table->bigInteger('attribute_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_data');
    }
}
