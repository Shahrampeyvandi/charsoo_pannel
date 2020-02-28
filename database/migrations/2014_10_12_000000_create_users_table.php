<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

    //     $user = User::create([
            
    //             'user_firstname' => 'charsoo',
    //             'user_lastname' => 'charsoo',
    //             'user_username' => 'admin',
    //             'user_mobile' => '091212345678',
    //             'user_national_code' => '105111111',
    //             'user_responsibility' => 'admin',
    //             'user_password' => Hash::make('1234'),
    //     ]);

    //    $role = Role::create([
            
    //             'name' => 'admin_panel',
    //             'broker' => 1,
            
    //     ]);
    //     DB::table('permissions')->insert([
    //         [
    //             'name' => 'user_transaction'],[
    //             'name' => 'user_pass'],[
    //             'name' => 'insert_user'],[
    //             'name' => 'user_menu'],[
    //             'name' => 'user_list'],[
    //             'name' => 'user_delete'],[
    //             'name' => 'user_edit'],[
    //             'name' => 'personal_online_menu'],[
    //             'name' => 'personal_online_list'],[
    //             'name' =>  'city_insert'],[
    //             'name' =>  'city_delete'],[
    //             'name' =>  'city_list'],[
    //             'name' =>  'city_menu'],[
    //             'name' =>  'city_edit'],[
    //             'name' => 'customer_menu'],[
    //             'name' => 'customer_list'],[
    //             'name' => 'customer_delete'],[
    //             'name' => 'category_menu'],[
    //             'name' => 'category_insert'],[
    //             'name' => 'category_delete'],[
    //             'name' => 'category_edit'],[
    //             'name' => 'service_menu'],[
    //             'name' => 'service_insert'],[
    //             'name' => 'service_delete'],[
    //             'name' => 'service_edit'],[
    //             'name' => 'personal_menu'],[
    //             'name' => 'personal_insert'],[
    //             'name' => 'personal_delete'],[
    //             'name' => 'personal_edit'],[
    //             'name' => 'orders_menu'],[
    //             'name' => 'orders_insert'],[
    //             'name' => 'orders_delete'],[
    //             'name' => 'orders_refferto'],[
    //             'name' => 'orders_transactions'],[
    //             'name' => 'orders_detail'],[

    //         ],
    //     ]);
    //     $all_permissions = [
    //         'user_transaction',
    //         'user_pass',
    //         'insert_user',
    //         'user_menu',
    //         'user_list',
    //         'user_delete',
    //         'user_edit',
    //         'personal_online_menu',
    //         'personal_online_list',
    //         'city_insert',
    //         'city_delete',
    //         'city_list',
    //         'city_menu',
    //         'city_edit',
    //         'customer_menu',
    //         'customer_list',
    //         'customer_delete',
    //         'customer_excel',
    //         'category_menu',
    //         'category_insert',
    //         'category_delete',
    //         'category_edit',
    //         'service_menu',
    //         'service_insert',
    //         'service_delete',
    //         'service_edit',
    //         'personal_menu',
    //         'personal_insert',
    //         'personal_delete',
    //         'personal_edit',
    //         'orders_menu',
    //         'orders_insert',
    //         'orders_delete',
    //         'orders_refferto',
    //         'orders_detail',
    //         'orders_transactions',
    //     ];
    //     $role->givePermissionTo($all_permissions);
    //     $user->assignRole('admin_panel');
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
