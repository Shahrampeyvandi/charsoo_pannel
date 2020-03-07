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
            $table->float('zaribsetaremoshtari');
            $table->float('zaribtedadsarevaghtresidan');
            $table->float('zaribetedadedirresidan');
            $table->float('zaribetedadeghatehayecancelshode');
            $table->float('zaribetedadeshoroebkarcancellshode');
            $table->float('zaribetedadepishnaddarnmah');
            $table->float('zaribetedadkarsabtnamavalie');
            $table->float('emtiazkhedmatresanhad1');
            $table->float('emtiazkhedmatresanhad2');
            $table->float('emtiazkhedmatresanhad3');
            $table->float('tedadrooztaligh');
            $table->string('linkfaq');
            $table->string('linklaw');
            $table->string('linkappservicer');
            $table->string('shomareoperator');
            $table->string('shomareposhtibani');
            $table->string('telegramposhtibani');
            $table->timestamps();
        });

        DB::table('setting')->insert(
            array(
                'zaribsetaremoshtari' => '1',
                'zaribtedadsarevaghtresidan' => '1',
                'zaribetedadedirresidan' => '1',
                'zaribetedadeghatehayecancelshode' => '1',
                'zaribetedadeshoroebkarcancellshode' => '1',
                'zaribetedadepishnaddarnmah' => '1',
                'zaribetedadkarsabtnamavalie' => '1',
                'emtiazkhedmatresanhad1' => '1',
                'emtiazkhedmatresanhad2' => '1',
                'emtiazkhedmatresanhad3' => '1',
                'tedadrooztaligh' => '1',
                'linkfaq' => 'http://panel.4sooapp.com',      
                'linklaw' => 'http://panel.4sooapp.com',
                'linkappservicer' => 'http://panel.4sooapp.com',
                'shomareoperator' => 'http://panel.4sooapp.com',
                'shomareposhtibani' => 'http://panel.4sooapp.com',
                'shomareposhtibani' => 'mmbhrzfr',

            )
        );
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
