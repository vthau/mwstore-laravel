<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function signin()
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        }
        return view('user.signin');
    }

    public function signup()
    {
        return view('user.signup');
    }

    public function handle_signin(SigninRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return back()->withInput()->withErrors([
                'email_or_pass' => 'Email hoặc mật khẩu không đúng'
            ]);
        }
        if (!Auth::user()->block >= 5) {
            return redirect()->route('home.index');
        };
        session(['block' => true]);
        return redirect()->route('user.blocked');
    }

    public function handle_signup(SignUpRequest $req)
    {
        $user = new User;
        $user->fill($req->all());
        $user->password = Hash::make($req->password);

        $user->save();
        Auth::login($user, true);

        return redirect()->route('home.index')->with('signup-success', true);
    }

    public function signout()
    {
        session()->forget('coupon');
        Auth::logout();
        return redirect()->route('home.index');
    }
}
