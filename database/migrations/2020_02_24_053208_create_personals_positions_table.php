<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals_positions', function (Blueprint $table) {
            $table->bigInteger('personal_id')->unsigned();
            $table->string('tool');
            $table->string('arz');
            $table->timestamps();
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            $table->unique(['personal_id', 'created_at']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personals_positions');
    }
}
