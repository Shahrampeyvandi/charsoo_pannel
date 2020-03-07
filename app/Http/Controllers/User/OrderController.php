<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Orders\Order;
use App\Models\Acounting\UserAcounts;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\Services\Service;
use App\Models\Cunsomers\Cunsomer;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Personals\Personal;
use App\Models\Services\ServiceCategory;
use Carbon\Carbon;

class OrderController extends Controller
{

   
    public function OrderList()
    {

      if (auth()->user()->hasRole('admin_panel')) {
        $orders = Order::latest()->get();
        $services = Service::all();
        $category_parent_list = ServiceCategory::where('category_parent',0)->get();
        $count = ServiceCategory::where('category_parent',0)->count();
         $list ='<option data-parent="0" value="0" class="level-1">بدون دسته بندی</option>';
        foreach ($category_parent_list as $key => $item) {
            
            $list .= '<option data-id="'.$item->id.'" value="'.$item->id.'" class="level-1">'.$item->category_title.' 
             '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
            </option>';
          if (ServiceCategory::where('category_parent',$item->id)->count()) {
              $count += ServiceCategory::where('category_parent',$item->id)->count();
             foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key1 => $itemlevel1) {
                 $list .= '<option data-parent="'.$item->id.'" value="'.$itemlevel1->id.'" class="level-2">'.$itemlevel1->category_title.'
                 '.(count(ServiceCategory::where('category_parent',$itemlevel1->id)->get()) ? '&#xf104;  ' : '' ).'
                 </option>';
                 
                 
              if (ServiceCategory::where('category_parent',$itemlevel1->id)->count()) {
                 $count += ServiceCategory::where('category_parent',$itemlevel1->id)->count();
                 foreach (ServiceCategory::where('category_parent',$itemlevel1->id)->get() as $key2 => $itemlevel2) {
                     $list .= '<option data-parent="'.$itemlevel1->id.'" value="'.$itemlevel2->id.'" class="level-3">'.$itemlevel2->category_title.'
                     '.(count(ServiceCategory::where('category_parent',$itemlevel2->id)->get()) ? '&#xf104;  ' : '' ).'
                     </option>';
                    
                    
                    if (ServiceCategory::where('category_parent',$itemlevel2->id)->count()) {
                     $count += ServiceCategory::where('category_parent',$itemlevel2->id)->count();
                     foreach (ServiceCategory::where('category_parent',$itemlevel2->id)->get() as $key3 => $itemlevel3) {
                         $list .= '<option data-parent="'.$itemlevel2->id.'" value="'.$itemlevel3->id.'" class="level-4">'.$itemlevel3->category_title.'
                         '.(count(ServiceCategory::where('category_parent',$itemlevel3->id)->get()) ? '&#xf104;  ' : '' ).'
                         </option>';
                     
                         if (ServiceCategory::where('category_parent',$itemlevel3->id)->count()) {
                             $count += ServiceCategory::where('category_parent',$itemlevel3->id)->count();
                             foreach (ServiceCategory::where('category_parent',$itemlevel3->id)->get() as $key4 => $itemlevel4) {
                                 $list .= '<option data-parent="'.$itemlevel3->id.'" value="'.$itemlevel4->id.'" class="level-4">'.$itemlevel4->category_title.'
                                 
                                 </option>';
                             
                             }
                            }
                     
                     }
                    }
                 }
              }
             
              }
          }
        }
      }else{
        $category_parent_list = ServiceCategory::where('category_parent',0)->get();
        $count = ServiceCategory::where('category_parent',0)->count();
         $list ='<option data-parent="0" value="0" class="level-1">بدون دسته بندی</option>';
        foreach ($category_parent_list as $key => $item) {
            $list .= '<option data-id="'.$item->id.'" value="'.$item->id.'" class="level-1">'.$item->category_title.' 
             '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
            </option>';
            foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
                $list .= '<option data-parent="'.$item->id.'" value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
            }
        }
        if (auth()->user()->roles->first()->broker !== null) {
            $services = auth()->user()->services;
            $service_array = auth()->user()->services->pluck('id')->toArray();
            $orders = Order::whereIn('service_id',$service_array)->get();
        }
        if (auth()->user()->roles->first()->sub_broker !== null) {
            $role_id = auth()->user()->roles->first()->sub_broker;
            $user =  User::whereHas('roles', function ($q) use ($role_id) {
                $q->where('id',$role_id);
            })->first();
            $services = $user->services;
            $service_array = $user->services->pluck('id')->toArray();
            $orders = Order::whereIn('service_id',$service_array)->get();
        }

      }
        return view('User.Orders.OrderList',compact(['orders','services','list','count']));
    }

    public function SubmitOrder(Request $request)
    {
       
       
        if (strlen(implode($request->service_name)) == 0) {
            alert()->error('خدمت مورد نظر را انتخاب نمایید', 'خطا')->autoclose(2000);
        return back();
        }
   foreach ($request->category as $key => $item) {
 
    $order = Order::create([
        'service_id' => $request->service_name[$key],
        'order_type' => 'معلق',
        'order_desc' => $request->user_desc,
        'order_show_mobile' => $request->user_mobile,
        'order_city' => $request->user_city[$key],
        'order_firstname_customer' => $request->user_name,
        'order_lastname_customer' => $request->user_family,
        'order_username_customer' => $request->user_mobile,
        'order_broker_name' => 'zitco',
        'order_time_first' => $request->time_one[$key],
        'order_time_second' => $request->time_two[$key],
        'order_date_first' => $request->date_one[$key] !== null ? $this->convertDate($request->date_one[$key]): '' ,
        'order_date_second' => $request->date_two[$key] !== null ?  $this->convertDate($request->date_two[$key]) : '' ,
    ]);

    $mobile = $request->user_mobile;
           $date = Carbon::parse($order->order_date_first)->timestamp;
           $Code = $this->generateRandomString(15,$mobile,$date);

           $order->update([
            'order_unique_code' => $Code
           ]);
   }

            

            $check_in_customers = Cunsomer::where('customer_mobile',$request->user_mobile)->get();
        if (count($check_in_customers) == 0) {
           $customer= Cunsomer::create([
                'customer_firstname' => $request->user_name,
                'customer_lastname' => $request->user_family,
                'customer_mobile' => $request->user_mobile,
                'customer_status' => 1
            ]);



           


           
           $acountcharge = new UserAcounts();
           $acountcharge->user = 'مشتری';
           $acountcharge->type = 'شارژ';
           $acountcharge->cash = 0;
           $acountcharge->cunsomer_id = $customer->id;
           $acountcharge->save();
           

        }else{
          $mobile = $request->user_mobile;
          $mobile = $request->user_mobile;
          $date = Carbon::parse($order->order_date_first)->timestamp;
          $Code = $this->generateRandomString(15,$mobile,$date);

          $order->update([
           'order_unique_code' => $Code
          ]);
        }
        alert()->success('سفارش با موفقیت ثبت شد', 'عملیات موفق')->autoclose(2000);
        return back();

    }

    public function getServices(Request $request)
    {
        
        $options = '<option value="">باز کردن فهرست انتخاب</option>';
        $services = Service::where('service_category_id',$request->data)->get();
        foreach ($services as $key => $service) {
            $options .= '<option value="'.$service->id.'">'.$service->service_title.'</option>';
        }

        return response($options,200);
    }

    public function checkCustomer(Request $request)
    {
       $customer = Cunsomer::where('customer_mobile',$request->data)->first();
        if ($customer !== null) {

            return response()->json(['customer' => $customer],200);
        }
        return 'false';
    }

    public function getPersonals(Request $request)
    {
        
        
        $service = Service::where('id',$request->service_id)->first();
        
        $tr = '';
        
        foreach ($service->personal->where('personal_status',1) as $key => $personal) {
            
            $tr .=  '
            <input type="hidden" value="'.$request->order_id.'" name="order_id"   />
            <input type="hidden" value="'.csrf_token().'" name="_token"   />
            <tr>
            <td>
              <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
              <input data-id="'.$personal->id.'" type="checkbox" id="'.$key.'" name="personal_id[]" class="custom-control-input" 
              value="'.$personal->id.'"
              '.(count($personal->order->where('id',$request->order_id))  ? 'checked=""' : '').'
              >
                <label class="custom-control-label" for="'.$key.'"></label>
              </div>
            </td>
            <td> '.($key+1).' </td>
            <td>'.$personal->personal_firstname.'</td>
            <td>'.$personal->personal_lastname.'</td>
            <td>'.$personal->personal_mobile.'</td>
            '.($personal->personal_status == 1 ?
            '<td class="text-success">
                <i class="fa fa-check"></i>
            </td>'
            :
            '<td class="text-danger">
                <i class="fa fa-close"></i>
            </td>'
            ).'
            </tr>';

        }

        return $tr;
    }

    public function choisePersonal(Request $request)
    {
        

  
       $order =  Order::where('id',$request->order_id)->first();
       $order->personals()->detach();
       foreach ($request->personal_id as $key => $personal_id) {
      
            $order->personals()->attach($personal_id);
            $sms_status = Service::where('id',$order->service_id)->first()->sms_status;
            
            if ($sms_status !== null) {
                $mobile = Personal::where('id',$personal_id)->first()->personal_mobile;
                $this->sendSMS($mobile);
            
        }

        Order::where('id',$request->order_id)->update([
            'order_type' => 'انجام نشده'
        ]);

       
       }
       alert()->success('خدمت رسان(ها) با موفقیت انتخاب شد.', 'عملیات موفق')->autoclose(2000);
       return back();
        
    }

    public function sendSMS($mobile)
    {
        
        $apikey = env('API_KEY');
        $receptor = $mobile;
        //$token = 'خدمات.محصلی.بضروری';
        $token = $mobile;
        $template = 'referredorder';
        $api = new \Kavenegar\KavenegarApi($apikey);
        try {
            $api->VerifyLookup($receptor, $token, null, null, $template);
        } catch (\Kavenegar\Exceptions\ApiException $e) {

            //return response()->json(['message' => 'مشکل پنل پیامکی پیش آمده است =>' . $e->errorMessage()], 400);
            return response()->json(['code'=> $token ,'error' => 'مشکل پنل پیامکی پیش آمده است =>' . $e->errorMessage()
            ],500);

        } catch (\Kavenegar\Exceptions\HttpException $e) {

            return response()->json(['code'=> $token,'error' => 'مشکل اتصال پیش امده است =>' . $e->errorMessage()],500);

        }
    }

    public function choiseChosenPersonal(Request $request)
    {
        $order =  Order::where('id',$request->order_id)->first();
        $order->personals()->detach();
       foreach ($request->personal_id as $key => $personal_id) {
        if (DB::table('order_personal')->where([
            'order_id' => $request->order_id,
            'personal_id' => $request->personal_id
        ])->count()) {
            continue;
        }else{
            $order->personals()->attach($personal_id);
        }
       
       }
       alert()->success('خدمت رسان(ها) با موفقیت انتخاب شد.', 'عملیات موفق')->autoclose(2000);
       return back();
    }

    public function getDetailOrder(Request $request)
    {
        
      
       $order = Order::where('id',$request->order_id)->first();
       
        $list = '<span>نام: </span>
        <span>'.$order->order_firstname_customer.'</span>
        <br><span>نام خانوادگی: </span>
        <span>'.$order->order_lastname_customer.'</span>
        <br><span>شماره همراه مشتری: </span>
        <span>'.$order->order_username_customer.'</span>
        <br><span>خدمت درخواستی: </span>
        <span>'.$order->relatedService->service_title.'</span>
        <br><span>توضیحات: </span>
        <span>'.$order->order_desc.'</span>
        <br><span>تاریخ و زمان اول درخواستی:</span>
        <span>'.\Morilog\Jalali\Jalalian::forge($order->order_date_first)->format('%d %B %Y') .' ساعت '. $order->order_time_first.'</span>
        <br><span>تاریخ و زمان دوم درخواستی: </span>
        <span>'.\Morilog\Jalali\Jalalian::forge($order->order_date_second)->format('%d %B %Y') .' ساعت '. $order->order_time_second.'</span>
        <br><span>قیمت قطعه: </span>
        <span>ناتمام</span>
        <br><span>قیمت خدمت: </span>
        <span>'.($order->relatedService->service_price !== null ? $order->relatedService->service_price : 'وارد نشده').'</span>
        <br><span>عکس های فاکتور: </span>
        <br>
        <div class="row">';
        foreach ($order->orderImages as $key => $image) {
           $list .= '<div class="col-md-6 twxt-center">
            <img class="img-fluid" src="'.asset('Pannel/img/profile.png').'" />
            </div>';
        }
        
       
        $list .='</div>
        ';
        return $list;
    }

    public function getChosenPersonal(Request $request)
    {
     
        $service = Service::where('id',$request->service_id)->first();
    

        $tr = '';
        foreach ($service->personal()->where('personal_chosen_status',1)->where('personal_status',1)->get() as $key => $personal) {
            $tr .=  '
            <input type="hidden" value="'.$request->order_id.'" name="order_id"   />
            <input type="hidden" value="'.csrf_token().'" name="_token"   />
            <tr>
            <td>
              <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
              <input data-id="'.$personal->id.'" type="checkbox" id="chosen_'.$key.'"
              '.(count($personal->order->where('id',$request->order_id))  ? 'checked=""' : '').'
              name="personal_id[]" class="custom-control-input" value="'.$personal->id.'">
                <label class="custom-control-label" for="chosen_'.$key.'"></label>
              </div>
            </td>
            <td> '.($key+1).' </td>
            <td>'.$personal->personal_firstname.'</td>
            <td>'.$personal->personal_lastname.'</td>
            <td>'.$personal->personal_mobile.'</td>
            '.($personal->personal_status == 1 ?
            '<td class="text-success">
                <i class="fa fa-check"></i>
            </td>'
            :
            '<td class="text-danger">
                <i class="fa fa-close"></i>
            </td>'
            ).'
            </tr>';

        }

        return $tr;
    }

    public function deleteOrder(Request $request)
    {
        foreach ($request->array as $order) {
        
            Order::find($order)->personals()->detach();
            Order::where('id',$order)->delete();
        }
        return response()->json(['success' => true]);
    }
}
