<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('priority')->default(10);
            $table->string('title')->nullable();
            $table->enum('type',['فروشگاه','خدمت','دسته بندی']);
            $table->text('item');
            $table->boolean('special_offer')->default(false);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('app_menu');
    }
}
