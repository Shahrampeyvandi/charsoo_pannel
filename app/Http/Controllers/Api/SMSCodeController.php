<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SMSCodeController extends Controller
{
    public function sendcode(Request $request)
    {

        $validation = $this->getValidationFactory()->make($request->all(), [
            'phone' => 'required',

        ]);

        if ($validation->fails()) {

            return response()->json(['messsage' => 'invalid'], 400);
        }

        $apikey = '5079544B44782F41475237506D6A4C46713837717571386D6D784636486C666D';

        $receptor = $request->phone;
        //$token = 'خدمات.محصلی.بضروری';
        $token = rand(1000,9999);
        $template = 'Khadamate';
        $api = new \Kavenegar\KavenegarApi($apikey);
       
        try {
            $api->VerifyLookup($receptor, $token, null, null, $template);
        } catch (\Kavenegar\Exceptions\ApiException $e) {

            return response()->json(['message' => 'مشکل پنل پیامکی پیش آمده است =>' . $e->errorMessage()], 400);
       
        } catch (\Kavenegar\Exceptions\HttpException $e) {

            return response()->json(['message' => 'مشکل اتصال پیش امده است' . $e->errorMessage()], 400);
       
        }

        return response()->json(['code' => $token], 200);

    }
}
