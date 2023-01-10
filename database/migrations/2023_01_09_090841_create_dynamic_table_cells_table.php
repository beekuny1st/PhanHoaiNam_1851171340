<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicTableCellsTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_table_cells', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('table_id');
            $table->bigInteger('column_id');
            $table->bigInteger('row_id');
            $table->longText('cell_value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dynamic_table_cells');
    }
}
