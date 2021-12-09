<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function signin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index');
        }
        return view('admin.signin');
    }

    public function handle_signin(Request $req)
    {
        $credentials = $req->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.index');
        }

        return back()->withInput()->with([
            'wrong' => 'Email hoặc mật khẩu không đúng'
        ]);
    }

    public function signout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.signin');
    }
}
