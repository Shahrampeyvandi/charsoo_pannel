<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function index()
    {
        return view('FrontEnd.login');

    }

    public function Login(Request $request)
    {
     
        $user = User::where('user_username', $request->username)->first();

        if($user){
            if(Hash::check($request->input('password'),$user->user_password))
             {
                if ($request->has('rememberme')) {
                    Auth::Login($user,true);
                    $request->session()->flash('Success', 'ورود با موفقیت انجام شد .');
                return redirect()->route('Dashboard');
                } else {
                    Auth::Login($user);
                    $request->session()->flash('Success', 'ورود با موفقیت انجام شد .');
                    return redirect()->route('Dashboard');
                }
              
            } else {
                $request->session()->flash('Error', 'رمز عبور شما صحیح نمی باشد .');
                return back();
            }
        } else {
            $request->session()->flash('Error', ' نام کاربری وارد شده اشتباه است');
            return back();
        }
    }

    public function LogOut()
    {
        
            Auth::logout();
            return redirect()->route('BaseUrl');
        
    }
}
