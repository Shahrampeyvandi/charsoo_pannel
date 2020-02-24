<?php

namespace App\Http\Controllers\Acounting;

use App\Http\Controllers\Controller;
use App\Models\Acounting\CheckoutPersonals;
use App\Models\Acounting\Transations;
use App\Models\Acounting\UserAcounts;
use App\Models\Personals\Personal;
use Illuminate\Http\Request;

class CheckoutPersonalsController extends Controller
{
    public function index()
    {

        $personals = Personal::all();

        return view('User.Acounting.CheckoutPersonals', compact('personals'));

    }

    public function submit(Request $request)
    {

        $personals = Personal::all();

        //foreach ($request->personals as $person){

        $personal = Personal::find($request->personals);

        //$personal->useracounts->checkoutpersonals();

        // $checkout=$personal->useracounts[0]->checkoutpersonals;

        // ->create{[
        //     'user_acounts_id' => $personal->useracounts[0]->id,
        //     'payed'=>'0',
        //     'type' => 'برداشت',
        //     'amount'=>$personal->useracounts[0]->cash,
        //     'shaba'=>'IR565645435435435'
        // ]};

        if(0>=$personal->useracounts[0]->cash){
            alert()->error('موجودی این خدمت گذار منفی شده!', 'تسویه ایجاد نشد')->autoclose(2000);
        }else{
        $checkout = new CheckoutPersonals();
        $checkout->user_acounts_id = $personal->useracounts[0]->id;
        $checkout->payed = '0';
        $checkout->amount = $personal->useracounts[0]->cash;
        $checkout->shaba = 'IR4354354354353';

        // dd($checkout);

        $personal->useracounts[0]->checkoutpersonals()->save($checkout);
        //}
        }
        return back();
        //return sala;
    }

    public function pay(Request $request)
    {

        //$personals = Personal::all();

         foreach ($request->array as $checkoutid) {
            //$checkout = CheckoutPersonals::find($checkoutid);
        
            $checkout = CheckoutPersonals::find($checkoutid);

            $bool = $checkout->payed;
             if($bool){
            //    // return 'failed';
                alert()->error('این پرداخت قبلا انجام شده است', 'پرداخت نا موفق')->autoclose(2000);
             return 'error';
            }else{

            //dd($checkout);
            $useracount = UserAcounts::find($checkout->user_acounts_id);

            if(0> $useracount->cash){
                alert()->error('موجودی این خدمت گذار منفی شده!', 'پرداخت نا موفق')->autoclose(2000);
             return 'error';
            }

            //$tranatioin=$useracount->tranations;
            $tranatioin = new Transations();

            $tranatioin->user_acounts_id = $useracount->id;

            $tranatioin->type = 'برداشت';

            $tranatioin->for = 'تسویه';
            $tranatioin->amount = $checkout->amount;
            $tranatioin->from_to = $checkout->shaba;

            $useracount->cash = $useracount->cash - $checkout->amount;

           // dd($useracount);
           //dd($tranatioin);

           $tranatioin->save();

           // $useracount->transactions()->save($tranatioin);

             $checkout->payed='1';
             $checkout->transations_id = $tranatioin->id;
             $checkout->payed_at = $tranatioin->created_at;

             $checkout->update();

            
             $useracount->update();

            }
         }
        
        //return 'error';
        //return back;
        alert()->success('پرداخت با موفقیت انجام گردید!', 'پرداخت موفق')->autoclose(2000);
        return 'success';
    }
}
