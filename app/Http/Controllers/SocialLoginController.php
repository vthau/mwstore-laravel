<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class SocialLoginController extends Controller
{
    public $zalo;

    public function __construct()
    {
        $config = [
            'app_id' => strval(env('ZALO_CLIENT_ID')),
            'app_secret' => env('ZALO_CLIENT_SECRET'),
            'callback_url' => env('ZALO_REDIRECT_URI'),
        ];
        $this->zalo = new Zalo($config);
    }

    public function redirect_to_zalo()
    {
        $helper = $this->zalo->getRedirectLoginHelper();
        $callbackUrl = env('ZALO_REDIRECT_URI');
        $loginUrl = $helper->getLoginUrl($callbackUrl); // This is login url
        return redirect($loginUrl);
    }

    public function handle_signin_zalo(Request $req)
    {
        $helper = $this->zalo->getRedirectLoginHelper();
        $callbackUrl = env('ZALO_REDIRECT_URI');
        $accessToken = $helper->getAccessToken($callbackUrl); // get access token
        if (!$accessToken) {
            return redirect()->route('user.signin_get');
        }

        $params = ['fields' => 'id,name,birthday,gender,picture'];
        $response = $this->zalo->get(ZaloEndpoint::API_GRAPH_ME, $accessToken, $params);
        $user_zalo = $response->getDecodedBody();

        if (!$user_zalo) {
            return redirect()->route('user.signin_get');
        }

        $user = User::where('zalo_id', $user_zalo['id'])->first();
        if (!$user) {
            $user = new User;
            $user->name = $user_zalo['name'];
            $image = downloadImage($user_zalo['picture']['data']['url'], 'avatars');
            $user->image = $image;
            $user->zalo_id = $user_zalo['id'];
            $user->save();
        }

        Auth::login($user, true);
        return redirect()->route('home.index')->with('signup-success', true);
    }

    public function redirect_to_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirect_to_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handle_signin_google()
    {
        $social_user = Socialite::driver("google")->stateless()->user();

        if (!$social_user) {
            return redirect()->route('user.signin_get');
        }

        $social_account = SocialAccount::where('social_id', $social_user->id)->first();
        if (!$social_account) {
            $social_account = new SocialAccount;
            $social_account->social_id = $social_user->id;
            $social_account->social_name = "google";

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
        Auth::login($user);
        return redirect()->route('home.index')->with('signup-success', true);
    }

    public function handle_signin_facebook(Request $request)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect()->route('user.signin_get');
        }

        $social_user = Socialite::driver("facebook")->stateless()->user();

        if (!$social_user) {
            return redirect()->route('user.signin_get');
        }

        $social_account = SocialAccount::where('social_id', $social_user->id)->first();
        if (!$social_account) {
            $social_account = new SocialAccount;
            $social_account->social_id = $social_user->id;
            $social_account->social_name = "facebook";

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
        Auth::login($user);
        return redirect()->route('home.index')->with('signup-success', true);
    }
}
