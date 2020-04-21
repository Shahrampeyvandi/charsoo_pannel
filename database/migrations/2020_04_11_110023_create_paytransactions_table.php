<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaytransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paytransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['customer','worker']);
            $table->unsignedBigInteger('personal_id')->nullable();
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            $table->unsignedBigInteger('cunsomer_id')->nullable();
            $table->foreign('cunsomer_id')->references('id')->on('cunsomers')->onDelete('cascade');
            $table->string('mobile');
            $table->integer('amount');
            $table->text('desc')->nullable();
            $table->boolean('successful')->default(0);
            $table->text('token')->unique();
            $table->dateTime('expire');
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
        Schema::dropIfExists('paytransaction');
    }
}
