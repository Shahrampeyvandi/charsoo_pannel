<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Acounting\UserAcounts;
use App\Models\City\City;
use App\Models\Personals\Personal;
use App\Models\Cunsomers\Cunsomer;
use App\Models\User;
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

        return response()->json([
            'customer_orders' => $orders,
            200
        ]);


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
        $order_detail = $order->orderDetail;
        if(!is_null($service)){
            $service_name = $service->service_title; 
        }else{
            $service_name = 'ندارد';
        }

        $array = [
            'service_name' => $service_name,
            'unique_code' => $order->order_unique_code,
            'order_desc' => $order->order_desc,
            'order_time_first' => $order->order_time_first,
            'order_time_second' => $order->order_time_second,
            'order_date_first' => $order->order_date_first,
            'order_date_second' => $order->order_date_second,
            'order_type' => $order->order_type,
            'personal_firstname' => $order_personal !== null && $order_personal !== '' ? $order_personal->personal_firstname : '',
            'personal_lastname' =>$order_personal !== null && $order_personal !== '' ? $order_personal->personal_lastname : '',
            'personal_last_diploma' =>$order_personal !== null && $order_personal !== '' ? $order_personal->personal_last_diploma : '',
            'personal_mobile' =>$order_personal !== null && $order_personal !== '' ? $order_personal->personal_mobile : '',
            'order_recived_price' =>$order_detail !== null && $order_detail !== '' ? $order_detail->order_recived_price : '',
            'order_pieces_cast' =>$order_detail !== null && $order_detail !== '' ? $order_detail->order_pieces_cast : ''
        ];

        return response()->json($array,200);
    }
}
