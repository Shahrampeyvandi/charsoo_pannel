<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notifications\PannelNotifications;
use App\Models\User;

class PannelNotificationsController extends Controller
{
    public function index(){

        $user=auth()->user();

        $notifications=PannelNotifications::where('users_id',$user->id)->where('read',0)->get();
        if(is_null($notifications)){
            $notifications=[];
        }

        return response()->json(
           $notifications
        ,200);

    }
}
