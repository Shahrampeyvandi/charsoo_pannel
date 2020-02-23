<?php

namespace App\Http\Controllers\Acounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personals\Personal;
use App\Models\Acounting\CheckoutPersonals;


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

            $personal->useracounts->checkoutpersonals();

          
            dd($personal);


        //}

        //return back();
        return sala;
    }
}
