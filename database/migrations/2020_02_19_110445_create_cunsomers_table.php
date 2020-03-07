<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCunsomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cunsomers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_firstname');
            $table->string('customer_lastname');
            $table->string('customer_mobile')->nullable();
            $table->string('customer_national_code')->nullable();
            $table->integer('customer_status')->default(0);
            $table->string('firebase_token')->nullable();
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
        Schema::dropIfExists('cunsomers');
    }
}
