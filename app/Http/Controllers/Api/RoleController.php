<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Exception;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function all_role()
    {
        $roles = $this->roleService->getAll();
        return $this->successResponse($roles);
    }

    public function get_role(Request $req)
    {
        $role = $this->roleService->getById($req);
        return $this->successResponse($role);
    }

    public function new_role(Request $req)
    {
        try {
            $this->roleService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_role(Request $req)
    {
        try {
            $this->roleService->update($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_role(Request $req)
    {
        try {
            $this->roleService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
