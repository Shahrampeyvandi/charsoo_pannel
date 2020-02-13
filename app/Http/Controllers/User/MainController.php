<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index()
    {
        return view('User.Dashboard');
    }

    public function UserList()
    {
        return view('User.UsersList');
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

        $insert_status = User::create([
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
     
      <input type="hidden" name="user_national_num" value="'.$user->user_national_code.'">

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
          <div class="row">
          <div class="mx-2">
          <input type="radio" 
          '.($user->user_responsibility == 'مدیریت' ? 'checked=""' : '').'
          id="customRadioInline4" name="user_responsibility" class=""
            value="مدیریت">
          <label class="" for="customRadioInline4">مدیریت</label>
        </div>

          <div class="mx-2">
            <input type="radio" id="customRadioInline1" name="user_responsibility"
              class=" " checked="" 
              '.($user->user_responsibility == 'tester' ? 'checked=""' : '').'
               value="tester">
            <label class=" " for="customRadioInline1">tester</label>
          </div>
          <div class="mx-2">
            <input type="radio" id="customRadioInline2" name="user_responsibility"
              class=" " '.($user->user_responsibility == 'مشتری' ? 'checked=""' : '').' value="مشتری">
            <label class="" for="customRadioInline2">مشتری</label>
          </div>
          <div class="mx-2">
            <input type="radio"
            '.($user->user_responsibility == 'خدمت رسان' ? 'checked=""' : '').'
            id="customRadioInline3" name="user_responsibility" class=""
              value="خدمت رسان">
            <label class="" for="customRadioInline3">خدمت رسان</label>
          </div>
          
          <div class="mx-2">
            <input type="radio" 
            '.($user->user_responsibility == 'adminbuilding' ? 'checked=""' : '').'
            id="customRadioInline5" name="user_responsibility" class=""
              value="adminbuilding">
            <label class="" for="customRadioInline5">adminbuilding</label>
          </div>
          <div class="mx-2">
            <input type="radio" 
            '.($user->user_responsibility == 'unitbuilding' ? 'checked=""' : '').'
            id="customRadioInline6" name="user_responsibility" class=""
              value="unitbuilding">
            <label class="" for="customRadioInline6">unitbuilding</label>
          </div>
          <div class="mx-2">
            <input type="radio" 
            '.($user->user_responsibility == 'zitco' ? 'checked=""' : '').'
            id="customRadioInline7" name="user_responsibility" class=""
              value="zitco">
            <label class="" for="customRadioInline7">zitco</label>
          </div>
        </div>


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

           
            User::where('user_national_code',$request->user_national_num)->update($array);
       
   

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
