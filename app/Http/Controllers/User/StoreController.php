<?php

namespace App\Http\Controllers\User;

use App\Models\City\City;
use App\Models\Store\Store;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\Services\Service;
use App\Models\Personals\Personal;
use App\Http\Controllers\Controller;
use App\Models\Store\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{
  public function index()
  {
    if (auth()->user()->hasRole('admin_panel')) {
      if (Cache::has('stores')) {
        $stores = Cache::get('stores');
      } else {
        $stores = Cache::remember('stores', 60, function () {
          return Store::latest()->get();
        });
      }
    } else {
      if (auth()->user()->roles->first()->broker == 1) {
        $role_name = auth()->user()->roles->first()->name;
        $stores = Store::where('service_role', $role_name)->latest()->get();
      }

      if (auth()->user()->roles->first()->sub_broker !== null) {
        $role_name = Role::where('id', auth()->user()->roles->first()->sub_broker)->first()->name;
        $stores = Store::where('service_role', $role_name)->latest()->get();
      }
    }

    return view('User.Stores.StoresList', compact('stores'));
  }

  public function submitStore(Request $request)
  {


    if ($request->has('owner_profile')) {
      $file = 'photo' . '.' . $request->owner_profile->getClientOriginalExtension();
      $request->owner_profile->move(public_path('uploads/personals/' . $request->mobile), $file);
      $owner_profile = 'personals/' . $request->mobile . '/' . $file;
    } else {
      $owner_profile = '';
    }

    if ($request->has('store_picture')) {
      $file = 'photo' . '.' . $request->store_picture->getClientOriginalExtension();
      $request->store_picture->move(public_path('uploads/stores/' . $request->store_name), $file);
      $store_picture =  $request->store_name . '/' . $file;
    } else {
      $store_picture = '';
    }
    $personal = Personal::create([
      'personal_status' => 1,
      'personal_firstname' => $request->firstname,
      'personal_lastname' => $request->lastname,
      'personal_birthday' => $this->convertDate($request->birth_year)->toDateString(),
      'personal_national_code' => $request->national_num,
      'personal_mobile' => $request->mobile,
      'personal_city' => $request->city,
      'personal_home_phone' => $request->tel_home,
      'personal_office_phone' => $request->tel_work,
      'personal_profile' => $owner_profile
    ]);

    $store =   $personal->store()->create([
      'store_name' => $request->store_name,
      'store_type' => $request->store_type,
      'store_address' => $request->store_address,
      'store_picture' => $request->store_picture,
      'store_name' => $request->store_name,
      'store_type' => $request->store_type,
      'store_description' => $request->store_descripton,
      'store_city' => $request->store_city,
      'store_main_street' => $request->store_main_street,
      'store_secondary_street' => $request->store_secondary_street,
      'store_neighborhoods' => $request->neighborhood_id,
      'store_pelak' => $request->store_pluck_num,
      'store_picture' => $store_picture,
    ]);

    if (strlen(implode($request->product_name)) == 0) {
      alert()->success('فروشگاه ثبت شد اما محصولی وارد نشده است', 'خطا')->persistent('بستن');
      return back();
    } else {
      $count = 0;
      foreach ($request->product_name as $key => $item) {
        if (!is_null($item)) {
          if (array_key_exists($key, $request->product_picture)) {
            $file = 'photo' . '.' . $request->product_picture[$key]->getClientOriginalExtension();
            $request->product_picture[$key]->move(public_path('uploads/products/' . $item), $file);
            $product_picture = 'products/' . $item . '/' . $file;
          } else {
            $product_picture = '';
          }
          $store->products()->create([
            'product_name' => $item,
            'product_price' => $request->product_price[$key],
            'product_picture' => $product_picture,
            'product_description' => $request->product_description[$key],
            'product_status' => 1,
          ]);
          $count++;
        }
      }
    }





    alert()->success('فروشگاه با موفقیت افزوده شد و ' . $count . ' محصول هم ثبت شد ', 'عملیات موفق')->persistent('بستن');
    return back();
  }

  public function getStoreData(Request $request)
  {
    $store = Store::where('id', $request->store_id)->first();
    $personal = Personal::where('id', $store->owner_id)->first();
    $csrf = csrf_token();

    $list = '';

    $list .= '<form id="example-advanced-form1" method="post" action="' . route('Pannel.Services.submitStore') . '"
    enctype="multipart/form-data">
    ' . method_field('PUT') . '
    <input type="hidden" name="_token" value="' . $csrf . '">
    <input type="hidden" name="store_id" value="' . $store->id . '">
    <h3>مشخصات فردی</h3>
    <section>
        <div class="row">
            <div class="col-md-12"
                style="display: flex;align-items: center;justify-content: center;">
                <div class="profile-img">
                    <div class="chose-img">
                        <input type="file" class="btn-chose-img" name="owner_profile"
                            title="نوع فایل میتواند png , jpg  باشد">
                    </div>';
    if ($personal->personal_profile !== null || $personal->personal_profile !== '') {
      $list .= ' <img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;"
                      src="' . route('BaseUrl') . '/uploads/' . $personal->personal_profile . '" alt="">
                  <p class="text-chose-img"
                      style="position: absolute;top: 44%;left: 14%;font-size: 13px;">ویرایش
                      پروفایل</p>';
    } else {
      $list .= ' <img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;"
                      src="' . route('BaseUrl') . '/Pannel/img/temp_logo.jpg" alt="">
                  <p class="text-chose-img"
                      style="position: absolute;top: 44%;left: 14%;font-size: 13px;">انتخاب
                      پروفایل</p>';
    }

    $list .= ' </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6" style="padding-top: 11px;">
                <label class="form-control-label"> <span class="text-danger">*</span> تلفن همراه
                </label>
                <input class="form-control text-right" id="p_mobile" name="mobile" placeholder=""
                value="' . $personal->personal_mobile . '"
                    type="number" dir="ltr">

            </div><!-- form-group -->
            <div class="form-group col-md-6">
                <label>نام </label>
                <input type="text" id="firstname" name="firstname" class="form-control"
                value="' . $personal->personal_firstname . '"
                    placeholder="نام">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
        </div>
        <div class="row">




            <div class="form-group col-md-6">
                <label>نام خانوادگی</label>
                <input type="text" id="lastname" name="lastname" class="form-control"
                value="' . $personal->personal_lastname . '"
                    placeholder="نام خانوادگی">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
            <div class="form-group col-md-6">
                            <label>تاریخ تولد (فرمت صحیح: 1366/11/02)</label>
                            <input type="text" name="birth_year"
                             class="date-picker-shamsi-list form-control"
                             value="' . Jalalian::forge($personal->personal_birthday)->format('%Y/%m/%d') . '"
                             onblur="isValidDate(event,this.value)"
                             id="birth_year1" 
                             placeholder="">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>کد ملی </label>
                <input type="number" onblur="checknationalcode(this.value)" name="national_num"
                value="' . $personal->personal_national_code . '"
                    id="user_national_num" class="form-control" placeholder="">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">جنسیت: </label>
                <select name="gender" class="form-control" id="exampleFormControlSelect2">
                    <option value="مرد">مرد</option>
                    <option value="زن">زن</option>
                </select>
            </div>
        </div>




    </section>
    <h3>اطلاعات تماس</h3>
    <section>
        <div class="row">
        <div class="form-group col-md-6">
                <label class="form-control-label"><span class="text-danger">*</span> تلفن محل
                    کار</label>
                <input id="tel_work" class="form-control text-right" name="tel_work"
                    onblur="validatePhone(event,this.value)" placeholder="" type="number"
                    value="' . $personal->personal_office_phone . '"
                    dir="ltr">

            </div><!-- form-group -->
            <div class="form-group col-md-6">
                <label class="form-control-label"> تلفن منزل: </label>
                <input id="tel_home" class="form-control text-right" name="tel_home"
                    onblur="validatePhone(event,this.value)" placeholder="" type="number" 
                    value="' . $personal->personal_home_phone . '"
                    dir="ltr">

            </div><!-- form-group -->
            
        </div>




    </section>
    <h3>مشخصات فروشگاه </h3>
    <section>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="form-control-label"><span class="text-danger">*</span> نام فروشگاه:
                </label>
                <input id="store_name" class="form-control text-right"
                value="' . $store->store_name . '"
                name="store_name"
                    placeholder="" type="text" dir="ltr">
            </div><!-- form-group -->
            <div class="form-group col-md-12">
                <label class="form-control-label">حوزه فعالیت</label>
                <input id="store_type" class="form-control text-right" name="store_type"
                    placeholder="" type="text" dir="ltr">
            </div><!-- form-group -->

            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">توضیحات تکمیلی: </label>
                <textarea id="store_descripton" class="form-control text-right"
                    name="store_descripton" type="text" dir="rtl">' . $store->store_description . '</textarea>
            </div>
            <div class="form-group col-md-6">
            <div class="product-img">
                <div class="chose-img">
                  <input type="file" class="btn-chose-img" id="store_picture" name="store_picture" title="نوع فایل میتواند png , jpg  باشد">
                </div>
                <img
                  style="background: #fff;
        max-width: 100%;
        height: 100%;
        width: 100%;"
                  src="' . route('BaseUrl') . '/uploads/stores/' . $store->store_picture . '" alt="">
                <p class="text-chose-img" style="position: absolute;top: 44%;left: 40%;font-size: 13px;">تغییر 
                  تصویر</p>
              </div>
        </div><!-- form-group --> 
           
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">نام شهر: </label>
                <select name="city" class="form-control" id="exampleFormControlSelect2">';
    $city = $store->store_city;
    foreach (\App\Models\City\City::all() as $key => $item) {
      $list .= '<option ' . ($city == $item->city_name ? 'selected=""' : '') . '  value="' . $item->id . '">' . $item->city_name . '</option>';
    }
    $list .= ' </select>
            </div>
            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">نام خیابان اصلی: </label>
                <input id="store_main_street" class="form-control text-right"
                value="' . $store->store_main_street . '"
                    name="store_main_street" type="text" dir="rtl">
            </div>

            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">نام خیابان فرعی: </label>
                <input id="store_secondary_street" class="form-control text-right"
                value="' . $store->store_secondary_street . '"
                    name="store_secondary_street" type="text" dir="rtl">
            </div>


            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">شماره پلاک </label>
                <input id="store_pluck_num" class="form-control text-right" type="number"
                value="' . $store->store_pelak . '"
                    name="store_pluck_num" dir="rtl">
            </div>

        </div>
    </section>
    <h3>محدوده های تحت پوشش  </h3>
    <section>


        <div class="row">
            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">نام شهر: </label>
                <select name="store_city" class="form-control" data-id=' . $store->id . ' id="store_city_edit">
                    <option value="">باز کردن فهرست انتخاب</option>
                    <option value="مشهد">مشهد</option>
                    <option value="نیشابور">نیشابور</option>
                    <option value="فریمان">فریمان</option>
                    <option value="سبزوار">سبزوار</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12 regions">

            </div>
        </div>


    </section>
    <h3>محصولات</h3>
    <section>
   ';
    if (count($store->products) == 0) {
      $list .= ' <div class="row product-detail mb-2" style="position: relative;">
    <div class="form-group col-md-6">
        <label for="recipient-name" class="col-form-label">نام محصول</label>
        <input id="product_name" class="form-control text-right" name="product_name[]"
            type="text" dir="rtl">
            <input type="hidden" name="product_id[]" value > 
    </div>
    <div class="form-group col-md-6">
        <label for="recipient-name" class="col-form-label">قیمت محصول</label>
        <input id="product_price" class="form-control text-right" name="product_price[]"
            type="number" dir="rtl">
    </div>
    <div class="form-group col-md-6">
        <label for="recipient-name" class="col-form-label">تصویر محصول</label>
        <input id="product_picture" class="form-control text-right" name="product_picture[]"
            type="file" dir="rtl">
    </div>
   
    <div class="form-group col-md-12">
        <label for="recipient-name" class="col-form-label">توضیح محصول: </label>
        <textarea id="product_description" class="form-control text-right"
            name="product_description[]" type="text" dir="rtl"></textarea>
    </div>
  </div>
  ';
    } else {
      foreach ($store->products as $key => $product) {
        $list .= '<div class="row ' . ($key == 0 ? 'product-detail' : '') . '  my-2" style="position: relative;">
      <div class="form-group col-md-6">
      
          <label for="recipient-name" class="col-form-label">نام محصول</label>
          <input id="product_name" class="form-control text-right" name="product_name[]"
          value="' . $product->product_name . '"
              type="text" dir="rtl">
          <input type="hidden" name="product_id[]" value="' . $product->id . '" >  
      </div>
      <div class="form-group col-md-6">
          <label for="recipient-name" class="col-form-label">قیمت محصول</label>
          <input id="product_price" class="form-control text-right" name="product_price[]"
          value="' . $product->product_price . '"
              type="number" dir="rtl">
      </div>
      <div class="form-group col-md-6">
      <div class="product-img">
          <div class="chose-img">
            <input type="file" class="btn-chose-img" id="product_picture" name="product_picture[]" title="نوع فایل میتواند png , jpg  باشد">
          </div>
          <img
            style="background: #fff;
    max-width: 100%;
    height: 100%;
    width: 100%;"
            src="' . route('BaseUrl') . '/uploads/' . $product->product_picture . '" alt="">
          <p class="text-chose-img" style="position: absolute;top: 44%;left: 40%;font-size: 13px;">تغییر 
            تصویر</p>
        </div>
  </div><!-- form-group --> 
     
      <div class="form-group statuses  col-md-6 pt-4">
          <span>وضعیت محصول</span>
          <div class="">
              <label class="" for="product_status">موجود</label>
              <input style="display:inline-block;" value="1" type="checkbox" class=""
              ' . ($product->product_status == 1 ? 'checked=""' : '') . '
                  name="product_status[' . $key . ']" id="product_status">
          </div>
          <div class="">
          <span>این محصول حذف شود</span>
      <label class="" for="product_status"></label>
      <input style="display:inline-block;" value="1" type="checkbox" class=""
      
          name="product_delete[' . $key . ']" id="">
 

      </div>

      </div>
      
      
      <div class="form-group col-md-12">
          <label for="recipient-name" class="col-form-label">توضیح محصول: </label>
          <textarea id="product_description" class="form-control text-right"
              name="product_description[]" type="text" dir="rtl">' . $product->product_description . '</textarea>
      </div>
  </div>';
      }
    }


    $list .= '    <div class="clone"></div>
        <a href="#" class="clone-bottom">افزودن محصول</a>
    </section>
    <h3>محصولات متفرقه: </h3>
    <section>
        <div class="row sundry-product-detail mb-2" style="position: relative;">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">نام محصول</label>
                <input id="sundry_product_name" class="form-control text-right"
                    name="sundry_product_name[]" type="text" dir="rtl">
                  
            </div>
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">قیمت محصول</label>
                <input id="sundry_product_price" class="form-control text-right"
                    name="sundry_product_price[]" type="number" dir="rtl">
            </div>
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">تصویر محصول</label>
                <input id="sundry_product_picture" class="form-control text-right"
                    name="sundry_product_picture[]" type="file" dir="rtl">
            </div>
        </div>
        <div class="clone"></div>
        <a href="#" class="sundry-clone-bottom">افزودن محصول</a>
    </section>
    </form>';

    return $list;
  }
  public function getOwnerData(Request $request)
  {
    $personal = Personal::where('personal_mobile', $request->mobile)->first();
    $data = [];
    if (!is_null($personal)) {
      $data['personal_national_code'] = $personal->personal_national_code;
      $data['personal_firstname'] = $personal->personal_firstname;
      $data['personal_lastname'] = $personal->personal_lastname;
      $data['personal_birthday'] = Jalalian::forge($personal->personal_birthday)->format('%Y/%m/%d');


      return response()->json($data, 200);
    } else {
      return response()->json('error', 200);
    }
  }


  public function getCityRegions(Request $request)
  {
    // $regions =  City::where('name', $request->city_name)->first()->regions;
    if ($request->city_name == 'مشهد') {
      $list = '';
      $list .= '<div style="padding: 10px;
            background: #efefef;margin-bottom:4px;
            border-radius: 4px;"><h6 class="mb-3">ناحیه یک </h6><div class="row">';
      $list .= '<div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="بهشت">
            <label class="mx-2" for="">بهشت</label>
           </div>
          </div>
        
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="راهنمایی">
            <label class="mx-2" for="">راهنمایی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="احمد اباد">
            <label class="mx-2" for="">احمد اباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سعد اباد">
            <label class="mx-2" for="">سعد اباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سناباد">
            <label class="mx-2" for="">سناباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="گوهرشاد">
            <label class="mx-2" for="">گوهرشاد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="ارشاد">
            <label class="mx-2" for="">ارشاد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سجاد">
            <label class="mx-2" for="">سجاد</label>
           </div>
          </div>
          ';
      $list .= '</div></div>';

      // منطقه 2
      $list .= '<div style="padding: 10px;
            background: #efefef;margin-bottom:4px;
            border-radius: 4px;"><h6 class="mb-3">ناحیه 2 </h6><div class="row">';
      $list .= '<div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="شفا">
            <label class="mx-2" for="">شفا</label>
           </div>
          </div>
        
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سمزقند">
            <label class="mx-2" for="">سمزقند</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="ایت ا.. عبادی">
            <label class="mx-2" for="">ایت ا.. عبادی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="عامل">
            <label class="mx-2" for="">عامل</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="شهید مطهری">
            <label class="mx-2" for="">شهید مطهری</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="شهید هنرور">
            <label class="mx-2" for="">شهید هنرور</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="ایثارگران">
            <label class="mx-2" for="">ایثارگران</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نان رضوی">
            <label class="mx-2" for="">نان رضوی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="پردیس">
            <label class="mx-2" for="">پردیس</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="گلبرگ ( حضرت ابوطالب )">
            <label class="mx-2" for="">گلبرگ ( حضرت ابوطالب ) </label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="موسوی قوچانی">
            <label class="mx-2" for="">موسوی قوچانی</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="قائم (حضرت عبدالمطلب )">
            <label class="mx-2" for=""> قائم (حضرت عبدالمطلب ) </label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سپاد (شهرک امام حسین)">
            <label class="mx-2" for="">سپاد (شهرک امام حسین)</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نوید">
            <label class="mx-2" for="">نوید</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نان رضوی">
            <label class="mx-2" for="">نان رضوی</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="بهاران (پارک پردیس )">
            <label class="mx-2" for="">بهاران (پارک پردیس ) </label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="حجت">
            <label class="mx-2" for="">حجت</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="مهدی اباد">
            <label class="mx-2" for="">مهدی اباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نوده">
            <label class="mx-2" for="">نوده</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="قائم">
            <label class="mx-2" for="">قائم</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="مشهدقلی">
            <label class="mx-2" for="">مشهدقلی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="زرکش">
            <label class="mx-2" for="">زرکش</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="کوی امیرالمومنین">
            <label class="mx-2" for="">کوی امیرالمومنین</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="کارخانه قند (جانبازان)">
            <label class="mx-2" for="">کارخانه قند (جانبازان) </label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="فرامرز عباسی ">
            <label class="mx-2" for="">فرامرز عباسی </label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="بلوار شاهنامه">
            <label class="mx-2" for="">بلوار شاهنامه</label>
           </div>
          </div>';
      $list .= '</div></div>';

      // ناحیه سه
      $list .= '<div style="padding: 10px;
        background: #efefef;margin-bottom:4px;
        border-radius: 4px;"><h6 class="mb-3">ناحیه 3 </h6><div class="row">';
      $list .= '<div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="گاز">
        <label class="mx-2" for="">گاز</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="راه اهن">
        <label class="mx-2" for="">راه اهن</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="فاطمیه">
        <label class="mx-2" for="">فاطمیه</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="هاشمی نژاد">
        <label class="mx-2" for="">هاشمی نژاد</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="رسالت">
        <label class="mx-2" for="">رسالت</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="دروی">
        <label class="mx-2" for="">دروی</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="طبرسی شمالی">
        <label class="mx-2" for="">طبرسی شمالی</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="سیس اباد">
        <label class="mx-2" for="">سیس اباد</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="بلال">
        <label class="mx-2" for="">بلال</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="خواجه ربیع">
        <label class="mx-2" for="">خواجه ربیع</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="بهمن">
        <label class="mx-2" for="">بهمن</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="قرقی">
        <label class="mx-2" for=""> قرقی </label>
        </div>
        </div>';
      $list .= '</div></div>';

      // ناحیه چهار

      $list .= '<div style="padding: 10px;
        background: #efefef;margin-bottom:4px;
        border-radius: 4px;"><h6 class="mb-3">ناحیه 4 </h6><div class="row">';
      $list .= '<div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="طلاب">
        <label class="mx-2" for="">طلاب</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="گلشور (بهشت )">
        <label class="mx-2" for="">گلشور (بهشت )</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="ایثار">
        <label class="mx-2" for="">ایثار</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="تلگرد">
        <label class="mx-2" for="">تلگرد</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="وحید">
        <label class="mx-2" for="">وحید</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="ابوذر">
        <label class="mx-2" for="">ابوذر</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="پنجتن">
        <label class="mx-2" for="">پنجتن</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="رده">
        <label class="mx-2" for="">رده</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="شهید قربانی">
        <label class="mx-2" for="">شهید قربانی</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="پنحتن ال عبا">
        <label class="mx-2" for="">پنحتن ال عبا</label>
        </div>
        </div>';
      $list .= '</div></div>';
    }

    if ($request->city_name == 'نیشابور') {
      $list = '';
    }
    return $list;
  }

  public function getEditCityRegions(Request $request)
  {
    $store = Store::where('id', $request->store_id)->first();
    if ($request->city_name == 'مشهد') {
      $list = '';
      $list .= '<div style="padding: 10px;
            background: #efefef;margin-bottom:4px;
            border-radius: 4px;"><h6 class="mb-3">ناحیه یک </h6><div class="row">';
      $list .= '<div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="بهشت">
            <label class="mx-2" for="">بهشت</label>
           </div>
          </div>
        
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="راهنمایی">
            <label class="mx-2" for="">راهنمایی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="احمد اباد">
            <label class="mx-2" for="">احمد اباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سعد اباد">
            <label class="mx-2" for="">سعد اباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سناباد">
            <label class="mx-2" for="">سناباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="گوهرشاد">
            <label class="mx-2" for="">گوهرشاد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="ارشاد">
            <label class="mx-2" for="">ارشاد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سجاد">
            <label class="mx-2" for="">سجاد</label>
           </div>
          </div>
          ';
      $list .= '</div></div>';

      // منطقه 2
      $list .= '<div style="padding: 10px;
            background: #efefef;margin-bottom:4px;
            border-radius: 4px;"><h6 class="mb-3">ناحیه 2 </h6><div class="row">';
      $list .= '<div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="شفا">
            <label class="mx-2" for="">شفا</label>
           </div>
          </div>
        
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سمزقند">
            <label class="mx-2" for="">سمزقند</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="ایت ا.. عبادی">
            <label class="mx-2" for="">ایت ا.. عبادی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="عامل">
            <label class="mx-2" for="">عامل</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="شهید مطهری">
            <label class="mx-2" for="">شهید مطهری</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="شهید هنرور">
            <label class="mx-2" for="">شهید هنرور</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="ایثارگران">
            <label class="mx-2" for="">ایثارگران</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نان رضوی">
            <label class="mx-2" for="">نان رضوی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="پردیس">
            <label class="mx-2" for="">پردیس</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="گلبرگ ( حضرت ابوطالب )">
            <label class="mx-2" for="">گلبرگ ( حضرت ابوطالب ) </label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="موسوی قوچانی">
            <label class="mx-2" for="">موسوی قوچانی</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="قائم (حضرت عبدالمطلب )">
            <label class="mx-2" for=""> قائم (حضرت عبدالمطلب ) </label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="سپاد (شهرک امام حسین)">
            <label class="mx-2" for="">سپاد (شهرک امام حسین)</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نوید">
            <label class="mx-2" for="">نوید</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نان رضوی">
            <label class="mx-2" for="">نان رضوی</label>
           </div>
          </div>
          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="بهاران (پارک پردیس )">
            <label class="mx-2" for="">بهاران (پارک پردیس ) </label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="حجت">
            <label class="mx-2" for="">حجت</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="مهدی اباد">
            <label class="mx-2" for="">مهدی اباد</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="نوده">
            <label class="mx-2" for="">نوده</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="قائم">
            <label class="mx-2" for="">قائم</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="مشهدقلی">
            <label class="mx-2" for="">مشهدقلی</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="زرکش">
            <label class="mx-2" for="">زرکش</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="کوی امیرالمومنین">
            <label class="mx-2" for="">کوی امیرالمومنین</label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="کارخانه قند (جانبازان)">
            <label class="mx-2" for="">کارخانه قند (جانبازان) </label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="فرامرز عباسی ">
            <label class="mx-2" for="">فرامرز عباسی </label>
           </div>
          </div>

          <div class="col-md-3">
          <div class="" style="margin-left: -1rem;">
          <input data-id="1" type="checkbox" id=""
          name="neighborhood_id[]" class="" value="بلوار شاهنامه">
            <label class="mx-2" for="">بلوار شاهنامه</label>
           </div>
          </div>';
      $list .= '</div></div>';

      // ناحیه سه
      $list .= '<div style="padding: 10px;
        background: #efefef;margin-bottom:4px;
        border-radius: 4px;"><h6 class="mb-3">ناحیه 3 </h6><div class="row">';
      $list .= '<div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="گاز">
        <label class="mx-2" for="">گاز</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="راه اهن">
        <label class="mx-2" for="">راه اهن</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="فاطمیه">
        <label class="mx-2" for="">فاطمیه</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="هاشمی نژاد">
        <label class="mx-2" for="">هاشمی نژاد</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="رسالت">
        <label class="mx-2" for="">رسالت</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="دروی">
        <label class="mx-2" for="">دروی</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="طبرسی شمالی">
        <label class="mx-2" for="">طبرسی شمالی</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="سیس اباد">
        <label class="mx-2" for="">سیس اباد</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="بلال">
        <label class="mx-2" for="">بلال</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="خواجه ربیع">
        <label class="mx-2" for="">خواجه ربیع</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="بهمن">
        <label class="mx-2" for="">بهمن</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="قرقی">
        <label class="mx-2" for=""> قرقی </label>
        </div>
        </div>';
      $list .= '</div></div>';

      // ناحیه چهار

      $list .= '<div style="padding: 10px;
        background: #efefef;margin-bottom:4px;
        border-radius: 4px;"><h6 class="mb-3">ناحیه 4 </h6><div class="row">';
      $list .= '<div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="طلاب">
        <label class="mx-2" for="">طلاب</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="گلشور (بهشت )">
        <label class="mx-2" for="">گلشور (بهشت )</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="ایثار">
        <label class="mx-2" for="">ایثار</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="تلگرد">
        <label class="mx-2" for="">تلگرد</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="وحید">
        <label class="mx-2" for="">وحید</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="ابوذر">
        <label class="mx-2" for="">ابوذر</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="پنجتن">
        <label class="mx-2" for="">پنجتن</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="رده">
        <label class="mx-2" for="">رده</label>
        </div>
        </div>

        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="شهید قربانی">
        <label class="mx-2" for="">شهید قربانی</label>
        </div>
        </div>
        <div class="col-md-3">
        <div class="" style="margin-left: -1rem;">
        <input data-id="1" type="checkbox" id=""
        name="neighborhood_id[]" class="" value="پنحتن ال عبا">
        <label class="mx-2" for="">پنحتن ال عبا</label>
        </div>
        </div>';
      $list .= '</div></div>';
    }

    if ($request->city_name == 'نیشابور') {
      $list = '';
    }
    return $list;
  }

  public function getLocations(Request $request)
  {
    $store = Store::where('id', $request->store_id)->first();
    $list = '';
    foreach ($store->store_neighborhoods as $key => $item) {
      $list .= '<i class="fa fa-check"></i><span>
        ' . $item . '
        </span>';
    }

    return $list;
  }


  public function submitEditStore(Request $request)
  {

    
    $store = store::where('id', $request->store_id)->first();
    $personal = Personal::where('personal_mobile', $request->mobile)->first();
    if (is_null($personal)) {
      alert()->error('فروشنده ای با این شماره تماس پیدا نشد', 'خطا')->autoclose(3000);
      return back();
    }

    if ($request->has('owner_profile')) {
      File::deleteDirectory(public_path('uploads/personals/' . $request->mobile));
      $file = 'photo-' . time() . '.' . $request->owner_profile->getClientOriginalExtension();
      $request->owner_profile->move(public_path('uploads/personals/' . $request->mobile), $file);
      $owner_profile = 'personals/' . $request->mobile . '/' . $file;
    } else {
      $owner_profile = $personal->personal_profile;
    }

    if ($request->has('store_picture')) {
      File::deleteDirectory(public_path('uploads/stores/' . $request->store_name));
      $file = 'photo-' . time() . '.' . $request->store_picture->getClientOriginalExtension();
      $request->store_picture->move(public_path('uploads/stores/' . $request->store_name), $file);
      $store_picture =  $request->store_name . '/' . $file;
    } else {
      $store_picture = $store->store_picture;
    }
    Personal::where('personal_mobile', $request->mobile)->update([
      'personal_firstname' => $request->firstname,
      'personal_lastname' => $request->lastname,
      'personal_birthday' => $this->convertDate($request->birth_year)->toDateString(),
      'personal_national_code' => $request->national_num,
      'personal_city' => $request->city,
      'personal_home_phone' => $request->tel_home,
      'personal_office_phone' => $request->tel_work,
      'personal_profile' => $owner_profile
    ]);

    Store::where('id', $request->store_id)->update([
      'store_name' => $request->store_name,
      'store_type' => $request->store_type,
      'store_address' => $request->store_address,
      'store_picture' => $request->store_picture,
      'store_description' => $request->store_descripton,
      'store_city' => $request->store_city,
      'store_main_street' => $request->store_main_street,
      'store_secondary_street' => $request->store_secondary_street,
      'store_pelak' => $request->store_pluck_num,
      'store_picture' => $store_picture,
    ]);

    if (strlen(implode($request->product_name)) == 0) {
      alert()->error('فروشگاه ثبت شد اما محصولی وارد نشده است', 'خطا')->autoclose(3000);
      return back();
    } else {
      $update = 0;
      $create = 0;
      $delete = 0;
      foreach ($request->product_id as $key => $product_id) {

        if ($product_id !== null) {
          if ($request->has('product_delete') && array_key_exists($key, $request->product_delete)) {
            Product::where('id', $product_id)->delete();
            $delete++;
          } else {
            if ($request->product_name[$key] !== null) {
              $product = Product::where('id', $product_id)->first();
              if ($request->has('product_picture') && array_key_exists($key, $request->product_picture)) {
                File::deleteDirectory(public_path('uploads/products/' . $request->product_name[$key]));
                $file = 'photo-' . time() . '.' . $request->product_picture[$key]->getClientOriginalExtension();
                $request->product_picture[$key]->move(public_path('uploads/products/' . $request->product_name[$key]), $file);
                $product_picture = 'products/' . $request->product_name[$key] . '/' . $file;
              } else {

                $product_picture = $product->product_picture;
              }
              if ($request->has('product_status') && array_key_exists($key, $request->product_status)) {
                $status = $request->product_status[$key];
              } else {
                $status = 0;
              }

              Product::where('id', $product_id)->update([
                'product_name' => $request->product_name[$key],
                'product_price' => $request->product_price[$key],
                'product_picture' => $product_picture,
                'product_description' => $request->product_description[$key],
                'product_status' => $status,
              ]);
              $update++;
            }
          }
        } else {
          if ($request->product_name[$key] !== null) {
            if ($request->has('product_picture') && array_key_exists($key, $request->product_picture)) {
              $file = 'photo-' . time() . '.' . $request->product_picture[$key]->getClientOriginalExtension();
              $request->product_picture[$key]->move(public_path('uploads/products/' . $request->product_name[$key]), $file);
              $product_picture = 'products/' . $request->product_name[$key] . '/' . $file;
            } else {
              $product_picture = '';
            }
            Product::create([
              'store_id' => $store->id,
              'product_name' => $request->product_name[$key],
              'product_price' => $request->product_price[$key],
              'product_picture' => $product_picture,
              'product_description' => $request->product_description[$key],
              'product_status' => 1,
            ]);
            $create++;
          }
        }
      }
      alert()->success('فروشگاه با موفقیت افزوده شد و تعداد ' . $create . ' محصول اضافه و ' . $update . ' محصول ویرایش شد', 'عملیات موفق')->persistent('بستن');
      return back();
    }
  }
}
