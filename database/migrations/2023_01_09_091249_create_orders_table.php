<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->string('customer_email');
            $table->bigInteger('province_id')->index();
            $table->bigInteger('district_id')->index();
            $table->bigInteger('ward_id')->index();
            $table->double('amount', 20, 2);
            $table->double('shipping_fee', 20, 2);
            $table->double('vat', 20, 2);
            $table->double('total_amount', 20, 2);
            $table->text('request')->nullable();
            $table->string('payment_type');
            $table->string('payment_status')->index();
            $table->string('order_status')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
