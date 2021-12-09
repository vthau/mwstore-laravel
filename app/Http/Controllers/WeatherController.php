<?php

namespace App\Http\Controllers;

class WeatherController extends Controller
{
    public function index()
    {
        return view('user.utils.weather');
    }
}
