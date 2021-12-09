<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function list()
    {
        $admins = Admin::where('role', '<>', config('role.FULL_PERMISSION'))->get();
        return view('admin.admin.list')->with(['admins' => $admins]);
    }

    public function add()
    {
        $roles = Role::all();
        return view('admin.admin.add')->with(['roles' => $roles]);
    }

    public function store(Request $req)
    {
        $admin = new Admin;
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->description = $req->description;
        $admin->password = Hash::make($req->password);
        $admin->image = 'trunghau.png';
        $admin->save();

        $roleIds = $req->role_id;
        $admin->roles()->attach($roleIds);

        return \redirect()->route('admin.list');
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = Role::all();
        $role_admin = $admin->roles;
        return view('admin.admin.edit')->with(['admin' => $admin, 'roles' => $roles, 'role_admin' => $role_admin]);
    }

    public function update(Request $req, $id)
    {
        $admin = Admin::find($id);
        $admin->fill($req->all());
        $admin->password = Hash::make($req->password);
        $admin->save();

        $roleIds = $req->role_id;
        $admin->roles()->sync($roleIds);
        return \redirect()->route('admin.list');
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if ($admin->role != '') {
            $admin->delete();
        }
        return \redirect()->route('admin.list');
    }
}
