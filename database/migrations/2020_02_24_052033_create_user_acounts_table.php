<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAcountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_acounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('user',['مشتری','خدمت رسان']);
            $table->enum('type',['شارژ','درآمد']);
            $table->integer('cash');
            $table->unsignedBigInteger('personal_id')->nullable();
            $table->unsignedBigInteger('cunsomer_id')->nullable();
            $table->foreign('personal_id')->references('id')->on('personals');
            $table->foreign('cunsomer_id')->references('id')->on('cunsomers');
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
        Schema::dropIfExists('user_acounts');
    }
}
