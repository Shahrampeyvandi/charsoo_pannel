<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notifications\Notifications;
use App\Models\Personals\Personal;
use App\Models\Cunsomers\Cunsomer;

class NotificationsController extends Controller
{
    public function index(){

        $notifications=Notifications::all();

        $cunsomers=Cunsomer::all();
        $personals=Personal::all();


        foreach($notifications as $key=>$notification){

            $arrays = unserialize( $notification->list );

            $list=[];

            if($notification->to == 'مشتری ها'){
    

                foreach($arrays as $kem=>$array){

                    if($array == '0'){
                        $list[]='همه';
                    break;
                    }

                    $cunsomer=Cunsomer::find($array);


                    $list[]=$cunsomer->customer_lastname;

                }



            }else{

                foreach($arrays as $kem=>$array){

                    if($array == '0'){
                        $list[]='همه';
                    break;
                    }

                    $personal=Personal::find($array);


                    $list[]=$personal->personal_lastname;

                }

            }


            $notifications[$key]['list']=$list;

        }


        return view('User.Notifications.Notification',compact(['notifications','cunsomers','personals']));
    }

    public function submit(Request $request){


        $validation = $this->getValidationFactory()->make($request->all(), [
            'title' => 'required',
            'text' => 'required',
            'to' => 'required',
            'how' => 'required',



        ]);

        if ($validation->fails()) {

            //return response()->json(['messsage' => 'invalid'], 400);
            alert()->error('باید تمامی فیلد های الزامل را پر کنید!', 'ثبت صورت نپذیرفت')->autoclose(2000);
            //return 'error';
            return back();

        }

        $notification=new Notifications;

        $notification->title=$request->title;
        $notification->text=$request->text;
        $notification->to=$request->to;
        $notification->how=$request->how;
        $notification->smstemplate=$request->smstemplate;
        $notification->desc=$request->smstemplate;

        if($request->to == 'مشتری ها'){
            $list = serialize( $request->cunsomers );

        }else{
            $list = serialize( $request->personals );
        }

        $notification->list=$list;

        $notification->save();



        alert()->success('نوتیفیکیشن با موفقیت انجام گردید!', 'ثبت موفق')->autoclose(2000);

        return back();
        }

    public function send(Request $request){

        foreach ($request->array as $notificationsid) {
           

            $notification = Notifications::find($notificationsid);

            if(!is_null($notification->sent)){

                alert()->error('این نوتیفیکیشن قبلا ارسال شده است', 'امکان ارسال مجدد این نوتیفیکیشن وجود ندارد')->autoclose(2000);
                
                return 'failed';
            }


       
            $notification->sent=date('Y-m-d H:i:s');


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

        alert()->success('با موفقیت ارسال گردید', 'ارسال موفق')->autoclose(2000);
        return 'success';
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


   
    public function delete(Request $request)
    {
        //dd($request);
        foreach ($request->array as $notificationsid) {
            //$checkout = CheckoutPersonals::find($checkoutid);
        
            $notification = Notifications::find($notificationsid);

            $notification->delete();

          

            
         }
        
        //return 'error';
        //return back;
        alert()->success('با موفقیت حذف گردید', 'حذف موفق')->autoclose(2000);
        return 'success';
    }
}
