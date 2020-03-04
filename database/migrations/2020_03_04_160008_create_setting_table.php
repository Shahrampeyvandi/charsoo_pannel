<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('zaribsetaremoshtari');
            $table->integer('zaribtedadsarevaghtresidan');
            $table->integer('zaribetedadedirresidan');
            $table->integer('zaribetedadeghatehayecancelshode');
            $table->integer('zaribetedadeshoroebkarcancellshode');
            $table->integer('zaribetedadepishnaddarnmah');
            $table->integer('zaribetedadkarsabtnamavalie');
            $table->integer('emtiazkhedmatresanhad1');
            $table->integer('emtiazkhedmatresanhad2');
            $table->integer('emtiazkhedmatresanhad3');
            $table->integer('tedadrooztaligh');
            $table->string('linkfaq');
            $table->string('linklaw');
            $table->string('linkappservicer');
            $table->string('shomareoperator');
            $table->string('shomareposhtibani');
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
        Schema::dropIfExists('setting');
    }
}
