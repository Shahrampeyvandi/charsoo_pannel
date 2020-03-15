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
    public function getCustomer(Request $request)
    {
        
    }

    public $loginAfterSignUp = true;
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
            'customer_firstname' => $request->p_firstname,
            'customer_lastname' => $request->p_lastname,
            'customer_mobile' => $request->p_mobile,
            'firebase_token' => $request->fcmtoken,
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

}
