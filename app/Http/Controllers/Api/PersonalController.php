<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Personals\Personal;
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
        'token' => $token,
      ], 200);
    } else {
      return response()->json([
        'token' => '',
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

    $token = JWTAuth::fromUser($personal);
    return response()->json([
      'token' => $token,
    ], 200);
  }
}
