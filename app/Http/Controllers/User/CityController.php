<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function CityList()
    {
        return view('User.Cities.CityList');
    }

    public function SubmitCity(Request $request)
    {
        dd($request->all());
    }
}
