<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Services\ServiceCategory;
use App\Models\User;

class ServiceController extends Controller
{
    public function ServiceList()
    {
        
        $brokers ='';
        foreach (User::all() as $key => $user) {
            if (count($user->roles->where('broker',1))) {
                $brokers .= '<option value="'.$user->id.'">'.$user->user_username.'</option>';
            }
        }
       $category_parent_list = ServiceCategory::where('category_parent',0)->get();
       $count = ServiceCategory::where('category_parent',0)->count();
        $list ='';
       foreach ($category_parent_list as $key => $item) {
           
           $list .= '<option data-id="'.$item->id.'" value="'.$item->id.'" class="level-1">'.$item->category_title.' 
            '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
           </option>';
          
           foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
               $list .= '<option data-parent="'.$item->id.'" value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
           }
       }

      $services = Service::latest()->get();
        return view('User.Services.ServiceList',compact(['list','count','services','brokers']));
    }

    public function SubmitService(Request $request)
    {
      
        if ($request->has('service_icon')) {
        
            $icon = $request->title . '.' . $request->service_icon->getClientOriginalExtension();
            $request->service_icon->move(public_path('uploads/service_icons/'.$request->title), $icon);
        }else{
            $icon = '';
        }
        if ($request->has('pic_1')){
            $pic1 = $request->title . '.' . $request->pic_1->getClientOriginalExtension();
            $request->pic_1->move(public_path('uploads/service_pics/'.$request->title.'/pic1'), $pic1);
        }else{
            $pic1 = '';
        }

        if ($request->has('pic_2')){
            $pic2 = $request->title . '.' . $request->pic_2->getClientOriginalExtension();
            $request->pic_2->move(public_path('uploads/service_pics/'.$request->title.'/pic2'), $pic2);
        }else{
            $pic2 = '';
        }


       $service = Service::create([
            'service_title' => $request->title,
            'service_category_id' => $request->service_category !== null ? $request->service_category : 0,
            'service_percentage' => $request->service_percentage,
            'service_offered_price' => $request->service_offered_price,
            'service_desc' => $request->service_desc,
            'service_price' => $request->service_price,
            'service_alerts' => $request->service_alerts,
            'service_city' => $request->service_city,
            'service_type_send' => $request->type_send,
            'price_type' => $request->price_type,
            'service_offered_status' => $request->service_offered_status,
            'service_special_category' => $request->service_special_category,
            'service_icon' => $icon,
            'service_pic_first' => $pic1,
            'service_pic_second' => $pic2
        ]);

        if ($request->has('service_role')) {
            
            $service->user()->attach($request->service_role);
        }

        

        alert()->success(' خدمت با موفقیت ثبت شد', 'عملیات موفق')->autoclose(2000);
        return back();
    }

    public function DeleteService(Request $request)
    {
        foreach ($request->array as $service) {
            Service::where('id',$service)->first()->personal()->detach();
            Service::where('id',$service)->delete();
        }
        return 'success';
    }

    public function getData(Request $request)
    {
        
        $brokers ='';
        foreach (User::whereHas('roles',function($q){
            $q->where('broker',1);
        })->get() as $key => $user) {
            if (count($user->roles->where('broker',1))) {
                $brokers .= '<option value="'.$user->id.'">'.$user->user_username.'</option>';
            }
        }
        
        $service = Service::where('id',$request->category_id)->first();
        $csrf = csrf_token();
        $category_parent_list = ServiceCategory::where('category_parent',0)->get();
        $count = ServiceCategory::where('category_parent',0)->count();


        $option ='';
        foreach ($category_parent_list as $key => $item) {
            $option .= '<option data-id="'.$item->id.'"
            '.($service->service_category_id == $item->id ? 'selected=""' : '' ).'
            value="'.$item->id.'" class="level-1">'.$item->category_title.' 
             '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
            </option>';
            foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
                $option .= '<option data-parent="'.$item->id.'"
                '.($service->service_category_id == $subitem->id ? 'selected=""' : '' ).'
                value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
            }
        }
