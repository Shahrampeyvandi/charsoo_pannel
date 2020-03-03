<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('personal_firstname');
            $table->string('personal_lastname');
            $table->string('personal_birthday')->nullable();
            $table->string('personal_national_code')->nullable();
            $table->string('personal_marriage')->nullable();
            $table->string('personal_last_diploma')->nullable();
            $table->string('personal_mobile')->nullable();
            $table->string('personal_city')->nullable();
            $table->string('personal_postal_code')->nullable();
            $table->string('personal_address')->nullable();
            $table->string('personal_home_phone')->nullable();
            $table->string('personal_office_phone')->nullable();
            $table->string('personal_identity_card_first_pic')->nullable();
            $table->string('personal_identity_card_second_pic')->nullable();
            $table->string('personal_status_duty')->nullable();
            $table->string('personal_backgrounds_status')->nullable();
            $table->string('personal_national_card_front_pic')->nullable();
            $table->string('personal_national_card_back_pic')->nullable();
            $table->string('personal_profile')->nullable();
            $table->string('personal_responsibility')->nullable();
            $table->text('personal_about_specialization')->nullable();
            $table->integer('personal_work_experience_month')->nullable();;
            $table->integer('personal_work_experience_year')->nullable();
            $table->text('technical_credential')->nullable();
            $table->text('expert_credential')->nullable();
            $table->integer('personal_status')->default(1);
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
        Schema::dropIfExists('personals');
    }
}
