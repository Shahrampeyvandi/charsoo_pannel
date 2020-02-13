<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CunsomerController extends Controller
{
    public function CunsomerList()
    {
        return view('User.Cunsomers.CunsomerList');
    }
}
