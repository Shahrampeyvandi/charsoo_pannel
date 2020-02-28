<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\Services\Service;
use App\Models\Cunsomers\Cunsomer;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Services\ServiceCategory;

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
            foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
                $list .= '<option data-parent="'.$item->id.'" value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
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



        $Code = $this->generateRandomString(15);
        Order::create([
            'order_unique_code' =>$Code,
            'service_id' => $request->service_name,
            'order_type' => 'معلق',
            'order_desc' => $request->user_desc,
            'order_show_mobile' => $request->user_mobile,
            'order_city' => $request->user_city,
            'order_firstname_customer' => $request->user_name,
            'order_lastname_customer' => $request->user_family,
            'order_username_customer' => $request->user_mobile,
            'order_broker_name' => 'zitco',
            'order_time_first' => $request->time_one,
            'order_time_second' => $request->time_two,
            'order_date_first' => $this->convertDate($request->date_one),
            'order_date_second' => $this->convertDate($request->date_two),
           
        ]);


            $check_in_customers = Cunsomer::where('customer_mobile',$request->user_mobile)->get();
        if (count($check_in_customers) == 0) {
            Cunsomer::create([
                'customer_firstname' => $request->user_name,
                'customer_lastname' => $request->user_family,
                'customer_mobile' => $request->user_mobile,
                'customer_status' => 1
            ]);
        }
        alert()->success('سفارش با موفقیت ثبت شد', 'عملیات موفق')->autoclose(2000);
        return back();

    }

    public function getServices(Request $request)
    {
        
        $options = '';
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
        foreach ($service->personal as $key => $personal) {
            $tr .=  '
            <input type="hidden" value="'.$request->order_id.'" name="order_id"   />
            <tr>
            <td>
              <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
              <input data-id="'.$personal->id.'" type="checkbox" id="'.$key.'" name="personal_id[]" class="custom-control-input" value="1">
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

    public function choiseChosenPersonal(Request $request)
    {
        $order =  Order::where('id',$request->order_id)->first();
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
        foreach ($service->personal()->where('personal_chosen_status',1)->get() as $key => $personal) {
            $tr .=  '
            <input type="hidden" value="'.$request->order_id.'" name="order_id"   />
            <tr>
            <td>
              <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
              <input data-id="'.$personal->id.'" type="checkbox" id="chosen_'.$key.'" name="personal_id[]" class="custom-control-input" value="1">
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
            Order::where('id',$order)->delete();
        }
        return response()->json(['success' => true]);
    }
}
