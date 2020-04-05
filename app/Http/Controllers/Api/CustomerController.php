<?php

namespace App\Http\Controllers\Api;

use App\App\Models\Customers\CustomerAddress;
use App\Http\Controllers\Controller;
use App\Models\Acounting\UserAcounts;
use App\Models\Services\ServiceCategory;
use App\Models\Services\Service;
use App\Models\User;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Personals\Personal;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{

    public function verify(Request $request)
    {

        $cunsomer = Cunsomer::where('customer_mobile', $request->mobile)->first();
        $check_cunsomer = Cunsomer::where([
            'customer_mobile' => $request->mobile,
        ])->count();
        if ($check_cunsomer) {
            Cunsomer::where('customer_mobile',  $request->mobile)
                ->update([
                    'firebase_token' => $request->fcmtoken,
                ]);

            $token = JWTAuth::fromUser($cunsomer);
            return response()->json([
                'code' => $token,
                'error' => '',
            ], 200);
        } else {
            return response()->json([
                'code' => '',
                'error' => '',
            ], 200);
        }
    }


    public function register(Request $request)
    {

        $cunsomer = Cunsomer::create([
            'customer_firstname' => $request->c_firstname,
            'customer_lastname' => $request->c_lastname,
            'customer_mobile' => $request->c_mobile,
            'firebase_token' => $request->fcmtoken,
            'customer_city' => $request->c_city

        ]);

        $acountcharge = new UserAcounts();
        $acountcharge->user = 'مشتری';
        $acountcharge->type = 'شارژ';
        $acountcharge->cash = 0;
        $acountcharge->cunsomer_id = $cunsomer->id;
        $acountcharge->save();

        $token = JWTAuth::fromUser($cunsomer);
        return response()->json([
            'code' => $token,
            'error' => '',
        ], 200);
    }

      public function getCustomer(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();

        $response['pic']=$customer->customer_profile;
        $response['name']=$customer->customer_firstname;
        $response['lname']=$customer->customer_lastname;
        $response['phone']=$customer->customer_mobile;
        $response['codemelli']=$customer->customer_national_code;

        $response['charge']=$customer->useracounts[0]->cash;
        $response['hafte']='1';
        $response['orders']='2';

        return response()->json(
            $response,
            200
        );
    }

    public function updateProfile(Request $request)
    {

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();
        //if ($request->hasFile('customer_profile')) {
        if ($customer->customer_profile) {
            File::delete(public_path() . '/uploads/customers/' . $customer->customer_mobile . '/' . $customer->customer_profile);
        }

        $customer_img = 'photo' . time() . '.' . $request->customer_profile->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/customers/' . $customer->customer_mobile);
        $request->customer_profile->move($destinationPath, $customer_img);
        $customer_profile = 'customers/'.$customer->customer_mobile . '/' . $customer_img;

        Cunsomer::where('customer_mobile', $mobile)
            ->update([
                'customer_profile' => $customer_profile
            ]);

        return response()->json(
            $customer->fresh(),
            200
        );
    }


    public function updateCustomerData(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');

        Cunsomer::where('customer_mobile', $mobile)
            ->update([
                'customer_firstname' => $request->name,
                'customer_lastname' => $request->lname,
                'customer_national_code' => $request->codemelli,
            ]);
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();
        return response()->json([
            'data' => [
                'customer' => $customer,
            ],
        ], 200);
    }


    public function getHomePageDetail(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();

        $settings = DB::table('setting')->get();
        $setting=$settings[0];



        return response()->json([
        'name'=>$customer->customer_firstname.' '.$customer->customer_lastname,
        'mobile'=>$customer->customer_mobile,
        'charge'=>$customer->useracounts[0]->cash,
        'city'=>$customer->customer_city,
        'profilepic'=>$customer->customer_profile,
        'shomareposhtibani'=>$setting->shomareposhtibani,
        'telegramposhtibani'=>$setting->telegramposhtibani,
        'linkappworker'=>$setting->linkappservicer,
        'linklaw'=>$setting->linklaw,
        'linkfaq'=>$setting->linkfaq,
        ],
            200
        );
    }

    public function getAllOrders(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();
        $customer_model = new Cunsomer();
        $orders =  $customer_model->getOrders($customer->id);

        foreach($orders as $key=>$order){

            $service = Service::where('id', $order->service_id)->first()->service_title;
            $order['service_name'] = $service;

        }
        

        return response()->json([
            'data' => $orders,
        ],200);


    }

    public function getOrder(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();
        $code = $request->code;
        $customer_model = new Cunsomer();
        $order =  $customer_model->getOrder($customer->id,$code);
        $service = $customer_model->getOrderService($customer->id,$code);
        $order_personal = $order->personals->first();
        if (!is_null($order_personal)) {
            $personal_array = [
            'personal_firstname' =>  $order_personal->personal_firstname,
            'personal_lastname' => $order_personal->personal_lastname,
            'personal_last_diploma' => $order_personal->personal_last_diploma,
            'personal_mobile' => $order_personal->personal_mobile,
            ];
        }
        else{
            $personal_array = [
            'personal_firstname' => '',
            'personal_lastname' => '',
            'personal_last_diploma' => '',
            'personal_mobile' => '',
            ];
        }

        $order_detail = $order->orderDetail;
        if (!is_null($order_personal)) {
            $details_array = [
                'order_recived_price' => $order_detail->order_recived_price,
                'order_pieces_cast' => $order_detail->order_pieces_cast
            ];
        }
        else{
            $details_array = [
                'order_recived_price' =>'',
                'order_pieces_cast' => ''
            ];
        }
        if(!is_null($service)){
            $service_name = $service->service_title; 
        }else{
            $service_name = 'ندارد';
        }

        $array = [
            'service_name' => $service_name,
            'order_unique_code' => $order->order_unique_code,
            'order_desc' => $order->order_desc,
            'order_time_first' => $order->order_time_first,
            'order_time_second' => $order->order_time_second,
            'order_date_first' => $order->order_date_first,
            'order_date_second' => $order->order_date_second,
            'order_type' => $order->order_type,
            'order_address'=>$order->order_address,

            
        ];

        
        return response()->json(array_merge($array,$personal_array,$details_array),200);
        
        }


        public function getCategories(Request $request)
        {
            $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
            $mobile = $payload->get('mobile');
            $customer = Cunsomer::where('customer_mobile', $mobile)->first();
            $id=$request->id;
            $category = ServiceCategory::where('category_parent', $id)->get();
            
            foreach($category as $key=>$categ){

                $cat['iditem']=$categ->id;
                $cat['title']=$categ->category_title;
            //$cat['icon']=$categ->category_icon;
            $cat['icon']='personals/09156833780/photo-1584535352.jpg';


            $catego = ServiceCategory::where('category_parent', $categ->id)->get();


            $chilist=[];


            foreach($catego as $kes=>$categor){

                $chil['iditem']=$categor->id;
                $chil['title']=$categor->category_title;
            //$cat['icon']=$categor->category_icon;
            $chil['icon']='personals/09156833780/photo-1584535352.jpg';


            $categoryzirdaste = ServiceCategory::where('category_parent', $categor->id)->first();
         

            //$chil['rtue']=$categoryzirdaste;

            if($categoryzirdaste){

                $categoryzirdastes = ServiceCategory::where('category_parent', $categoryzirdaste->id)->first();

                if($categoryzirdastes){
                    $chil['type']='2';
                }else{
                    $chil['type']='3';
                }




            }else{
                $chil['type']='3';
            }


            $chilist[$kes]=$chil;
        


            }

            

            $cat['items']=$chilist;



            $cate[$key]=$cat;
        }

        return response()->json([
            'data' => $cate,
        ],200);

     
        }


        public function getServices(Request $request)
        {
            $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
            $mobile = $payload->get('mobile');
            $customer = Cunsomer::where('customer_mobile', $mobile)->first();
            $id=$request->id;
            $categorymainchildsnum =  ServiceCategory::where('category_parent', $id)->count();
            if($categorymainchildsnum){

                $categorymainchilds =  ServiceCategory::where('category_parent', $id)->get();

                foreach($categorymainchilds as $keys=>$categorymainchild){

                    $catres['iditem']=$categorymainchild->id;
                    $catres['title']=$categorymainchild->category_title;
                    $catres['icon']='personals/09156833780/photo-1584535352.jpg';


                    $services = Service::where('service_category_id', $categorymainchild->id)->get();

                    $items=[];
                    foreach($services as $keyss=>$service){

                        $serv['iditem']=$service->id;
                        $serv['title']=$service->service_title;
                        $serv['icon']='personals/09156833780/photo-1584535352.jpg';
                        //$cat['icon']=$servic->service_icon;
                        $serv['type']=4;
    

                        $items[$keyss]=$serv;
                    }


                    $catres['items']=$items;
                    $result[$keys]=$catres;


                }


        return response()->json([
            'data' => $result,
            'error'=>[
                'message'=>'1',
            ],
        ],200);

            }else{

            

            $categoryselected = ServiceCategory::where('id', $id)->first();
            $categoryparents = ServiceCategory::where('id', $categoryselected->category_parent)->first();
            if($categoryparents){
            $categorychilds = ServiceCategory::where('category_parent', $categoryparents->id)->get();


            foreach($categorychilds as $kef=>$categorychild){

                $services = Service::where('service_category_id', $categorychild->id)->get();

                $catres['iditem']=$categorychild->id;
                $catres['title']=$categorychild->category_title;
                $catres['icon']='personals/09156833780/photo-1584535352.jpg';

                $servres=[];

                foreach($services as $key=>$service){

                    $serv['iditem']=$service->id;
                    $serv['title']=$service->service_title;
                    $serv['icon']='personals/09156833780/photo-1584535352.jpg';
                    //$cat['icon']=$servic->service_icon;
                    $serv['type']=4;

    

                    $servres[$key]= $serv;
    

                }

                $catres['items']=$servres;
                $result[$kef]=$catres;


            }





            



        return response()->json([
            'data' => $result,
        ],200);
    
    }else{


        $services = Service::where('service_category_id', $categoryselected->id)->get();

        $catres['iditem']=$categoryselected->id;
        $catres['title']=$categoryselected->category_title;
        $catres['icon']='personals/09156833780/photo-1584535352.jpg';


        foreach($services as $key=>$service){

            $serv['iditem']=$service->id;
            $serv['title']=$service->service_title;
            $serv['icon']='personals/09156833780/photo-1584535352.jpg';
            //$cat['icon']=$servic->service_icon;
            $serv['type']=4;



            $servres[$key]= $serv;


        }

        $catres['items']=$servres;
        $servres=[];
        $result[0]=$catres;

        return response()->json([
            'data' => $result,
        ],200);

    }
}
       
}
    
           
    
    public function getCustomerAddresses(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();
        $customer_model = new Cunsomer();
        $addresses = $customer_model->getAddresses($customer->id);
        $array =[];
       
        foreach ($addresses as $key => $address) {
            $array['addresses'][$key+1]['title'] = $address->title; 
            $array['addresses'][$key+1]['address'] = $address->address; 
        }
        
       
      return response()->json(
        $array
        , 200);


    }

    public function submitAddress(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();
        if (is_null($customer)) {
            return response(
                ['error' => 'خطای احراز هویت'],404
            );
        }
       $customer_broker = $customer->brokers;
// شاید این مشتری متعلق به چند کارگزاری باشد
if(is_array($customer_broker) && count($customer_broker) !== 0){
    foreach ($customer_broker as $key => $broker) {
        CustomerAddress::create([
            'address' => $request->address,
            'broker_id' => $broker,
            'customer_id' => $customer->id
        ]);
    }
}else{
    CustomerAddress::create([
        'address' => $request->address,
        'broker_id' => null,
        'customer_id' => $customer->id
    ]);
}

    return response()->json(
        ['data' => 'ادرس با موفقیت ثبت شد']
        , 200);

    }
}
