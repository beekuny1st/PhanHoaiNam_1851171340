<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicTableRowsTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_table_rows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('table_id')->index();
            $table->string('row_value', 255)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dynamic_table_rows');
    }
}
