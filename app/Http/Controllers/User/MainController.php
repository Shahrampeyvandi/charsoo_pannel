<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MainController extends Controller
{
    public function index()
    {
      if (auth()->user()->id == 1) {
        $pending_orders = Order::where('order_type','معلق')->count();
        $doing_orders = Order::where('order_type','در حال انجام')->count();
        $broker_name = 'ادمین سایت';
        $broker_lists = '';
        $count = 1;
        foreach (User::all() as $key => $broker) {
          if (count($broker->roles->where('broker',1))) {
            
          $broker_services_array = $broker->services->pluck('id')->toArray();
          $broker_pending_orders = Order::whereIn('service_id',$broker_services_array)->where('order_type','معلق')->count();
          $broker_doing_orders = Order::whereIn('service_id',$broker_services_array)->where('order_type','در حال انجام')->count();
          $broker_reffered_orders = Order::whereIn('service_id',$broker_services_array)->where('order_type','ارجاع داده شده')->count();
          $broker_performed_orders = Order::whereIn('service_id',$broker_services_array)->where('order_type','انجام شده')->count();
          $broker_lists .= ' <tr>
              <td>'.$count.'</td>
              <td>'.$broker->roles->first()->name.'</td>
              <td>'.$broker_doing_orders.'</td>
              <td>'.$broker_reffered_orders.'</td>
              <td>'.$broker_performed_orders.'</td>
          </tr>';
          $count ++;
          }
        }

        $service_list_chart = Service::OrderBy('service_title')->pluck('service_title')->toJson();
      
        $service_chart_array = [];
        $service_chart_ordercount =[];
        foreach (Service::all() as $key => $service) {
          array_push($service_chart_array,$service->service_title);
         $orders_service_count = Order::where('service_id',$service->id)->count();
         array_push($service_chart_ordercount,$orders_service_count);
        }

      




      } else {
        $service_array = auth()->user()->services->pluck('id')->toArray();
        if (count(auth()->user()->services)) {
          $pending_orders = Order::whereIn('service_id',$service_array)->where('order_type','معلق')->count();
          $doing_orders = Order::whereIn('service_id',$service_array)->where('order_type','در حال انجام')->count();
          $broker_name = auth()->user()->roles->first()->name;
        }else{
          $pending_orders = 0;
          $doing_orders = 0;
          $broker_name = auth()->user()->roles->first()->name;
        }
      }


      return view('User.Dashboard',compact([
        'pending_orders',
        'doing_orders',
        'broker_name',
        'broker_lists',
        'service_list_chart'
        ]));
    }


    public function UserList()
    {
  
     $roles = Role::all();
      $users = \App\Models\User::latest()->get();
      return view('User.UsersList',compact(['users','roles']));
    }

    public function UserOrderBy(Request $request)
    {
      
      if ($request->data == 'name') {
        $users = \App\Models\User::OrderBy('user_firstname','ASC')->get();
      }
      if ($request->data == 'lastname') {
        $users = \App\Models\User::OrderBy('user_lastname','ASC')->get();
      }
      if ($request->data == 'username') {
        $users = \App\Models\User::OrderBy('user_username','ASC')->get();
      }
      
      $tbody ='';
      foreach ($users as $key => $user) {
        $tbody .= '
        <tr>
        <td>
          <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
          <input data-id="'.$user->id.'" type="checkbox" id="'.$key.'" name="customCheckboxInline1" class="custom-control-input" value="1">
            <label class="custom-control-label" for="'.$key.'"></label>
          </div>
        </td>
        <td> '.($key+1).' </td>
        <td>'.$user->user_firstname.'</td>
        <td>'.$user->user_lastname.'</td>
        <td>'.$user->user_username.'</td>
        <td>'.$user->user_responsibility.'</td>
        <td>'.$user->user_national_code.'</td>
        <td>'.$user->user_mobile.'</td>
        <td>
          '.($user->user_prfile_pic !== '' ?
              '<img width="75px" class="img-fluid " src="uploads/users/profile_pic/'.$user->user_national_code.'/'.$user->user_prfile_pic.' " />'
          :
          '<img width="75px" class="img-fluid " src="Pannel/img/avatar.jpg" />'
).'
          
        </td>
      </tr>

        ';
      }
     
      return $tbody;
    }

    public function FilterUsers(Request $request)
    {
      
    $users =  User::where('user_firstname', 'like', '%' . $request->word. '%')
      ->get();
      return view('User.UsersList',compact('users'));

 
    }

    public function SubmitUser(Request $request)
    {
        

        if(User::where('user_national_code',$request->user_national_num)->first() !== null){
            alert()->error('کاربر دیگری با این کد ملی ثبت نام کرده است', 'عملیات ناموفق')->autoclose(3500);
            return back();
        }
        if(User::where('user_mobile',$request->user_mobile)->first() !== null){
            alert()->error('کاربر دیگری با این شماره همراه ثبت نام کرده است', 'عملیات ناموفق')->autoclose(3500);
            return back();
        }

        
        if ($request->has('user_profile')) {
            $fileName = $request->user_national_num . '.' . $request->user_profile->getClientOriginalExtension();
            $fileNameWithoutEx = pathinfo($fileName, PATHINFO_FILENAME);
            $request->user_profile->move(public_path('uploads/users/profile_pic/'.$request->user_national_num), $fileName);
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
        

       $user = User::where('id',$request->user_id)->first();
      
       $csrf = csrf_token();
        $list = '
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ویرایش کاربر</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit--form" method="post" action="'.route('User.Edit.Submit').'" enctype="multipart/form-data">
      
      <input type="hidden" name="_token" value="'.$csrf.'">
     
      <input type="hidden" name="user_national_num" value="'.$user->id.'">

      <div class="modal-body">
          <div class="row">
            <div class="col-md-12" style="display: flex;align-items: center;justify-content: center;">
              <div class="profile-img">
                  <div class="chose-img">
                      <input type="file" class="btn-chose-img" name="user_profile" title="نوع فایل میتواند png , jpg  باشد">
                  </div>
                  '.($user->user_prfile_pic !== '' ? 
                  '<img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;" src="'.route('BaseUrl').'/uploads/users/profile_pic/'.$user->user_national_code.'/'.$user->user_prfile_pic.'" alt="">
                  <p class="text-chose-img" style="position: absolute;top: 82%;left: 14%;font-size: 13px;">تغییر
                      پروفایل</p>
                  ' : '<img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;" src="'.route('BaseUrl').'/Pannel/img/temp_logo.jpg" alt="">
                  <p class="text-chose-img" style="position: absolute;top: 44%;left: 14%;font-size: 13px;">ثبت
                      پروفایل</p>
                  '
                  ).'
                  
              </div>
          </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_name" class="col-form-label"><span class="text-danger">*</span> نام: </label>
              <input type="text" class="form-control" name="user_name" value="'.$user->user_firstname.'" id="user_name">
            </div>
            <div class="form-group col-md-6">
              <label for="user_family" class="col-form-label"><span class="text-danger">*</span> نام خانوادگی:</label>
              <input type="text" class="form-control" name="user_family" value="'.$user->user_lastname.'" id="user_family">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_pass" class="col-form-label"><span class="text-danger">*</span> تغییر پسورد: </label>
              <input type="text" class="form-control" name="user_pass" id="user_passa">
            </div>
            <div class="form-group col-md-6">
              <label for="confirm_user_pass" class="col-form-label"><span class="text-danger">*</span> تکرار
                پسورد:</label>
              <input type="text" class="form-control" name="confirm_user_pass" id="confirm_user_pass">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_email" class="col-form-label">ایمیل:</label>
              <input type="text" value="'.$user->user_email.'"  class="form-control" name="user_email" id="user_email">
            </div>
            <div class="form-group col-md-6">
              <label for="username" class="col-form-label"><span class="text-danger">*</span> نام کاربری:</label>
              <input type="text" value="'.$user->user_username.'"  class="form-control" name="username" id="username">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_mobile" class="col-form-label"><span class="text-danger">*</span> موبایل:</label>
              <input type="text" value="'.$user->user_mobile.'"  class="form-control" name="user_mobile" id="user_mobile">
            </div>
            <div class="form-group col-md-6">
              <label for="user_national_num" class="col-form-label">کد ملی:</label>
              <input type="text" disabled value="'.$user->user_national_code.'"  class="form-control" name="user_national_num" id="user_national_num">
            </div>
          </div>
         
          <p>انتخاب نقش: </p>
          <div class="row">';
          foreach (Role::all() as $key => $role) {
            $list .= '<div class="mx-2">
            <input type="radio" 
            
            id="customRadioInline4" name="user_responsibility" class=""
              value="'.$role->id.'">
            <label class="" for="customRadioInline4">'.$role->name.'</label>
          </div>';
          }
    
       $list .=' </div>


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
      
        if ($request->has('user_profile') && $request->user_pass !== null) {
            
            File::deleteDirectory(public_path('uploads/users/profile_pic/'.$request->user_national_num));

            $fileName = $request->user_national_num . '.' . $request->user_profile->getClientOriginalExtension();
            $fileNameWithoutEx = pathinfo($fileName, PATHINFO_FILENAME);
            $request->user_profile->move(public_path('uploads/users/profile_pic/'.$request->user_national_num), $fileName);
            $array =[
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
            
            File::deleteDirectory(public_path('uploads/users/profile_pic/'.$request->user_national_num));

            $fileName = $request->user_national_num . '.' . $request->user_profile->getClientOriginalExtension();
            $fileNameWithoutEx = pathinfo($fileName, PATHINFO_FILENAME);
            $request->user_profile->move(public_path('uploads/users/profile_pic/'.$request->user_national_num), $fileName);
            $array =[
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
            $array =[
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
            $array =[
                'user_firstname' => $request->user_name,
                'user_lastname' => $request->user_family,
                'user_username' => $request->username,
                'user_email' => $request->user_email,
                'user_mobile' => $request->user_mobile,
                'user_national_code' => $request->user_national_num,
                'user_responsibility' => $request->user_responsibility,
               
        ];
        }

           
           User::where('id',$request->user_national_num)->update($array);
           $user = User::where('id',$request->user_national_num)->first();
        


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
            User::where('id',$user_id)->delete();
        }
        return 'success';
    }
}
