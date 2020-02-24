<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Personals\Personal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Morilog\Jalali\Jalalian;


class TrackPersonalController extends Controller
{

    public function OnlinePersonals(Request $request)
    {

        $mydate = date('Y-m-d');
        $mytime = date('H:i');

        $mytime1= $mytime-1; 


        dd($mytime1);
        //dd($mydate,$mytime);

        $online = DB::table('personals_positions')
        ->whereDate('created_at', '=', $mydate)
        ->whereTime('created_at', 'like', $mytime.'%')
            ->get();

            //dd($online);

         return view('User.OnlinePersonals' , compact('online'));
    }

    public function TrackPersonals(Request $request)
    {

        
        $khedmatResans = Personal::all();

        $id=null;
        $khedmatResan=null;
        //  $khedmatResan = Personal::find($request->personal);

        if(!empty($request->date)){

            $id = [$request->personal, $request->date];


        
            $khedmatResan = DB::table('personals_positions')
            ->where('personal_id', '=',  $request->personal)
            ->whereDate('created_at', '=', $this->convertDate($request->date),)
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
