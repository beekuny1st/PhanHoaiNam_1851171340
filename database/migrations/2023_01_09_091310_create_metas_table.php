<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('description', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->bigInteger('metaable_id');
            $table->string('metaable_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
