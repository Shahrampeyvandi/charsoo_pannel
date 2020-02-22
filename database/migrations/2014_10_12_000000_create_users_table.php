<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_firstname');
            $table->string('user_lastname');
            $table->string('user_email')->nullable();
            $table->string('user_username');
            $table->string('user_mobile');
            $table->string('user_national_code');
            $table->string('user_prfile_pic')->nullable();
            $table->string('user_responsibility')->nullable();
            $table->string('user_password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
             'user_firstname' => 'charsoo',
             'user_lastname' => 'charsoo',
             'user_username' => 'admin',
             'user_mobile' => '091212345678',
             'user_national_code' => '105111111',
             'user_responsibility' => 'admin',
             'user_password' => Hash::make('1234'),
            ],
            
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
