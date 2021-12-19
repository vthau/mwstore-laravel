<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    protected function getRoles($roles)
    {
        $permissions_result = [];

        foreach ($roles as $role) {
            $permissions = $role->permissions;
            foreach ($permissions as $permission) {
                if (!in_array($permission->key_code, $permissions_result)) $permissions_result[] = $permission->key_code;
            }
        }

        return $permissions_result;
    }

    public function getAll()
    {
        return $this->adminRepository->getAll();
    }

    public function getById($data)
    {
        return $this->adminRepository->getById($data);
    }

    public function authToken()
    {
        $admin = auth()->guard('admin_api')->user()->load("roles.permissions");
        $admin->tokens()->delete();
        $token = $admin->createToken($admin->email)->plainTextToken;
        $roles = $this->getRoles($admin->roles);
        return ["admin" => $admin, "token" => $token, "roles" => $roles];
    }

    public function save($data)
    {
        $admin = $this->adminRepository->getByEmail($data->email);
        if ($admin) {
            throw new Exception("EMAIL_EXIST");
        }

        DB::beginTransaction();

        try {
            $this->adminRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function update($data)
    {
        $admin = $this->adminRepository->getById($data->id);
        $checkEmail = $this->adminRepository->getByEmail($data->email);
        if ($checkEmail) {
            if ($checkEmail->email !== $admin->email) {
                throw new Exception("EMAIL_EXIST");
            }
        }

        DB::beginTransaction();

        try {
            $this->adminRepository->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function updateProfile($data)
    {
        DB::beginTransaction();

        try {
            $this->adminRepository->updateProfile($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function updatePassword($data)
    {
        $id = auth()->guard('admin_api')->user()->id;
        $admin = $this->adminRepository->getById($id);

        if (!Hash::check($data->old_password, $admin->password)) {
            throw new Exception("WRONG_PASSWORD");
        }

        DB::beginTransaction();

        try {
            $this->adminRepository->updatePassword($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $this->adminRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function signIn($data)
    {
        $credentials = $data->only(['email', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = auth()->guard('admin')->user()->load("roles.permissions");
            $token = $admin->createToken($admin->email)->plainTextToken;
            $roles = $this->getRoles($admin->roles);
            return ["admin" => $admin, "token" => $token, "roles" => $roles];
        }

        throw new Exception("FAIL");
    }

    public function signOut()
    {
        try {
            auth()->guard('admin_api')->user()->tokens()->delete();
            auth()->guard('admin')->logout();
            session()->flush();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
