<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginSmsCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_sms_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->integer('code');
            $table->enum('app',['مشتری','خدمت رسان']);
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
        Schema::dropIfExists('login_sms_codes');
    }
}
