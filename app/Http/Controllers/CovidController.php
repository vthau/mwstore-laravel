<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CovidController extends Controller
{
    public function index()
    {
        return view('user.utils.covid');
    }
}
