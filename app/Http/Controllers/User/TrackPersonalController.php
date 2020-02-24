<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Personals\Personal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TrackPersonalController extends Controller
{

    public function OnlinePersonals(Request $request)
    {
        $online = DB::table('personals_positions')
        ->whereDate('created_at', '=', '2020-02-22')
        ->whereTime('created_at', 'like', '09:53%')
            ->get();

            //dd($online);

         return view('User.OnlinePersonals' , compact('online'));
    }

    public function TrackPersonals(Request $request)
    {

        
        $khedmatResans = Personal::all();

        $id;
        $khedmatResan;
        //  $khedmatResan = Personal::find($request->personal);

        if(!empty($request)){

            $id = [$request->personal, $request->date];
        
            $khedmatResan = DB::table('personals_positions')
            ->where('personal_id', '=',  $request->personal)
            ->whereDate('created_at', '=', $request->date)
            ->latest()
            ->get();
            
    }

        //dd($id);
      

        // $users = DB::table('personals_positions')
        //    ->where('name', '=', 'John')
        //    ->where(function ($query) {
        //        $query->orWhere('personal_id', '=', '1')
        //        ->whereDate('created_at', '2020-02-04');
                  
        //    })
        //    ->get();



        return view('User.TrackPersonals',compact(['khedmatResans', 'khedmatResan' ,'id']));
    }

}