$list = '<div class="modal-body">
<div id="wizard2">
<form id="example-advanced-form1" method="post" action="'.route('Service.Edit.Submit').'" enctype="multipart/form-data">
<input type="hidden" name="_token" value="'.$csrf.'">
<input type="hidden" name="service_id" value="'.$service->id.'">
    <h3>خدمت</h3>
    <section>
        
            <div class="form-group wd-xs-300">
                <label>عنوان </label>
                <input type="text" id="title" name="title"
                value="'.$service->service_title.'"
                class="form-control" placeholder="نام" >
                
            </div><!-- form-group -->
            
                <div class="form-group wd-xs-300">
                    <label for="recipient-name" class="col-form-label">دسته:</label>
                    <select '.( $count > 1 ?
                    'size="'.($count+1).'"' :  'size="3"'
                 ). ' class="form-control" name="service_category" id="service_category">
                     '.$option.'
                    </select>
                                      
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label>درصد پورسانت </label>
                    <input type="number" name="service_percentage" 
                    value="'.$service->service_percentage.'"
                    id="service_percentage" class="form-control" placeholder="">
                    <div class="valid-feedback">
                        صحیح است!
                    </div>
                </div><!-- form-group -->
                <div class="form-group col-md-6">
                    <label>قیمت ارسال پیشنهاد (تومان) </label>
                    <input type="number" 
                    value="'.$service->service_offered_price.'"
                    name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
                    <div class="valid-feedback">
                        صحیح است!
                    </div>
                </div><!-- form-group -->
            </div>
            <div class="form-group wd-xs-300">
                <label>توضیحات </label>
                <textarea type="text" name="service_desc" class="form-control" placeholder="">
                '.$service->service_desc.'
                </textarea>
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
            <div class="form-group wd-xs-300">
                <label>تذکرات </label>
                <input type="text"
                value="'.$service->service_alerts.'"
                name="service_alerts" class="form-control" placeholder="" >
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->

            <p>شهر  </p>
            <div class="form-group wd-xs-300">
                
                <div class="custom-control custom-radio custom-control-inline">
                    <input required type="radio" id="customRadioInline1" name="service_city"
                     class="custom-control-input checkbox__" value="مشهد" 
                     '.($service->service_city == 'مشهد' ? 'checked=""' : '').'
                     >
                    <label class="custom-control-label " for="customRadioInline1">مشهد</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input required type="radio" id="customRadioInline2" name="service_city"
                     class="custom-control-input checkbox__" value="نیشابور"
                     '.($service->service_city == 'نیشابور' ? 'checked=""' : '').'

                     >
                    <label class="custom-control-label" for="customRadioInline2">نیشابور</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input required type="radio" id="customRadioInline3" name="service_city"
                     class="custom-control-input checkbox__" value="سبزوار"
                     '.($service->service_city == 'سبزوار' ? 'checked=""' : '').'
                     >
                    <label class="custom-control-label" for="customRadioInline3">سبزوار</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input required type="radio" id="customRadioInline4" name="service_city"
                     class="custom-control-input checkbox__" value="فریمان"
                     '.($service->service_city == 'فریمان' ? 'checked=""' : '').'
                     >
                    <label class="custom-control-label" for="customRadioInline4">فریمان</label>
                </div>
            </div> 
            <div class="form-group wd-xs-300">
                <label for="recipient-name" class="col-form-label">نوع ارجاع:</label>
                <select required name="type_send"   class="form-control" id="exampleFormControlSelect2">
                    <option '.($service->service_type_send == 'ارجاع اتوماتیک' ? 'selected=""' : '').' value="ارجاع اتوماتیک">ارجاع اتوماتیک</option>
                    <option '.($service->service_type_send == 'ارجاع دستی' ? 'selected=""' : '').' value="ارجاع دستی">ارجاع دستی</option>  
                    <option '.($service->service_type_send == 'ارجاع منتخب' ? 'selected=""' : '').' value="ارجاع منتخب">ارجاع منتخب</option>  
                    <option '.($service->service_type_send == 'ارجاع به کمترین فاصله' ? 'selected=""' : '').' value="ارجاع به کمترین فاصله">ارجاع به کمترین فاصله</option>  
                </select>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
            <label for="recipient-name" class="col-form-label">نام کارگزاری: </label>
            <select required name="service_role"   class="form-control" id="exampleFormControlSelect2">
                '. $brokers .'
                  
            </select>
            </div>
                <div class="form-group col-md-6">
                    <label>تغییر ایکون </label>
                    <input type="file" id="service_icon" name="service_icon" class="form-control" placeholder="" >
                    <div class="valid-feedback">
                        صحیح است!
                    </div>
                </div><!-- form-group -->
            </div>
    </section>
    <h3> قیمت</h3>
    <section>
        <div class="form-group wd-xs-300">
            <label for="recipient-name" class="col-form-label">نوع :</label>
            <select  name="price_type"   class="form-control" id="price_type">
                <option '.($service->price_type == 'توافقی' ? 'selected=""' : '').'  value="توافقی"> توافقی</option>
                <option '.($service->price_type == 'رقمی' ? 'selected=""' : '').' value="رقمی"> رقمی</option>
                <option '.($service->price_type == 'طبق لیست' ? 'selected=""' : '').' value="طبق لیست"> طبق لیست</option>
             </select>
        </div><!-- form-group -->
        <div class="form-group wd-xs-300" id="price-wrapper" 
        '.($service->price_type == 'رقمی' ? 'style="display:block;"' : 'style="display:none;"').'
        >
            <label class="form-control-label"> قیمت (به تومان):</label>
            <input id="service_price" 
            value="'.$service->service_price.'"
            class="form-control text-right" name="service_price" placeholder="0" type="number"  dir="rtl">
            <div class="valid-feedback">
                صحیح است!
            </div>
        </div><!-- form-group -->
            <div class="form-group wd-xs-300">
                <label class="form-control-label"> تصویر 1: </label>
                <input id="email" class="form-control text-right" name="pic_1"  type="file"  dir="rtl">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
            <div class="form-group wd-xs-300">
                <label class="form-control-label"> تصویر 2: </label>
                <input id="email" class="form-control text-right" name="pic_2"  type="file"  dir="rtl">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
    </section>
    <h3>انتخاب سوالات از بانک</h3>
    <section>
    </section>
    <h3>پیشنهاد ویژه</h3>
    <section>
        <div class="form-group wd-xs-300">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="service_offered_status" id="customCheck" checked>
                <label class="custom-control-label" for="customCheck">به عنوان پیشنهاد ویژه در نظر گرفته شود</label>
            </div>     
            
        </div>   
        <div class="form-group wd-xs-300">
            <label for="recipient-name" class="col-form-label">این سرویس در چه خدماتی به عنوان ویژه در نظر گرفته شود: </label>
            <select  name="service_special_category"   class="form-control" id="exampleFormControlSelect2">
                <option value="ارجاع اتوماتیک">ارجاع اتوماتیک</option>
                <option value="ارجاع دستی">ارجاع دستی</option>  
                <option value="ارجاع منتخب">ارجاع منتخب</option>  
                <option value="ارجاع به کمترین فاصله">ارجاع به کمترین فاصله</option>  
            </select>
        </div> 
    </section>
    </form>
