<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name')->default('web');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('broker')->nullable();
            $table->string('sub_broker')->nullable();
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
            $user = User::create([
            
                'user_firstname' => 'charsoo',
                'user_lastname' => 'charsoo',
                'user_username' => 'admin',
                'user_mobile' => '091212345678',
                'user_national_code' => '105111111',
                'user_responsibility' => 'admin',
                'user_password' => Hash::make('1234'),
        ]);
        
       $role = Role::create([
                'name' => 'admin_panel',
                'broker' => 1,
        ]);
        DB::table('permissions')->insert([
            [
                'name' => 'user_transaction'],[
                'name' => 'user_pass'],[
                'name' => 'insert_user'],[
                'name' => 'user_menu'],[
                'name' => 'user_list'],[
                'name' => 'user_delete'],[
                'name' => 'user_edit'],[
                'name' => 'personal_online_menu'],[
                'name' => 'personal_online_list'],[
                'name' =>  'city_insert'],[
                'name' =>  'city_delete'],[
                'name' =>  'city_list'],[
                'name' =>  'city_menu'],[
                'name' =>  'city_edit'],[
                'name' => 'customer_menu'],[
                'name' => 'customer_list'],[
                'name' => 'customer_delete'],
                 ['name' => 'customer_edit'],[
                'name' => 'category_menu'],[
                'name' => 'category_insert'],[
                'name' => 'category_delete'],[
                'name' => 'category_edit'],[
                'name' => 'service_menu'],[
                'name' => 'service_insert'],[
                'name' => 'service_delete'],[
                'name' => 'service_edit'],[
                'name' => 'personal_menu'],[
                'name' => 'personal_insert'],[
                'name' => 'personal_delete'],[
                'name' => 'personal_edit'],[
                'name' => 'orders_menu'],[
                'name' => 'orders_insert'],[
                'name' => 'orders_delete'],[
                'name' => 'orders_refferto'],[
                'name' => 'orders_transactions'],[
                'name' => 'orders_detail'],[
                'name' => 'user_accounts_personals'],[
                'name' => 'stores_menu'],[
                'name' => 'stores_delete'],[
                'name' => 'stores_edit'],[
                'name' => 'stores_create'],[
                'name' => 'user_transactions_personals'],[
                'name' => 'checkout_personals'],[
                'name' => 'setting'],[
                'name' => 'accounting'],[
                'name' => 'appmanage'],[
                 'name' => 'appmenu'],[
                 'name' => 'user_accounts_customers'],[
                 'name' => 'user_transactions_customers'],[
                 'name' => 'notifications'],[
                 'name' => 'notifications_add'],[
                    'name' => 'notifications_send'],[
                 'name' => 'appworkerannounc']

        ]);
        $all_permissions = [
            'user_transaction',
            'user_pass',
            'insert_user',
            'user_menu',
            'user_list',
            'user_delete',
            'user_edit',
            'personal_online_menu',
            'personal_online_list',
            'city_insert',
            'city_delete',
            'city_list',
            'city_menu',
            'city_edit',
            'customer_menu',
            'customer_list',
            'customer_delete',
            'customer_edit',
            'category_menu',
            'category_insert',
            'category_delete',
            'category_edit',
            'service_menu',
            'service_insert',
            'service_delete',
            'service_edit',
            'personal_menu',
            'personal_insert',
            'personal_delete',
            'personal_edit',
            'orders_menu',
            'orders_insert',
            'orders_delete',
            'orders_refferto',
            'orders_detail',
            'orders_transactions',
            'stores_menu',
            'stores_create',
            'stores_edit',
            'stores_delete',
            'user_accounts_personals',
            'user_transactions_personals',
            'checkout_personals',
            'setting',
            'accounting',
            'appmanage',
            'appmenu',
            'user_accounts_customers',
            'user_transactions_customers',
            'notifications',
            'notifications_add',
            'notifications_send',
           'appworkerannounc'

        ];
        $role->givePermissionTo($all_permissions);
        $user->assignRole('admin_panel');
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
