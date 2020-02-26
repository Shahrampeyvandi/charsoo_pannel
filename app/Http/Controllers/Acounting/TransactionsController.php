<?php

namespace App\Http\Controllers\Acounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Personals\Personal;
use App\Models\Acounting\Transations;
use App\Models\Acounting\UserAcounts;


class TransactionsController extends Controller
{
    public function index()
    {

        $personals = Personal::all();

        $cansomers = Cunsomer::all();

    

        return view('User.Acounting.Transactions', compact(['personals','cansomers']));
    }

    public function submit(Request $request)
    {

        $validation = $this->getValidationFactory()->make($request->all(), [
            'user_acounts_id' => 'required',
            'amount' => 'required',


        ]);

        if ($validation->fails()) {

            //return response()->json(['messsage' => 'invalid'], 400);
            alert()->error('باید تمامی فیلد های الزامل را پر کنید!', 'تراکنش صورت نپذیرفت')->autoclose(2000);
            //return 'error';
            return back();

        }

        $transaction = new Transations();
       

        $transaction->user_acounts_id=$request->useracountid;     

        $transaction->type=$request->type;
        $transaction->for=$request->for;
        if($request->order_id){
        $transaction->order_id=$request->order_id;
        }
        $transaction->amount=$request->amount;
        if($request->from_to){
        $transaction->from_to=$request->from_to;
        }
        if($request->description){
        $transaction->description=$request->description;
        }

        $acount = UserAcounts::find($request->useracountid);

        //$transaction->save();

        if($transaction->type == 'برداشت'){
            //dd($transaction);

            $acount->cash=$acount->cash-$transaction->amount;

        }else{
            $acount->cash=$acount->cash+$transaction->amount;


        }

       // dd($acount);
    
        //$transaction->save();

       // $acount->update();

        alert()->success('پرداخت با موفقیت انجام گردید!', 'پرداخت موفق')->autoclose(2000);

        return back;
    }


}
