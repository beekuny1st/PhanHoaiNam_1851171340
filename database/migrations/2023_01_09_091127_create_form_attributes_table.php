<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('form_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('form_id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_attributes');
    }
}
