<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagMappingsTable extends Migration
{
    public function up()
    {
        Schema::create('post_tag_mappings', function (Blueprint $table) {
            $table->bigInteger('post_id');
            $table->bigInteger('tag_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_tag_mappings');
    }
}
