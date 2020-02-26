<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Personals\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class TrackPersonalController extends Controller
{

    public function OnlinePersonals(Request $request)
    {

        $mydate = date('Y-m-d');
        // $mytime = date('H:i');

        //$mytime1= $mytime;

        $datenow = Jalalian::forge('now')->format('H:i'); // 10 دقیقه پیش
        $date1 = Jalalian::forge('now - 1 minutes')->format('H:i'); // 10 دقیقه پیش
        $date2 = Jalalian::forge('now - 2 minutes')->format('H:i'); // 10 دقیقه پیش

        // dd($datenow,$date1,$date2);
        //dd($mydate,$mytime);

        $online = DB::table('personals_positions')
            ->whereDate('created_at', '=', $mydate)
            ->whereTime('created_at', 'like', $datenow . '%')
            ->orwhereTime('created_at', 'like', Jalalian::forge('now - 1 minutes')->format('H:i') . '%')
            ->orwhereTime('created_at', 'like', Jalalian::forge('now - 2 minutes')->format('H:i') . '%')
        // ->orWhere(function($query) {
        //     $query->whereTime('created_at','like', Jalalian::forge('now - 1 minutes')->format('H:i').'%')
        //           ->whereTime('created_at','like', Jalalian::forge('now - 2 minutes')->format('H:i').'%');
        // })
        // ->orwhereTime('created_at', 'like' , $date1.'%')
        // ->orwhereTime('created_at', 'like' , $date2.'%')
            ->get();

        //dd($mydate,$datenow,$date1,$date2,$online);
        $person=array();
        foreach ($online as $key=>$personal) {
            $person[$key] = Personal::find($personal->personal_id);

        }
        //dd($person);

        return view('User.OnlinePersonals', compact('online','person'));
    }

    public function TrackPersonals(Request $request)
    {

        $khedmatResans = Personal::all();

        $id = null;
        $khedmatResan = null;
        //  $khedmatResan = Personal::find($request->personal);

        if (!empty($request->date)) {

            $id = [$request->personal, $request->date];

            $khedmatResan = DB::table('personals_positions')
                ->where('personal_id', '=', $request->personal)
                ->whereDate('created_at', '=', $this->convertDate($request->date), )
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

        return view('User.TrackPersonals', compact(['khedmatResans', 'khedmatResan', 'id']));
    }

}
