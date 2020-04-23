<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsOrdersStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_orders_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_orders_id');
            $table->foreign('goods_orders_id')->references('id')->on('goods_orders')->onDelete('cascade');
            $table->dateTime('accept_time');
            $table->dateTime('preparation_time');
            $table->dateTime('send_time');
            $table->dateTime('deliver_time');
            $table->dateTime('cancel_time');
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
        Schema::dropIfExists('goods_orders_statuses');
    }
}
