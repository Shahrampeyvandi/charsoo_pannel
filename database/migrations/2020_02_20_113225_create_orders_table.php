<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_unique_code');
            $table->string('order_type');
            $table->text('order_desc')->nullable();
            $table->string('order_show_mobile');
            $table->string('order_firstname_customer');
            $table->string('order_lastname_customer');
            $table->string('order_username_customer');
            $table->string('order_service_name');
            $table->string('order_broker_name');
            $table->string('order_datetime_one_start');
            $table->string('order_datetime_one_end');
            $table->string('order_datetime_two_start');
            $table->string('order_datetime_two_end');
            $table->string('order_reffered_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
