<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicTableColumnsTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_table_columns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('table_id')->index();
            $table->string('name', 255);
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->boolean('required')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dynamic_table_columns');
    }
}
