<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SocialService;
use Exception;

class SocialLoginController extends Controller
{
    protected $socialService;

    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    public function social_redirect($social)
    {
        $result = $this->socialService->getLink($social);
        return $this->successResponse($result);
    }

    public function social_callback($social)
    {
        try {
            $result = $this->socialService->socialCallback($social);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
