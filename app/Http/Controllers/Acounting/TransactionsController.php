<?php

namespace App\Http\Controllers\Acounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Personals\Personal;

class TransactionsController extends Controller
{
    public function index()
    {

        $personals = Personal::all();

        $cansomers = Cunsomer::all();

        return view('User.Acounting.Transactions', compact(['personals','cansomers']));
    }}
