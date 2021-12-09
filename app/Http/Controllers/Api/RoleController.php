<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function all_role()
    {
        $roles = Role::all();
        return response()->json(["status" => "SUCCESS", "data" => $roles]);
    }

    public function get_role(Request $req)
    {
        $role = Role::with("permissions")->where("id", $req->id)->first();
        if (!$role) return $role;
        return response()->json(["status" => "SUCCESS", "data" => $role]);
    }

    public function new_role(Request $req)
    {
        $role = new Role;
        $role->fill($req->except(["permissions"]));
        $role->save();

        $permissionIds = $req->permissions;
        $role->permissions()->attach($permissionIds);
        return response()->json(["status" => "SUCCESS"]);
    }

    public function update_role(Request $req)
    {
        $role = Role::find($req->id);
        $role->fill($req->except(["permissions"]));
        $role->save();

        $permissionIds = $req->permissions;
        $role->permissions()->sync($permissionIds);
        return response()->json(["status" => "SUCCESS"]);
    }

    public function delete_role(Request $req)
    {
        Role::find($req->id)->delete();
        return response()->json(["status" => "SUCCESS"]);
    }
}
