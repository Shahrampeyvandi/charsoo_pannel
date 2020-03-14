<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City\City;
use App\Models\Personals\Personal;
use App\Models\Store\Store;

class StoreController extends Controller
{
    public function index()
    {
        return view('User.Stores.StoresList');
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
            $store_picture = 'personals/' . $request->store_name . '/' . $file;
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
                'store_picture' => $store_picture,
        ]);
     
    foreach ($request->product_name as $key => $item) {
        if (array_key_exists($key,$request->product_picture)) {
            $file = 'photo' . '.' . $request->product_picture[$key]->getClientOriginalExtension();
            $request->product_picture[$key]->move(public_path('uploads/products/' . $item), $file);
            $product_picture = 'products/' . $item . '/' . $file;
        }else{
           $product_picture ='';
        }
        $store->products()->create([
            'product_name' => $item,
            'product_price' => $request->product_price[$key],
            'product_picture' => $product_picture,
            'product_description' => $request->product_description[$key],
            'product_status' => $request->product_status[$key],
        ]);
    }


    alert()->success('فروشگاه با موفقیت افزوده شد', 'عملیات موفق')->autoclose(2000);
        return back();
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
}
