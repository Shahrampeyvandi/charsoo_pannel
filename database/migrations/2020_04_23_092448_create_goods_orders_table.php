<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->foreign('stores_id')->references('id')->on('stores')->onDelete('cascade');
            $table->string('personal_mobile');
            $table->unsignedBigInteger('cunsomers_id');
            $table->foreign('cunsomers_id')->references('id')->on('cunsomers')->onDelete('cascade');
            $table->string('cunsomer_mobile');
            $table->string('off_code')->nullable();
            $table->string('items');
            $table->string('counts');
            $table->integer('totalamountitems');
            $table->integer('packingprice')->default(0);
            $table->integer('sendingprice')->default(0);
            $table->integer('payedprice')->nullable();
            $table->integer('cashamount')->default(0);
            $table->string('address');
            $table->unsignedBigInteger('address_id');
            $table->date('deliverdate');
            $table->string('delivertime');
            $table->string('description')->nullable();
            $table->enum('status',['معلق','تایید فروشنده','در حال آماده سازی','ارسال شده','تحویل شده','لغو شده'])->default('معلق');
            $table->text('cancelreason')->nullable();
            $table->integer('delivercode')->default(91460);
            $table->text('questions')->nullable();
            $table->text('answers')->nullable();
            $table->string('orderuniquecode')->nullable();
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
        Schema::dropIfExists('goods_orders');
    }
}
