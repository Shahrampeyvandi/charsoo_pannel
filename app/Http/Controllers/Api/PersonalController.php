<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Personals\Personal;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class PersonalController extends Controller
{

    public $loginAfterSignUp = true;

    public function register(Request $request)
    {
      // return $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();

      $user = Personal::where('personal_mobile',$request->mobile)->first();
      $token = JWTAuth::fromUser($user);
       $check_personal = Personal::where([
           'personal_mobile' => $request->p_mobile
       ])->count();
       if ($check_personal) {
        return response()->json([
          'token' => $token,
        ], 200);
       }else{
        return response()->json([
          'token' => '',
        ], 200);
      }
        // $user = Personal::create([
        //      'personal_firstname' => $request->p_firstname,
        //     'personal_lastname' => $request->p_lastname,
        //     'personal_mobile' => $request->p_mobile,
        //     'personal_city' => $request->p_city
        //   ]);
          
        //   $token = auth()->guard('personalapi')->login($user);
        //   return $this->respondWithToken($token);
      //  } 
    }

    public function login(Request $request)
    {

      return $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();

      $credentials = $request->only(['email', 'password']);
      $payload = JWTAuth::parseToken($request->input('token'))->getPayload();
      $first_name = $payload->get('first_name');
      $mobile = $payload->get('mobile');
      if (!$token = auth()->guard('personalapi')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
      return $this->respondWithToken($token);
    }
    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->guard('personalapi')->factory()->getTTL() * 60 * 60 * 24
      ]);
    }
}



