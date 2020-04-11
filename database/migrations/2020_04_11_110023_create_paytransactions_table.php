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
            $table->string('mobile');
            $table->string('amount');
            $table->text('desc')->nullable();
            $table->boolean('successful')->default(0);
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
