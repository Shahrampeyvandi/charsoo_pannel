<?php

namespace App\Http\Schedules;

use App\Models\Notifications\Notifications;
use App\Models\Personals\Personal;
use App\Models\Cunsomers\Cunsomer;

class NotificationScheduler
{

  
    public function __invoke()
    {


        $notification=Notifications::where('send',date('Y-m-d H:00:00'))->first();
        if($notification){
            if($notification->sent == 0){
            //$notification = Notifications::find($notification->id);

         

       
            $notification->sent=1;


            $array = unserialize( $notification->list );

            if($notification->to == 'مشتری ها'){

                foreach($array as $key=>$fard){

                    if($fard == 0){
                        $members = Cunsomer::all();

                    }else{
                        $members[] = Cunsomer::find($fard);

                    }

                    foreach($members as $member){

                    if($notification->how == 'پیامک'){

                        $this->sendsms($member->customer_mobile,$notification->text,$notification->smstemplate);

                    }else if($notification->how == 'نوتیفیکیشن'){

                        $this->sendnotification($member->firebase_token/$notification->title,$notification->text);


                    }else{

                        $this->sendsms($member->customer_mobile,$notification->text,$notification->smstemplate);
                        $this->sendnotification($member->firebase_token,$notification->title,$notification->text);


                    }


                }

            }
            }else{


                foreach($array as $key=>$fard){

                    if($fard == 0){
                        $members = Personal::all();

                    }else{
                        $members[] = Personal::find($fard);

                    }

                    foreach($members as $member){



                    if($notification->how == 'پیامک'){

                        $this->sendsms($member->personal_mobile,$notification->text,$notification->smstemplate);

                    }else if($notification->how == 'نوتیفیکیشن'){

                        $this->sendnotification($member->firebase_token,$notification->title,$notification->text);


                    }else{

                        $this->sendsms($member->personal_mobile,$notification->text,$notification->smstemplate);
                        $this->sendnotification($member->firebase_token,$notification->title,$notification->text);


                    }


                }

            }

            }

            
         }
        
         $notification->update();
        }
    }





    public function sendsms($phone , $text,$template){

        $apikey = '5079544B44782F41475237506D6A4C46713837717571386D6D784636486C666D';

        $receptor = $phone;
        $token = $text;
        $template = $template;
        $api = new \Kavenegar\KavenegarApi($apikey);

        try {
            $api->VerifyLookup($receptor, $token, null, null, $template);
        } catch (\Kavenegar\Exceptions\ApiException $e) {

            //return response()->json(['message' => 'مشکل پنل پیامکی پیش آمده است =>' . $e->errorMessage()], 400);
            return response()->json(['code'=> $token ,'error' => 'مشکل پنل پیامکی پیش آمده است =>' . $e->errorMessage()
            ],500);

        } catch (\Kavenegar\Exceptions\HttpException $e) {

            return response()->json(['code'=> $token,'error' => 'مشکل اتصال پیش امده است =>' . $e->errorMessage()],500);

        }

        return response()->json(['code' => $token], 200);
       // return response()->json(['data'=> ['code' => $token] ],200);

    }

    public function sendnotification($firebasetoken ,$title, $text){

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notification = [
            'title' => $text,
            'sound' => true,
        ];

        $extraNotificationData = ["message" => $title, "moredata" => $title];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $firebasetoken, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $serverkey = env('FIREBASE_LEGACY_SERVER_KEY');


        $headers = [
            'Authorization: key=' . $serverkey,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        //dd($ch);

        return true;
    

    }
}
