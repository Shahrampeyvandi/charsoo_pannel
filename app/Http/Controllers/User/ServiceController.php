<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function ServiceList()
    {
        return view('User.Services.ServiceList');
    }
}
