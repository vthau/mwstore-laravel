<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.list')->with(compact(['roles']));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.role.add')->with(compact(['permissions']));
    }

    public function store(Request $req)
    {
        $role = new Role;
        $role->name = $req->name;
        $role->description = $req->description;
        $role->save();

        $permissionIds = $req->permission_id;
        $role->permissions()->attach($permissionIds);

        return redirect()->route('role.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $permission_admin = $role->permissions;
        return view('admin.role.edit')->with(compact(['role', 'permissions', 'permission_admin']));
    }

    public function update(Request $req, $id)
    {
        $role = Role::find($id);
        $role->name = $req->name;
        $role->description = $req->description;
        $role->save();

        $permissionIds = $req->permission_id;
        $role->permissions()->sync($permissionIds);
        return redirect()->route('role.index');
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return \redirect()->route('role.index');
    }
}
