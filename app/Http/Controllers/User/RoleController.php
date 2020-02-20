<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function RolesList()
    {
       $roles = Role::all();
        return view('User.Roles.RolesList',compact('roles'));
    }

    public function InsertRole(Request $request)
    {
        
     $array = $request->except(['role_name','_token','broker_status']);
        $role = Role::create([
            'name' => $request->role_name,
            'broker' => $request->broker_status
            ]);

            $role->givePermissionTo(array_keys($array));
            alert()->success('نقش با موفقیت ثبت گردید', 'عملیات موفق')->autoclose(2000);
            return back();

        // $permission = Permission::create([
        //         'name' => 'insert user',
        //         'name' => 'user transaction',
        //         'name' => 'user pass',
        //         'name' => 'user menu',
        //         'name' => 'user list',
        //         'name' => 'user delete',
        //         'name' => 'user edit',
        //         'name' => 'personal online menu',
        //         'name' => 'personal online list',
        //         'name' => 'city insert',
        //         'name' => 'city delete',
        //         'name' => 'city list',
        //         'name' => 'customer menu',
        //         'name' => 'customer list',
        //         'name' => 'customer delete',
        //         'name' => 'customer excel',
                
        //         ]);
    }

    public function DeleteRole(Request $request)
    {
        foreach ($request->array as $role_id) {
           
            Role::where('id',$role_id)->delete();
        }
        return 'success';
    }

    public function getData(Request $request)
    {
     
        $role = Role::where('id',$request->id)->first();
        $csrf = csrf_token();

        $permissions = $role->permissions->pluck('name')->toArray();

        $list = ' <div class="modal-body">
        <div id="wizard2">
            <form id="example-advanced-form1" method="post" action="'.route('Roles.Edit.Submit').'"
                enctype="multipart/form-data">
                <input type="hidden" name="_token" value="'.$csrf.'">
                <input type="hidden" name="role_id" value="'.$role->id.'">
                <h3>نقش</h3>
                <section>
                    <div class="form-group wd-xs-300">
                        <label>نام </label>
                        <input type="text" id="role_name" name="role_name"
                        value="'.$role->name.'"
                        class="form-control"
                            placeholder="نام">
                    </div><!-- form-group -->
                    <div class="form-group wd-xs-300">
                        <div 
                            style="margin-left: -1rem;">
                            <input type="checkbox" id="broker_status" name="broker_status"
                                class="" value="1"
                                '.($role->broker == 1 ? 'checked=""' : '').'
                                >
                            <label class="" for="broker_status">به عنوان کارگزاری در نظر
                                گرفته شود</label>
                        </div>
                    </div>
                </section>
                <h3> مجوز ها</h3>
                <section>
                    <p>کاربران</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="insert_user" name="insert_user"
                                        class="" value="1"
                                        '.(in_array('insert_user',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="insert_user">ثبت کاربر</label>
                                </div>
                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="user_transaction" name="user_transaction"
                                        class="" value="1"
                                        '.(in_array('user_transaction',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="user_transaction">تراکنش های
                                        کاربر</label>
                                </div>
                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="user_pass" name="user_pass"
                                        class="" value="1"
                                        '.(in_array('user_pass',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="user_pass">تغییر پسورد
                                        کاربر</label>
                                </div>
                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="user_menu" name="user_menu"
                                        class="" value="1"
                                        '.(in_array('user_menu',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="user_menu">منو کاربر</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="user_list" name="user_list"
                                        class="" value="1"
                                        '.(in_array('user_list',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="user_list">لیست کاربر</label>
                                </div>

                            </div>

                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="user_delete" name="user_delete"
                                        class="" value="1"
                                        '.(in_array('user_delete',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="user_delete">حذف کاربر</label>
                                </div>

                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="user_edit" name="user_edit"
                                        class="" value="1"
                                        '.(in_array('user_edit',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="user_edit">ویرایش کاربر</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p>گزارش خدمت رسان های انلاین</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="personal_online_menu" name="personal_online_menu"
                                        class="" value="1"
                                        '.(in_array('personal_online_menu',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="personal_online_menu">منو خدمت رسان
                                        های انلاین</label>
                                </div>

                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="personal_online_list" name="personal_online_list"
                                        class="" value="1"
                                        '.(in_array('personal_online_list',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="personal_online_list">لیست خدمت
                                        رسان های انلاین</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p>شهر</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="city_insert" name="city_insert"
                                        class="" value="1"
                                        '.(in_array('city_insert',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="city_insert">ثبت شهر</label>
                                </div>

                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="city_edit" name="city_edit"
                                        class="" value="1"
                                        '.(in_array('city_edit',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="city_edit">ویرایش شهر</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="city_delete" name="city_delete"
                                        class="" value="1"
                                         '.(in_array('city_delete',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="city_delete">حذف شهر</label>
                                </div>
                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="city_menu" name="city_menu"
                                        class="" value="1"
                                         '.(in_array('city_menu',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="city_menu">منوی شهر</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="city_list" name="city_list"
                                        class="" value="1"
                                         '.(in_array('city_list',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="city_list">لیست شهر</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p>مشتری</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="customer_menu" name="customer_menu"
                                        class="" value="1"
                                         '.(in_array('customer_menu',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="customer_menu">منوی مشتری</label>
                                </div>

                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="customer_list" name="customer_list"
                                        class="" value="1"
                                         '.(in_array('customer_list',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="customer_list">لیست مشتری</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="customer_delete" name="customer_delete"
                                        class="" value="1"
                                         '.(in_array('customer_delete',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="customer_delete">حذف مشتری</label>
                                </div>
                            </div>
                            <div class="form-group wd-xs-300">
                                <div class=""
                                    style="margin-left: -1rem;">
                                    <input type="checkbox" id="customer_excel" name="customer_excel"
                                        class="" value="1"
                                         '.(in_array('customer_excel',$permissions) ? 'checked=""' : '').'
                                        >
                                    <label class="" for="customer_excel">خروجی اکسل</label>
                                </div>
                            </div>
                        </div>

                    </div>


                </section>

            </form>
        </div>
    </div>';

    return $list;
    }

    public function SubmitEditRole(Request $request)
    {
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
            'customer_excel'
        ];
    $role = Role::where('id',$request->role_id)->update([
            'name' => $request->role_name,
            'broker' => $request->broker_status
            ]);
    $role_model = Role::find($request->role_id);
    $array = $request->except(['role_name','_token','broker_status','role_id']);
    $role_model->revokePermissionTo($all_permissions);
    $role_model->givePermissionTo(array_keys($array));
    alert()->success('نقش با موفقیت ویرایش گردید', 'عملیات موفق')->autoclose(2000);
    return back();

    }
}
