<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->string('order_reffer_time')->nullable();
            $table->string('order_start_time')->nullable();
            $table->text('order_start_description')->nullable();
            $table->string('order_start_time_positions')->nullable();
            $table->string('order_end_time')->nullable();
            $table->string('order_end_time_positions')->nullable();
            $table->text('order_end_time_description')->nullable();
            $table->string('order_recived_price')->nullable();
            $table->string('order_pieces_cast')->nullable();
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
        Schema::dropIfExists('order_status_details');
    }
}
