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
        Schema::create('app_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('priority')->default(10);
            $table->string('title')->nullable();
            $table->enum('type',['فروشگاه','خدمت','دسته بندی','خدمت های دسته','فروشگاه های دسته']);
            $table->text('item');
            $table->boolean('special_offer')->default(0);
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
        Schema::dropIfExists('app_menus');
    }
}
