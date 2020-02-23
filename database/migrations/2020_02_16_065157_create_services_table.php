<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('service_category_id');
            $table->string('service_title');
            $table->integer('service_percentage')->nullable();
            $table->integer('service_offered_price')->nullable();
            $table->text('service_desc')->nullable();
            $table->text('service_alerts')->nullable();
            $table->string('service_city');
            $table->string('service_type_send');
            $table->string('service_price')->nullable();
            $table->string('price_type');
            $table->string('service_icon')->nullable();
            $table->string('service_price_first')->nullable();
            $table->string('service_price_second')->nullable();
            $table->string('service_offered_status')->nullable();
            $table->string('service_special_category')->nullable();
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
        Schema::dropIfExists('services');
    }
}
