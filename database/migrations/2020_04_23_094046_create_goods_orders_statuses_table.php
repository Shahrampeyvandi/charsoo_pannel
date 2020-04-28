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
            $table->unsignedBigInteger('id')->unique();
            $table->foreign('goods_orders_id')->references('id')->on('goods_orders')->onDelete('cascade');
            $table->dateTime('accept_time')->nullable();
            $table->dateTime('preparation_time')->nullable();
            $table->dateTime('send_time')->nullable();
            $table->dateTime('deliver_time')->nullable();
            $table->dateTime('cancel_time')->nullable();
            $table->text('cancelreason')->nullable();
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
