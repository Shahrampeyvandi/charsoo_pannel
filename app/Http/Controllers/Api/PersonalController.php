<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acounting\UserAcounts;
use App\Models\City\City;
use App\Models\Personals\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\File;

class PersonalController extends Controller
{
    public $loginAfterSignUp = true;
    public function verify(Request $request)
    {

        $personal = Personal::where('personal_mobile', $request->mobile)->first();
        $check_personal = Personal::where([
            'personal_mobile' => $request->mobile,
        ])->count();
        if ($check_personal) {
            Personal::where('personal_mobile',  $request->mobile)
            ->update([
                'firebase_token' => $request->fcmtoken,
            ]);
    
            $token = JWTAuth::fromUser($personal);
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

    public function getCities()
    {
        $cities = City::orderBy('city_name', 'ASC')->get();
        return response()->json([
            'data' => $cities,
        ], 200);
    }

    public function register(Request $request)
    {

        $personal = Personal::create([
            'personal_firstname' => $request->p_firstname,
            'personal_lastname' => $request->p_lastname,
            'personal_mobile' => $request->p_mobile,
            'personal_city' => $request->p_city,
            'firebase_token' => $request->fcmtoken,
        ]);

        $acountencome = new UserAcounts();

        $acountencome->user = 'خدمت رسان';
        $acountencome->type = 'درآمد';
        $acountencome->cash = 0;
        $acountencome->personal_id = $personal->id;

        $acountcharge = new UserAcounts();

        $acountcharge->user = 'خدمت رسان';
        $acountcharge->type = 'شارژ';
        $acountcharge->cash = 0;
        $acountcharge->personal_id = $personal->id;

        $acountencome->save();
        $acountcharge->save();

        $token = JWTAuth::fromUser($personal);
        return response()->json([
            'code' => $token,
            'error' => '',
        ], 200);
    }

    public function getPersonalDashboardDetail(Request $request)
    {

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
      

        $settings = DB::table('setting')->get();
        $setting=$settings[0];

        return response()->json([
            'profilepic' => '',
            'namefname' => $personal->personal_firstname . ' ' . $personal->personal_lastname,
            'incomecash' => $personal->useracounts[0]->cash,
            'chargecash' => $personal->useracounts[1]->cash,
            'emtiaz' => '0',
            'shomareposhtibani'=>$setting->shomareposhtibani,
            'telegramposhtibani'=>$setting->telegramposhtibani,

        ], 200);
    }

    public function getPersonal(Request $request)
    {

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
        return response()->json(
            $personal,
            200
        );
    }

    public function updatePersonalData(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        Personal::where('personal_mobile', $mobile)
            ->update([
                'personal_status' => 0,
                'personal_firstname' => $request->p_firstname,
                'personal_lastname' => $request->p_lastname,
                'personal_birthday' => $request->p_birth_year,
                'personal_national_code' => $request->p_national_num,
                'personal_marriage' => $request->p_marriage_status,
                'personal_last_diploma' => $request->p_education_status,
                'personal_home_phone' => $request->p_tel_home,
                'personal_city' => $request->p_city,
                'personal_postal_code' => $request->p_postal_code,
                'personal_address' => $request->p_address,
                'personal_office_phone' => $request->p_tel_work,
            ]);
            $personal = Personal::where('personal_mobile', $mobile)->first();
        return response()->json([
            'data' => [
                'personal' => $personal,
            ],
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
        if ($request->has('p_profile')) {
            File::delete(public_path().'/uploads/personals/'. $personal->personal_profile);
           
            $personal_img = 'photo' . '.' . $request->personal_profile->getClientOriginalExtension();
            $request->personal_profile->move(public_path('uploads/personals/'.$personal->mobile), $personal_img);
            $personal_profile = $personal->mobile .'/'.$personal_img;
        } else {
            $personal_profile = $personal->personal_profile;
        }
        Personal::where('personal_mobile', $mobile)
        ->update([
            'personal_profile' => $personal_profile
        ]);
        
    return response()->json([
        'data' => [
            'personal' => $personal->fresh(),
        ],
    ], 200);

    }



    // public function setFireBaseToken(Request $request)
    // {

    //     $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    //     $mobile = $payload->get('mobile');
    //     //$personal = Personal::where('personal_mobile', $mobile)->first();
      
    //     Personal::where('personal_mobile', $mobile)
    //     ->update([
    //         'firebase_token' => $request->fcmtoken,
    //     ]);

       

    //     return response()->json('ok', 200);
    // }
}
