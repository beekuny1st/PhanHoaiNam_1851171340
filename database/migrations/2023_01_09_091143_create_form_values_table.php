<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormValuesTable extends Migration
{
    public function up()
    {
        Schema::create('form_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('form_id');
            $table->bigInteger('attribute_id');
            $table->bigInteger('data_id');
            $table->string('value', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_values');
    }
}
