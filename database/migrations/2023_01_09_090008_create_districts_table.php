<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('province_id')->index();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