</div>
</div>';

return $list;

}

    public function SubmitServiceEdit(Request $request)
    {
      
       $service = Service::where('id',$request->service_id)->first();
        if ($request->has('service_icon')) {
            
            File::deleteDirectory(public_path('uploads/service_icons/'.$service->service_title));
            $icon = $request->title . '.' . $request->service_icon->getClientOriginalExtension();
            $request->service_icon->move(public_path('uploads/service_icons/'.$request->title), $icon);
        }else{
            $icon = $service->service_icon;
        }


        if ($request->has('pic_1')) {
            
            File::deleteDirectory(public_path('uploads/service_pics/'.$request->title.'/pic1'));
            $pic1 = $request->title . '.' . $request->pic_1->getClientOriginalExtension();
            $request->pic_1->move(public_path('uploads/service_pics/'.$request->title.'/pic1'), $pic1);
        }else{
            $pic1 = $service->service_pic_first;
        }


        if ($request->has('pic_2')) {
            
            File::deleteDirectory(public_path('uploads/service_pics/'.$request->title.'/pic2'));
            $pic2 = $request->title . '.' . $request->pic_1->getClientOriginalExtension();
            $request->pic_1->move(public_path('uploads/service_pics/'.$request->title.'/pic2'), $pic2);
        }else{
            $pic2 = $service->service_pic_second;
        }


           
           
            $array =[
                'service_title' => $request->title,
                'service_category_id' => $request->service_category,
                'service_percentage' => $request->service_percentage,
                'service_offered_price' => $request->service_offered_price,
                'service_desc' => $request->service_desc,
                'service_price' => $request->service_price,
                'service_alerts' => $request->service_alerts,
                'service_city' => $request->service_city,
                'service_type_send' => $request->type_send,
                'price_type' => $request->price_type,
                'service_offered_status' => $request->service_offered_status,
                'service_special_category' => $request->service_special_category,
                'service_icon' => $icon,
                'service_pic_first' => $pic1,
                'service_pic_second' => $pic2
                    ];
        
        Service::where('id',$request->service_id)->update($array);
        if ($request->has('service_role')) {
            $service->user()->attach($request->service_role);
        }
        alert()->success('دسته بندی با موفقیت ویرایش شد', 'عملیات موفق')->autoclose(2000);
        return back();
    }

    public function ServiceOrderBy(Request $request)
    {
        
        
        if ($request->data == 'title') {
            $services = Service::OrderBy('service_title','ASC')->get();
          }
          if ($request->data == 'persent') {
            $services = Service::OrderBy('service_percentage','DESC')->get();
          }
          if ($request->data == 'broker_name') {
            $services = Service::OrderBy('service_broker_name','ASC')->get();
          }
          
          $tbody ='';
          foreach ($services as $key => $service) {
            $tbody .= '
            <tr>
            <td>
              <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
              <input data-id="'.$service->id.'" type="checkbox" id="'.$key.'" name="customCheckboxInline1" class="custom-control-input" value="1">
                <label class="custom-control-label" for="'.$key.'"></label>
              </div>
            </td>
            <td> '.($key+1).' </td>
            <td>'.$service->service_title.'</td>
            <td>'.$service->service_broker_name.'</td>
            <td>'.($service->service_desc !== null ? $service->service_desc : '--').'</td>
            <td>'.$service->relationCategory->category_title.'</td>
            <td>'.$service->service_rol.'</td>
            <td>--</td>
            <td>'.$service->service_percentage . '%</td>
            <td>--</td>
            <td>'.$service->price_type.'</td>
            <td>'.$service->service_type_send.'</td>
            <td>'. ($service->service_icon !== '' ? 
            '<img width="75px" class="img-fluid " src="'.asset("uploads/service_icons/$service->service_title/$service->service_icon").'" />'
        :
      ' ندارد'
        ).'</td>
            
          </tr>
    
            ';
          }
         
          return $tbody;
    }

    public function FilterServices(Request $request)
    {
      
        
      if($request->type_send == 'عنوان'){
        $services =  Service::where('service_title', 'like', '%' . $request->word. '%')
        ->get();
      }  
      if($request->type_send == 'نوع'){
        $services =  Service::where('user_firstname', 'like', '%' . $request->word. '%')
        ->get();
      }  
      if($request->type_send == 'نقش'){
        $services =  Service::where('user_firstname', 'like', '%' . $request->word. '%')
        ->get();
      }  
    //   if($request->type_send == 'دسته بندی خدمات'){
    //     $services =  Service::where('service_category_id',$request->word)
    //     ->get();
    //   }  
      if($request->type_send == 'نوع قیمت'){
        $services =  Service::where('price_type',$request->word)
        ->get();
      }  
      if($request->type_send == 'نوع ارجاع'){
        $services =  Service::where('service_type_send',$request->word)
        ->get();
      } 

      $category_parent_list = ServiceCategory::where('category_parent',0)->get();
      $count = ServiceCategory::where('category_parent',0)->count();
       $list ='';
      foreach ($category_parent_list as $key => $item) {
          
          $list .= '<option data-id="'.$item->id.'" value="'.$item->id.'" class="level-1">'.$item->category_title.' 
           '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
          </option>';
         
          foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
              $list .= '<option data-parent="'.$item->id.'" value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
          }
      }

    
       return view('User.Services.ServiceList',compact(['list','count','services']));

    }
}
