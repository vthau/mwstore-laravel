<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\SocialRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class SocialService
{
    protected $userRepository;
    protected $socialRepository;

    public function __construct(UserRepository $userRepository, SocialRepository $socialRepository)
    {
        $this->userRepository = $userRepository;
        $this->socialRepository = $socialRepository;

        config(['services.facebook.client_id' => "489841512636220"]);
        config(['services.facebook.client_secret' => "7449c1710ac38985eba3bb8f84357992"]);
        config(['services.google.redirect' => env('GOOGLE_REDIRECT_URI_CLIENT')]);
        config(['services.facebook.redirect' => env('FACEBOOK_REDIRECT_URI_CLIENT')]);
    }

    public function getLink($social)
    {
        return Socialite::driver($social)->stateless()->redirect()->getTargetUrl();
    }

    public function socialCallback($social)
    {
        DB::beginTransaction();

        try {
            $social_user = Socialite::driver($social)->stateless()->user();

            $social_account = $this->socialRepository->getById($social_user->id);
            if (!$social_account) {
                $social_account = $this->socialRepository->save($social_user->id, $social);

                $user = $this->userRepository->getByEmail($social_user->email);
                if (!$user) {
                    $user = $this->userRepository->saveUserSocial($social_account);
                }
                $social_account->user()->associate($user);
            }

            $user = $social_account->user;
            auth()->login($user);
            $user = auth()->user();
            $token = $user->createToken($user->email)->plainTextToken;
            DB::commit();

            return ["user" => $user, "token" => $token];
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }
    }
}
