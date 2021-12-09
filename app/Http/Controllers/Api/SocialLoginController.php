<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Models\SocialAccount;
use Socialite;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        config(['services.facebook.client_id' => "489841512636220"]);
        config(['services.facebook.client_secret' => "7449c1710ac38985eba3bb8f84357992"]);
        config(['services.google.redirect' => env('GOOGLE_REDIRECT_URI_CLIENT')]);
        config(['services.facebook.redirect' => env('FACEBOOK_REDIRECT_URI_CLIENT')]);
    }

    public function social_redirect($social)
    {
        return response()->json([
            "status" => "SUCCESS",
            "data" =>  Socialite::driver($social)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function social_callback($social)
    {
        $social_user = Socialite::driver($social)->stateless()->user();

        $social_account = SocialAccount::where('social_id', $social_user->id)->first();
        if (!$social_account) {
            $social_account = new SocialAccount;
            $social_account->social_id = $social_user->id;
            $social_account->social_name = $social;

            $user = User::where('email', $social_user->email)->first();
            if (!$user) {
                $user = new User;
                $user->fill((array)$social_user);
                $image = downloadImage($social_user->avatar, 'avatars');
                $user->image = $image;
                $user->save();
            }

            $social_account->user()->associate($user);
            $social_account->save();
        }

        $user = $social_account->user;
        auth()->login($user);
        $user = auth()->user();
        $token = $user->createToken($user->email)->plainTextToken;
        Activity::signinSocial();
        return response()->json([
            "status" => "SIGN_IN_SUCCESS",
            "user" => $user,
            "token" => $token,
        ]);
    }
}
