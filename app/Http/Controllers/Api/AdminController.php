<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    private function get_roles($roles)
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

    public function auth_token(Request $req)
    {
        $admin = auth()->guard('admin_api')->user()->load("roles.permissions");
        $admin->tokens()->delete();
        $token = $admin->createToken($admin->email)->plainTextToken;
        $roles = $this->get_roles($admin->roles);
        return response()->json([
            "status" => "AUTH_SUCCESS",
            "data" => ["admin" => $admin, "token" => $token, "roles" => $roles],
        ]);
    }

    public function signin(Request $req)
    {
        $credentials = $req->only(['email', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = auth()->guard('admin')->user()->load("roles.permissions");
            $token = $admin->createToken($admin->email)->plainTextToken;
            $roles = $this->get_roles($admin->roles);
            return response()->json([
                "status" => "SIGN_IN_SUCCESS",
                "data" => ["admin" => $admin, "token" => $token, "roles" => $roles],
            ]);
        }

        return response()->json([
            "status" => "SIGN_IN_FAIL",
        ]);
    }

    public function signout()
    {
        auth()->guard('admin_api')->user()->tokens()->delete();
        auth()->guard('admin')->logout();
        session()->flush();
        cookie('laravel_session', '', -1);

        return response()->json([
            "status" => "SIGN_OUT_SUCCESS",
        ]);
    }

    public function all_admin()
    {
        $email = auth()->guard('admin_api')->user()->email;
        $admins = Admin::with("roles.permissions")->where([
            ['role', '=', 'NORMAL'],
            ['email', '<>', $email],
        ])->get();

        return response()->json([
            "status" => "SUCCESS",
            "data" => $admins,
        ]);
    }

    public function update_admin(Request $req)
    {
        $admin = Admin::find($req->id);

        $find_email = Admin::where('email', $req->email)->first();
        if ($find_email) {
            if ($find_email->email !== $admin->email) {
                return response()->json(["status" => "EMAIL_EXIST"]);
            }
        }

        $admin->fill($req->except(['password']));

        if ($req->password) {
            $admin->password = Hash::make($req->password);
        }
        $admin->save();

        $roleIds = $req->roles;
        $admin->roles()->sync($roleIds);
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function new_admin(Request $req)
    {
        $admin = Admin::where('email', $req->email)->first();
        if ($admin) {
            return response()->json(["status" => "EMAIL_EXIST"]);
        }

        $admin = new Admin;
        $admin->fill($req->all());
        $admin->password = Hash::make($req->password);
        $admin->save();

        $roleIds = $req->roles;
        $admin->roles()->sync($roleIds);
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function update_profile(Request $req)
    {
        $id = auth()->guard('admin_api')->user()->id;
        Admin::where("id", $id)->update($req->all());
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function update_password(Request $req)
    {
        $id = auth()->guard('admin_api')->user()->id;
        $admin = Admin::find($id);
        $password = $admin->password;
        $old_password = $req->old_password;
        $new_password = $req->new_password;

        if (Hash::check($old_password, $password)) {
            $admin->password = Hash::make($new_password);
            $admin->save();

            return response()->json([
                "status" => "SUCCESS",
            ]);
        }

        return response()->json([
            "status" => "FAIL",
        ]);
    }

    public function delete_admin(Request $req)
    {
        Admin::find($req->id)->delete();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }
}
