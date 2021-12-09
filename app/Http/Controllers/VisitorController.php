<?php

namespace App\Http\Controllers;

use App\Models\Visitor;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::all();
        return view('admin.visitor')->with(compact(['visitors']));
    }
}
