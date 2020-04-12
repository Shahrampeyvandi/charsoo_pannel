<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name');
            $table->string('store_location')->nullable();
            $table->string('store_address')->nullable();
            $table->text('store_description')->nullable();
            $table->string('store_type')->nullable();
            $table->string('store_picture')->nullable();
            $table->string('store_icon')->nullable();
            $table->string('store_city')->nullable();
            $table->string('store_main_street')->nullable();
            $table->string('store_secondary_street')->nullable();
            $table->integer('store_pelak')->nullable();
            $table->integer('products_quantity')->nullable();
            $table->integer('owner_id');
            $table->integer('store_status')->default(1);
            $table->string('store_category')->nullable();
        
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
        Schema::dropIfExists('stores');
    }
}
