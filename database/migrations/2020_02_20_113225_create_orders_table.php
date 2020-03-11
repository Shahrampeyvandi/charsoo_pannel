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
            $table->integer('service_id');
            $table->string('order_unique_code')->nullable();
            $table->string('order_type');
            $table->text('order_desc')->nullable();
            $table->string('order_show_mobile')->nullable();
            $table->string('order_firstname_customer');
            $table->string('order_lastname_customer');
            $table->string('order_username_customer')->nullable();
            $table->string('order_broker_name')->nullable();
            $table->string('order_time_first')->nullable();
            $table->string('order_time_second')->nullable();
            $table->string('order_date_first')->nullable();
            $table->string('order_date_second')->nullable();
            $table->string('order_reffered_to')->nullable();
            $table->string('order_city')->nullable();
            $table->text('order_address');
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
