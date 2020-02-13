<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ServiceController extends Controller
{
    public function CategoryList()
    {
        return view('User.ServiceCategoryList');
    }

    public function ServiceList()
    {
        
        return view('User.ServiceList');
    }

    public function SubmitService(Request $request)
    {
        dd($request->all());
    }

    public function PersonalsList()
    {
        return view('User.PersonalsList');
    }

    public function technicianSubmit()
    {
        dd('dfsf');
    }

    public function OnlinePersonals()
    {
        return view('User.OnlinePersonals');
    }

    public function SubmitServiceCategory(Request $request)
    {
        dd($request->all());
    }
}
