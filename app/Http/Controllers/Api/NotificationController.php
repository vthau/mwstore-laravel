<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Exception;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function get_token(Request $req)
    {
        $tokens = $this->notificationService->getTokenByUser($req);
        return $this->successResponse($tokens);
    }

    public function all_token()
    {
        $tokens = $this->notificationService->getAll();
        return $this->successResponse($tokens);
    }

    public function noti_guest(Request $req)
    {
        try {
            $this->notificationService->saveGuest($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function noti_user(Request $req)
    {
        try {
            $this->notificationService->saveUser($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
