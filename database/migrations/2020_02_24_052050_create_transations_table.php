<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_acounts_id');
            $table->enum('type',['واریز','برداشت']);
            $table->enum('for',['دستمزد','شارژ','تسویه','هزینه خدمت','ارسال پیشنهاد','انتقال به شارژ','شارژ هدیه','بازگشت وجه','پورسانت خدمت']);
            $table->unsignedBigInteger('order_id')->nullable();
            $table->integer('amount');
            $table->string('from_to')->nullable();
            $table->text('description')->nullable();
            $table->foreign('user_acounts_id')->references('id')->on('user_acounts');
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('transations');
    }
}