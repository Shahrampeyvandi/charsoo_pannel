<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\Personals\Personal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Services\ServiceCategory;

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
        
            ->where(function ($query) {
                $query->whereTime('created_at', 'like', Jalalian::forge('now')->format('H:i').'%')
                ->orwhereTime('created_at', 'like', Jalalian::forge('now - 1 minutes')->format('H:i') . '%')
                ->orwhereTime('created_at', 'like', Jalalian::forge('now - 2 minutes')->format('H:i') . '%');
            })
        // ->orWhere(function($query) {
        //     $query->whereTime('created_at','like', Jalalian::forge('now - 1 minutes')->format('H:i').'%')
        //           ->whereTime('created_at','like', Jalalian::forge('now - 2 minutes')->format('H:i').'%');
        // })
        // ->orwhereTime('created_at', 'like' , $date1.'%')
        // ->orwhereTime('created_at', 'like' , $date2.'%')
            ->get();

            //dd($online);
        //dd($mydate,$datenow,$date1,$date2,$online);
        $person=array();
        foreach ($online as $key=>$personal) {
            $person[$key] = Personal::find($personal->personal_id);

        }
        //dd($person);

        if (auth()->user()->hasRole('admin_panel')) {
           
            $category_parent_list = ServiceCategory::where('category_parent',0)->get();
            $count = ServiceCategory::where('category_parent',0)->count();
             $list ='<option data-parent="0" value="0" class="level-1">بدون دسته بندی</option>';
            foreach ($category_parent_list as $key => $item) {
                
                $list .= '<option data-id="'.$item->id.'" value="'.$item->id.'" class="level-1">'.$item->category_title.' 
                 '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
                </option>';
              if (ServiceCategory::where('category_parent',$item->id)->count()) {
                  $count += ServiceCategory::where('category_parent',$item->id)->count();
                 foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key1 => $itemlevel1) {
                     $list .= '<option data-parent="'.$item->id.'" value="'.$itemlevel1->id.'" class="level-2">'.$itemlevel1->category_title.'
                     '.(count(ServiceCategory::where('category_parent',$itemlevel1->id)->get()) ? '&#xf104;  ' : '' ).'
                     </option>';
                     
                     
                  if (ServiceCategory::where('category_parent',$itemlevel1->id)->count()) {
                     $count += ServiceCategory::where('category_parent',$itemlevel1->id)->count();
                     foreach (ServiceCategory::where('category_parent',$itemlevel1->id)->get() as $key2 => $itemlevel2) {
                         $list .= '<option data-parent="'.$itemlevel1->id.'" value="'.$itemlevel2->id.'" class="level-3">'.$itemlevel2->category_title.'
                         '.(count(ServiceCategory::where('category_parent',$itemlevel2->id)->get()) ? '&#xf104;  ' : '' ).'
                         </option>';
                        
                        
                        if (ServiceCategory::where('category_parent',$itemlevel2->id)->count()) {
                         $count += ServiceCategory::where('category_parent',$itemlevel2->id)->count();
                         foreach (ServiceCategory::where('category_parent',$itemlevel2->id)->get() as $key3 => $itemlevel3) {
                             $list .= '<option data-parent="'.$itemlevel2->id.'" value="'.$itemlevel3->id.'" class="level-4">'.$itemlevel3->category_title.'
                             '.(count(ServiceCategory::where('category_parent',$itemlevel3->id)->get()) ? '&#xf104;  ' : '' ).'
                             </option>';
                         
                             if (ServiceCategory::where('category_parent',$itemlevel3->id)->count()) {
                                 $count += ServiceCategory::where('category_parent',$itemlevel3->id)->count();
                                 foreach (ServiceCategory::where('category_parent',$itemlevel3->id)->get() as $key4 => $itemlevel4) {
                                     $list .= '<option data-parent="'.$itemlevel3->id.'" value="'.$itemlevel4->id.'" class="level-4">'.$itemlevel4->category_title.'
                                     
                                     </option>';
                                 
                                 }
                                }
                         
                         }
                        }
                     }
                  }
                 
                  }
              }
            }

            $service_options = '';
          }else{
              $list ='';

            if (auth()->user()->roles->first()->broker !== null) {
                $services = auth()->user()->services;
               
            }
            if (auth()->user()->roles->first()->sub_broker !== null) {
                $role_id = auth()->user()->roles->first()->sub_broker;
                $user =  User::whereHas('roles', function ($q) use ($role_id) {
                    $q->where('id',$role_id);
                })->first();
                $services = $user->services;
               
            }
           $service_options ='<option  value="" class="">باز کردن فهرست انتخاب</option>';
           foreach ($services as $key => $service) {
            $service_options .= '<option  value="'.$service->id.'" class="">'.$service->service_title.'</option>';
           }
         
    
          }

        return view('User.OnlinePersonals', compact('online','person','list','service_options'));
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
