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
            $table->enum('method',['اعتباری','نقدی'])->default('اعتباری');
            $table->enum('for',['انجام سفارش','شارژ','تسویه','هزینه سفارش','ارسال پیشنهاد','انتقال به شارژ','شارژ هدیه','بازگشت وجه','پورسانت خدمت','انتقال از درآمد']);
            $table->string('order_unique_code')->nullable();
            $table->integer('amount');
            $table->string('from_to')->nullable();
            $table->text('description')->nullable();
            $table->foreign('user_acounts_id')->references('id')->on('user_acounts');
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
