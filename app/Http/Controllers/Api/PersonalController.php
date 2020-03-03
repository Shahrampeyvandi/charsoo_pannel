<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acounting\UserAcounts;
use App\Models\City\City;
use App\Models\Personals\Personal;
use App\Models\User;
use Illuminate\Http\Request;
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

      

        return response()->json([
          'profilepic' => '',
          'namefname' => $personal->personal_firstname.' '.$personal->personal_lastname,

          'incomecash' => $personal->useracounts[0]->cash,

          'chargecash' =>$personal->useracounts[1]->cash,

          'emtiaz' => '0',

      ], 200);
    }

  public function getPersonal(Request $request)
  {
    
       $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
       $mobile = $payload->get('mobile');
       $personal = Personal::where('personal_mobile',$mobile)->first();
       return response()->json(
        $personal
        
      , 200);

  }

  public function updatePersonalData(Request $request)
  {
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile',$mobile)->first();
    if ($request->has('first_page_certificate')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->personal_identity_card_first_pic);
        $first_page_certificate = 'first_page' . '.' . $request->first_page_certificate->getClientOriginalExtension();
        $request->first_page_certificate->move(public_path('uploads/personals/'.$request->national_num), $first_page_certificate);
    } else {
        $first_page_certificate = $personal->personal_identity_card_first_pic;
    }
    if ($request->has('card_Service')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->personal_status_duty);
        $card_Service = 'duty_status' . '.' . $request->card_Service->getClientOriginalExtension();
        $request->card_Service->move(public_path('uploads/personals/'.$request->national_num), $card_Service);
    } else {
        $card_Service = $personal->personal_status_duty;
    }
    if ($request->has('backgrounds_status')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->personal_backgrounds_status);
        $antecedent_report_card = 'antecedent_report_card' . '.' . $request->antecedent_report_card->getClientOriginalExtension();
        $request->antecedent_report_card->move(public_path('uploads/personals/'.$request->national_num), $antecedent_report_card);
    } else {
        $antecedent_report_card = $personal->personal_backgrounds_status;
    }
    if ($request->has('second_page_certificate')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->personal_identity_card_second_pic);
        $second_page_certificate = 'second_page' . '.' . $request->second_page_certificate->getClientOriginalExtension();
        $request->second_page_certificate->move(public_path('uploads/personals/'.$request->national_num), $second_page_certificate);
    } else {
        $second_page_certificate = $personal->personal_identity_card_second_pic;
    }
    if ($request->has('national_card_front_pic')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->personal_national_card_front_pic);
        $national_card_front_pic = 'national_card_front_pic' . '.' . $request->national_card_front_pic->getClientOriginalExtension();
        $request->national_card_front_pic->move(public_path('uploads/personals/'.$request->national_num), $national_card_front_pic);
    } else {
        $national_card_front_pic = $personal->personal_national_card_front_pic;
    }
    if ($request->has('national_card_back_pic')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->personal_national_card_back_pic);
        $national_card_back_pic = 'first_page' . '.' . $request->national_card_back_pic->getClientOriginalExtension();
        $request->national_card_back_pic->move(public_path('uploads/personals/'.$request->national_num), $national_card_back_pic);
    } else {
        $national_card_back_pic = $personal->personal_national_card_back_pic;
    }
    if ($request->has('technical_credential')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->technical_credential);
        $technical_credential = 'technical_credential' . '.' . $request->technical_credential->getClientOriginalExtension();
        $request->technical_credential->move(public_path('uploads/personals/'.$request->national_num), $technical_credential);
    } else {
        $technical_credential = $personal->technical_credential;
    }
    if ($request->has('expert_credential')) {
        File::delete(public_path().'uploads/personals/'.$request->national_num .'/'. $personal->expert_credential);
        $expert_credential = 'expert_credential' . '.' . $request->expert_credential->getClientOriginalExtension();
        $request->expert_credential->move(public_path('uploads/personals/'.$request->national_num), $expert_credential);
    } else {
        $expert_credential = $personal->expert_credential;
    }

    Personal::where('personal_mobile',$mobile)
    ->update([
        'personal_status'=> 0,
        'personal_firstname' => $request->firstname,
        'personal_lastname' => $request->lastname,
        'personal_birthday' => $request->birth_year,
        'personal_national_code' => $request->national_num,
        'personal_marriage' => $request->marriage_status,
        'personal_last_diploma' => $request->education_status,
        'personal_mobile' => $request->mobile,
        'personal_city' => $request->city,
        'personal_postal_code' => $request->postal_code,
        'personal_address' => $request->address,
        'personal_home_phone' => $request->tel_home,
        'personal_office_phone' => $request->tel_work,
        'personal_responsibility' => $request->postal_code,
        'technical_credential' => $technical_credential,
        'expert_credential' => $expert_credential,
        'personal_identity_card_first_pic' => $first_page_certificate,
        'personal_identity_card_second_pic' => $second_page_certificate,
        'personal_status_duty' => $card_Service,
        'personal_backgrounds_status' => $antecedent_report_card,
        'personal_national_card_front_pic' => $national_card_front_pic,
        'personal_national_card_back_pic' => $national_card_back_pic,
        'personal_about_specialization' => $request->about_specialization,
        'personal_work_experience_month' => $request->work_experience_month_num,
        'personal_work_experience_year' => $request->work_experience_year_num,
    ]);
    return response()->json([
      'data' => [
        'personal'=>$personal,
      ],
    ], 200);
  }
  

}
