<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('User.Dashboard');
    }

    public function UserList()
    {
        return view('User.UsersList');
    }
}
