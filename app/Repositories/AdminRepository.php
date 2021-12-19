<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function getAll()
    {
        $email = auth()->guard('admin_api')->user()->email;
        $admins = $this->admin->with("roles.permissions")->where([
            ['role', '=', 'NORMAL'],
            ['email', '<>', $email],
        ])->get();

        return $admins;
    }

    public function getById($id)
    {
        return $this->admin->find($id);
    }

    public function getByEmail($email)
    {
        return $this->admin->where('email', $email)->first();
    }

    public function save($data)
    {
        $admin = new $this->admin;
        $admin->fill($data->all());
        $admin->password = Hash::make($data->password);
        $admin->save();

        $roleIds = $data->roles;
        $admin->roles()->sync($roleIds);
        return $admin->fresh();
    }

    public function update($data)
    {
        $admin = $this->admin->find($data->id);
        $admin->fill($data->except(['password']));
        if ($data->password) {
            $admin->password = Hash::make($data->password);
        }
        $admin->save();

        $roleIds = $data->roles;
        $admin->roles()->sync($roleIds);
        return $admin->fresh();
    }

    public function updateProfile($data)
    {
        $id = auth()->guard('admin_api')->user()->id;
        return $this->admin->where("id", $id)->update($data->all());
    }

    public function updatePassword($data)
    {
        $id = auth()->guard('admin_api')->user()->id;
        $admin = $this->admin->find($id);
        $admin->password = Hash::make($data->new_password);
        $admin->save();
        return $admin->fresh();
    }

    public function delete($data)
    {
        return $this->admin->find($data->id)->delete();
    }
}
