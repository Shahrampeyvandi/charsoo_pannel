<?php

namespace App\Http\Controllers\Acounting;

use App\Http\Controllers\Controller;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Personals\Personal;

class UserAcountsController extends Controller
{

    public function index()
    {

        $personals = Personal::all();

        $cansomers = Cunsomer::all();

        return view('User.Acounting.UserAcounts', compact(['personals','cansomers']));
    }
}
