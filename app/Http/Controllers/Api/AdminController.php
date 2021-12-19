<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Exception;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function auth_token()
    {
        try {
            $result = $this->adminService->authToken();
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function signin(Request $req)
    {
        try {
            $result = $this->adminService->signIn($req);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function signout()
    {
        try {
            $this->adminService->signOut();
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function all_admin()
    {
        $admins = $this->adminService->getAll();
        return $this->successResponse($admins);
    }

    public function update_admin(Request $req)
    {
        try {
            $this->adminService->update($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function new_admin(Request $req)
    {
        try {
            $this->adminService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_profile(Request $req)
    {
        try {
            $this->adminService->updateProfile($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_password(Request $req)
    {
        try {
            $this->adminService->updatePassword($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_admin(Request $req)
    {
        try {
            $this->adminService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
