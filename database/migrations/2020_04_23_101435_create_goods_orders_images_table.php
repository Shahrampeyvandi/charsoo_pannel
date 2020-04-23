<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsOrdersImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_orders_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('goods_orders_id');
            $table->foreign('goods_orders_id')->references('id')->on('goods_orders')->onDelete('cascade');
            $table->enum('type',['cp1','cp2','cp3','pp1','pp2','pp3','ppf']);
            $table->string('link');
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
        Schema::dropIfExists('goods_orders_images');
    }
}
