<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function auth_token()
    {
        try {
            $result = $this->userService->authToken();
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function signup(Request $req)
    {
        try {
            $this->userService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function signin(Request $req)
    {
        try {
            $result = $this->userService->signIn($req);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function signout()
    {
        try {
            $this->userService->signOut();
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_profile(Request $req)
    {
        try {
            $this->userService->updateProfile($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_avatar(Request $req)
    {
        try {
            $this->userService->updateAvatar($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_password(Request $req)
    {
        try {
            $this->userService->updatePassword($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function all_user()
    {
        $users = $this->userService->getAll();
        return $this->successResponse($users);
    }

    public function delete_user(Request $req)
    {
        try {
            $this->userService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function export_excel()
    {
        return $this->userService->exportExcel();
    }
}
