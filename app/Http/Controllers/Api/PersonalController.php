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

      

        $acountcharge = new UserAcounts();

        $acountcharge->user = 'خدمت رسان';
        $acountcharge->type = 'شارژ';
        $acountcharge->cash = 0;
        $acountcharge->personal_id = $personal->id;

        $acountencome = new UserAcounts();

        $acountencome->user = 'خدمت رسان';
        $acountencome->type = 'درآمد';
        $acountencome->cash = 0;
        $acountencome->personal_id = $personal->id;

        $acountcharge->save();
        $acountencome->save();

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
            'profilepic' => $personal->personal_profile,
            'namefname' => $personal->personal_firstname . ' ' . $personal->personal_lastname,
            'incomecash' => $personal->useracounts[1]->cash,
            'chargecash' => $personal->useracounts[0]->cash,
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


        $settings = DB::table('setting')->get();
        $setting=$settings[0];

        $personal->shomareposhtibani=$setting->shomareposhtibani;
        $personal->aboutlink=$setting->linkfaq;


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
                'personal_firstname' => $request->personal_firstname,
                'personal_lastname' => $request->personal_lastname,
                'personal_birthday' => $request->personal_birthday,
                'personal_national_code' => $request->personal_national_code,
                'personal_marriage' => $request->personal_marriage,
                'personal_last_diploma' => $request->personal_last_diploma,
                'personal_home_phone' => $request->personal_home_phone,
                'personal_city' => $request->personal_city,
                'personal_postal_code' => $request->personal_postal_code,
                'personal_address' => $request->personal_address,
                'personal_office_phone' => $request->personal_office_phone,
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
        //if ($request->hasFile('personal_profile')) {
            if($personal->personal_profile){
            File::delete(public_path().'/uploads/'. $personal->personal_profile);
            }

            $personal_img = 'photo'.time().'.'.$request->personal_profile->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/personals/'.$personal->personal_mobile);
            $request->personal_profile->move($destinationPath, $personal_img);
            $personal_profile = 'personals/'.$personal->personal_mobile .'/'.$personal_img;

        Personal::where('personal_mobile', $mobile)
        ->update([
            'personal_profile' => $personal_profile
        ]);
    return response()->json(
            $personal->fresh()
    , 200);

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
