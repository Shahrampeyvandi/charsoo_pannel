<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Personals\Personal;
use App\Models\Acounting\UserAcounts;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\City\City;

class PersonalController extends Controller
{
  public $loginAfterSignUp = true;
  public function verify(Request $request)
  {

    $personal = Personal::where('personal_mobile', $request->mobile)->first();
    $check_personal = Personal::where([
      'personal_mobile' => $request->mobile
    ])->count();
    if ($check_personal) {
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
      'personal_city' => $request->p_city
    ]);

    $acountencome = new UserAcounts();

    $acountencome->user ='خدمت رسان' ;
    $acountencome->type = 'درآمد';
    $acountencome->cash = 0 ;
    $acountencome->personal_id =$personal->id ;

    $acountcharge = new UserAcounts();

    $acountcharge->user ='خدمت رسان' ;
    $acountcharge->type = 'شارژ';
    $acountcharge->cash = 0 ;
    $acountcharge->personal_id =$personal->id ;


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

       $personal = Personal::where('personal_mobile',$mobile)->first();

       $useracountincome= $personal->useracounts[0];
       $useracountcharge= $personal->useracounts[1];







    return response()->json([
      'data' => [
        'profilepic'=>'',
        'incomecash'=>$useracountincome->cash,
        'chargecash'=>$useracountcharge->cash

      ],
    ], 200);
  }
}
