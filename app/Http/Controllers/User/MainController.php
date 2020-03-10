<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MainController extends Controller
{
  public function index()
  {
    if (auth()->user()->hasRole('admin_panel')) {

      $broker_name = 'ادمین سایت';
      $broker_lists = '';
      $count = 1;

      if (Cache::has('pending_orders')) {

        $pending_orders = Cache::get('pending_orders');
      } else {
        $pending_orders = Cache::remember('pending_orders', 60, function () {
          return Order::where('order_type', 'معلق')->count();
        });
      }

      if (Cache::has('doing_orders')) {
        $doing_orders = Cache::get('doing_orders');
      } else {
        $doing_orders = Cache::remember('doing_orders', 60, function () {
          return Order::where('order_type', 'در حال انجام')->count();
        });
      }

      if (Cache::has('doing_orders')) {
        $users = User::all();
      } else {
        $users = Cache::remember('users', 60, function () {
          return User::all();
        });
      }

      if (Cache::has('doing_orders')) {
        $services = Service::all();
      } else {
        $services = Cache::remember('services', 60, function () {
          return Service::all();
        });
      }
      foreach ($users as $key => $broker) {
        if (count($broker->roles->where('broker', 1))) {

          $broker_services_array = $broker->services->pluck('id')->toArray();
          $broker_pending_orders = Order::whereIn('service_id', $broker_services_array)->where('order_type', 'معلق')->count();
          $broker_doing_orders = Order::whereIn('service_id', $broker_services_array)->where('order_type', 'در حال انجام')->count();
          $broker_reffered_orders = Order::whereIn('service_id', $broker_services_array)->where('order_type', 'انجام نشده')->count();
          $broker_performed_orders = Order::whereIn('service_id', $broker_services_array)->where('order_type', 'انجام شده')->count();
          $broker_lists .= ' <tr>
              <td>' . $count . '</td>
              <td>' . ($broker->roles->first()->name == 'admin_panel' ? 'ادمین' : $broker->roles->first()->name ). '</td>
              <td>' . $broker_pending_orders . '</td>
              <td>' . $broker_doing_orders . '</td>
              <td>' . $broker_reffered_orders . '</td>
              <td>' . $broker_performed_orders . '</td>
          </tr>';
          $count++;
        }
      }



      $service_chart_array = [];
      $service_chart_ordercount = [];

      foreach ($services as $key => $service) {

        if ($service->user->first() !== null) {
          $broker =  $service->user->first()->user_username;
        } else {
          $broker = '--';
        }
        array_push($service_chart_array, $service->service_title . '(کارگزاری ' . $broker . ')');
        $orders_service_count = Order::where('service_id', $service->id)->count();
        array_push($service_chart_ordercount, $orders_service_count);
      }


      $service_chart_json = json_encode($service_chart_array);
      $service_chart_array_count = count($service_chart_array);
      $service_chart_ordercount_json = json_encode($service_chart_ordercount);

      if (count($service_chart_ordercount)) {
        $max_Y =  max($service_chart_ordercount);
      } else {
        $max_Y = '';
      }
    } else {
      $broker_lists = '';
      $service_chart_json = '';
      $service_chart_ordercount_json = '';
      $max_Y = '';
      $service_array = auth()->user()->services->pluck('id')->toArray();
      if (count(auth()->user()->services)) {
        if (Cache::has('pending_orders')) {

          $pending_orders = Cache::get('pending_orders');
        } else {
          $pending_orders = Cache::remember('pending_orders', 60, function () use ($service_array) {
            return Order::whereIn('service_id', $service_array)->where('order_type', 'معلق')->count();
          });
        }


        if (Cache::has('doing_orders')) {
          $doing_orders = Cache::get('doing_orders');
        } else {
          $doing_orders = Cache::remember('doing_orders', 60, function () use ($service_array) {
            return Order::whereIn('service_id', $service_array)->where('order_type', 'در حال انجام')->count();
          });
        }


        $broker_name = auth()->user()->roles->first()->name;
      } else {
        $pending_orders = 0;
        $doing_orders = 0;
        $broker_name = auth()->user()->roles->first()->name;
      }



      $service_chart_array = [];
      $service_chart_ordercount = [];
      foreach (auth()->user()->services as $key => $service) {
        array_push($service_chart_array, $service->service_title);
        $orders_service_count = Order::where('service_id', $service->id)->count();
        array_push($service_chart_ordercount, $orders_service_count);
      }

      $service_chart_json = json_encode($service_chart_array);
      $service_chart_array_count = count($service_chart_array);
      $service_chart_ordercount_json = json_encode($service_chart_ordercount);

      if (count($service_chart_ordercount)) {
        $max_Y =  max($service_chart_ordercount);
      } else {
        $max_Y = '';
      }
    }


    return view('User.Dashboard', compact([
      'pending_orders',
      'doing_orders',
      'broker_name',
      'broker_lists',
      'service_chart_json',
      'service_chart_ordercount_json',
      'service_chart_array_count',
      'max_Y'
    ]));
  }


  public function UserList()
  {


    if (auth()->user()->hasRole('admin_panel')) {
      $roles = Role::all();
      $users = \App\Models\User::latest()->get();
    } else {
      if (auth()->user()->roles->first()->broker !== null) {
        $role_id = auth()->user()->roles->first()->id;
        $roles = Role::where('id', $role_id)->orWhere('sub_broker', $role_id)->get();
        $users =  User::whereHas('roles', function ($q) use ($role_id) {
          $q->where('id', $role_id)->orWhere('sub_broker', $role_id);
        })->get();
      }

      if (auth()->user()->roles->first()->sub_broker !== null) {
        $role_id = auth()->user()->roles->first()->sub_broker;
        $roles = Role::where('id', $role_id)->orWhere('sub_broker', $role_id)->get();
        $users =  User::whereHas('roles', function ($q) use ($role_id) {
          $q->where('id', $role_id)->orWhere('sub_broker', $role_id);
        })->get();
      }
    }


    return view('User.UsersList', compact(['users', 'roles']));
  }

  public function UserOrderBy(Request $request)
  {

    if ($request->data == 'name') {
      $users = \App\Models\User::OrderBy('user_firstname', 'ASC')->get();
    }
    if ($request->data == 'lastname') {
      $users = \App\Models\User::OrderBy('user_lastname', 'ASC')->get();
    }
    if ($request->data == 'username') {
      $users = \App\Models\User::OrderBy('user_username', 'ASC')->get();
    }

    $tbody = '';
    foreach ($users as $key => $user) {
      $tbody .= '
        <tr>
        <td>
          <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
          <input data-id="' . $user->id . '" type="checkbox" id="' . $key . '" name="customCheckboxInline1" class="custom-control-input" value="1">
            <label class="custom-control-label" for="' . $key . '"></label>
          </div>
        </td>
        <td> ' . ($key + 1) . ' </td>
        <td>' . $user->user_firstname . '</td>
        <td>' . $user->user_lastname . '</td>
        <td>' . $user->user_username . '</td>
        <td>' . $user->user_responsibility . '</td>
        <td>' . $user->user_national_code . '</td>
        <td>' . $user->user_mobile . '</td>
        <td>
          ' . ($user->user_prfile_pic !== '' ?
        '<img width="75px" class="img-fluid " src="uploads/users/profile_pic/' . $user->user_national_code . '/' . $user->user_prfile_pic . ' " />'
        :
        '<img width="75px" class="img-fluid " src="Pannel/img/avatar.jpg" />') . '
          
        </td>
      </tr>

        ';
    }

    return $tbody;
  }

  public function FilterUsers(Request $request)
  {

    $users =  User::where('user_firstname', 'like', '%' . $request->word . '%')
      ->get();
    return view('User.UsersList', compact('users'));
  }

  public function SubmitUser(Request $request)
  {



    if (User::where('user_national_code', $request->user_national_num)->first() !== null) {
      alert()->error('کاربر دیگری با این کد ملی ثبت نام کرده است', 'عملیات ناموفق')->autoclose(3500);
      return back();
    }
    if (User::where('user_mobile', $request->user_mobile)->first() !== null) {
      alert()->error('کاربر دیگری با این شماره همراه ثبت نام کرده است', 'عملیات ناموفق')->autoclose(3500);
      return back();
    }

    $role = Role::where('name', $request->user_responsibility)->first();
    if ($role->broker == 1) {
      $role_name = $role->name;
    }
    if ($role->sub_broker !== null) {
      $role_name = Role::where('id', $role->sub_broker)->first()->name;
    }


    $URL = public_path('uploads/brokers');

    if ($request->has('user_profile')) {
      $file = $request->user_mobile . '.' . $request->user_profile->getClientOriginalExtension();

      $request->user_profile->move($URL . '/' . $role_name . '/' . $request->user_mobile, $file);
      $fileName = $role_name . '/' . $request->user_mobile . '/' . $file;
    } else {
      $fileName = '';
    }

    $user = User::create([
      'user_firstname' => $request->user_name,
      'user_lastname' => $request->user_family,
      'user_username' => $request->username,
      'user_email' => $request->user_email,
      'user_mobile' => $request->user_mobile,
      'user_national_code' => $request->user_national_num,
      'user_responsibility' => $request->user_responsibility,
      'user_password' => Hash::make($request->user_pass),
      'user_prfile_pic' => $fileName,
    ]);


    $user->assignRole($request->user_responsibility);


    // Alert::success( 'اطلاعات با موفقیت ثبت شد','موفق')->persistent("باشه");
    alert()->success('کاربر با موفقیت ثبت شد', 'عملیات موفق')->autoclose(2000);
    return back();
  }

  public function getUserData(Request $request)
  {


    $user = User::where('id', $request->user_id)->first();

    $csrf = csrf_token();
    $list = '
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ویرایش کاربر</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit--form" method="post" action="' . route('User.Edit.Submit') . '" enctype="multipart/form-data">
      
      <input type="hidden" name="_token" value="' . $csrf . '">
     
      <input type="hidden" name="user_id" value="' . $user->id . '">

      <div class="modal-body">
          <div class="row">
            <div class="col-md-12" style="display: flex;align-items: center;justify-content: center;">
              <div class="profile-img">
                  <div class="chose-img">
                      <input type="file" class="btn-chose-img" name="user_profile" title="نوع فایل میتواند png , jpg  باشد">
                  </div>
                  ' . ($user->user_prfile_pic !== '' ?
      '<img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;" src="' . route('BaseUrl') . '/uploads/brokers/' . $user->user_prfile_pic . '" alt="">
                  <p class="text-chose-img" style="position: absolute;top: 82%;left: 14%;font-size: 13px;">تغییر
                      پروفایل</p>
                  ' : '<img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;" src="' . route('BaseUrl') . '/Pannel/img/temp_logo.jpg" alt="">
                  <p class="text-chose-img" style="position: absolute;top: 44%;left: 14%;font-size: 13px;">ثبت
                      پروفایل</p>
                  ') . '
                  
              </div>
          </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_name" class="col-form-label"><span class="text-danger">*</span> نام: </label>
              <input type="text" class="form-control" name="user_name" value="' . $user->user_firstname . '" id="user_name">
            </div>
            <div class="form-group col-md-6">
              <label for="user_family" class="col-form-label"><span class="text-danger">*</span> نام خانوادگی:</label>
              <input type="text" class="form-control" name="user_family" value="' . $user->user_lastname . '" id="user_family">
            </div>
          </div>
         ';
    if (auth()->user()->can('user_pass')) {
      $list .= ' <div class="row">
           <div class="form-group col-md-6">
             <label for="user_pass" class="col-form-label"><span class="text-danger">*</span> تغییر پسورد: </label>
             <input type="text" class="form-control" name="user_pass" id="user_passa">
           </div>
           <div class="form-group col-md-6">
             <label for="confirm_user_pass" class="col-form-label"><span class="text-danger">*</span> تکرار
               پسورد:</label>
             <input type="text" class="form-control" name="confirm_user_pass" id="confirm_user_pass">
           </div>
         </div>';
    }

    $list .= '<div class="row">
            <div class="form-group col-md-6">
              <label for="user_email" class="col-form-label">ایمیل:</label>
              <input type="text" value="' . $user->user_email . '"  class="form-control" name="user_email" id="user_email">
            </div>
            <div class="form-group col-md-6">
              <label for="username" class="col-form-label"><span class="text-danger">*</span> نام کاربری:</label>
              <input type="text" value="' . $user->user_username . '"  class="form-control" name="username" id="username">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_mobile" class="col-form-label"><span class="text-danger">*</span> موبایل:</label>
              <input type="text" disabled value="' . $user->user_mobile . '"  class="form-control"  id="user_mobile">
              <input type="hidden"  value="' . $user->user_mobile . '"  class="form-control" name="user_mobile">

              </div>
            <div class="form-group col-md-6">
              <label for="user_national_num" class="col-form-label">کد ملی:</label>
              <input type="text"  value="' . $user->user_national_code . '"  class="form-control" name="user_national_num" id="user_national_num">
            </div>
          </div>
         
          <p>انتخاب نقش: </p>
          <div class="row">';
    foreach (Role::all() as $key => $role) {
      $list .= '<div class="mx-2">
            <input type="radio" 
            
            id="customRadioInline4" name="user_responsibility" class=""
              value="' . $role->name . '">
            <label class="" for="customRadioInline4">' . $role->name . '</label>
          </div>';
    }

    $list .= ' </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
      </form>
        ';

    return $list;
  }

  public function SubmitUserEdit(Request $request)
  {
    $URL = public_path('uploads/brokers');
    $user = User::where('id', $request->user_id)->first();
    $role = Role::where('name', $request->user_responsibility)->first();
    if ($role->broker == 1) {
      $role_name = $role->name;
    }
    if ($role->sub_broker !== null) {
      $role_name = Role::where('id', $role->sub_broker)->first()->name;
    }

    if ($request->has('user_profile') && $request->user_pass !== null) {

      File::delete($URL . $user->user_prfile_pic);

      $file = $request->user_mobile . '.' . $request->user_profile->getClientOriginalExtension();

      $request->user_profile->move($URL . '/' . $role_name . '/' . $request->user_mobile, $file);
      $fileName = $role_name . '/' . $request->user_mobile . '/' . $file;

      $array = [
        'user_firstname' => $request->user_name,
        'user_lastname' => $request->user_family,
        'user_username' => $request->username,
        'user_email' => $request->user_email,
        'user_mobile' => $request->user_mobile,
        'user_national_code' => $request->user_national_num,
        'user_responsibility' => $request->user_responsibility,
        'user_password' => Hash::make($request->user_pass),
        'user_prfile_pic' => $fileName
      ];
    }

    if ($request->has('user_profile') && $request->user_pass == null) {

      File::delete($URL . $user->user_prfile_pic);

      $file = $request->user_mobile . '.' . $request->user_profile->getClientOriginalExtension();

      $request->user_profile->move($URL . '/' . $role_name . '/' . $request->user_mobile, $file);
      $fileName = $role_name . '/' . $request->user_mobile . '/' . $file;

      $array = [
        'user_firstname' => $request->user_name,
        'user_lastname' => $request->user_family,
        'user_username' => $request->username,
        'user_email' => $request->user_email,
        'user_mobile' => $request->user_mobile,
        'user_national_code' => $request->user_national_num,
        'user_responsibility' => $request->user_responsibility,
        'user_password' => Hash::make($request->user_pass),
        'user_prfile_pic' => $fileName
      ];
    }
    if (!$request->has('user_profile') && $request->user_pass !== null) {
      $array = [
        'user_firstname' => $request->user_name,
        'user_lastname' => $request->user_family,
        'user_username' => $request->username,
        'user_email' => $request->user_email,
        'user_mobile' => $request->user_mobile,
        'user_national_code' => $request->user_national_num,
        'user_responsibility' => $request->user_responsibility,
        'user_password' => Hash::make($request->user_pass),
      ];
    }
    if (!$request->has('user_profile') && $request->user_pass == null) {
      $array = [
        'user_firstname' => $request->user_name,
        'user_lastname' => $request->user_family,
        'user_username' => $request->username,
        'user_email' => $request->user_email,
        'user_mobile' => $request->user_mobile,
        'user_national_code' => $request->user_national_num,
        'user_responsibility' => $request->user_responsibility,

      ];
    }


    User::where('id', $request->user_id)->update($array);




    if ($request->has('user_responsibility')) {
      if (!$user->hasRole($request->user_responsibility)) {
        $user->syncRoles($user->user_responsibility);
      }
    }


    alert()->success('اطلاعات کاربر با موفقیت ویرایش شد ', 'عملیات موفق')->autoclose(2000);
    return back();
  }
  public function DeleteUser(Request $request)
  {


    foreach ($request->array as $user_id) {
      User::where('id', $user_id)->delete();
    }
    return 'success';
  }

  public function getTime()
  {
    $data = array(
      'fulldate' => date('d-m-Y H:i:s'),
      'date' => date('d'),
      'month' => date('m'),
      'year' => date('Y'),
      'hour' => date('H'),
      'minute' => date('i'),
      'second' => date('s')
    );
    return json_encode($data);
  }
}
