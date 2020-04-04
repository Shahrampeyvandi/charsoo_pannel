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

    public function getCAllOrder(Request $request)
    {
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
     $customer = Cunsomer::where('customer_mobile', $mobile)->first();

     $orders = $customer->order->where('order_type', 'پیشنهاد داده شده')->get();

     
      return response()->json([
        'data' => $orders,
      ], 200);
    }
  
    public function getCOrder(Request $request)
    {
     $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
     $mobile = $payload->get('mobile');
     $customer = Cunsomer::where('customer_mobile', $mobile)->first();

     $order = $personal->order->where('order_type', 'پیشنهاد داده شده');

     
      return response()->json(
         $order
      , 200);
    }
}
