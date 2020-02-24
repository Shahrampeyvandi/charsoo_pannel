<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_acounts_id');
            $table->boolean('payed');
            $table->integer('amount');
            $table->string('shaba');
            $table->unsignedBigInteger('transations_id')->nullable();
            $table->dateTime('payed_at');	
            $table->text('description')->nullable();
            $table->foreign('transations_id')->references('id')->on('transations');
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
        Schema::dropIfExists('checkout_personals');
    }
}
