<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function Setting()
    {
        return view('User.Setting');
    }

    public function SettingChange(Request $request)
    {

        return back;
    }
}
