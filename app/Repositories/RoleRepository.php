<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAll()
    {
        return $this->role->all();
    }

    public function getById($data)
    {
        return $this->role->with("permissions")->find($data->id);
    }

    public function save($data)
    {
        $role = $this->role->create($data->except(["permissions"]));
        $permissionIds = $data->permissions;
        $role->permissions()->attach($permissionIds);
        return $role->fresh();
    }

    public function update($data)
    {
        $role = $this->role->find($data->id);
        $role->fill($data->except(["permissions"]));
        $role->save();
        $permissionIds = $data->permissions;
        $role->permissions()->attach($permissionIds);
        return $role->fresh();
    }

    public function delete($data)
    {
        return $this->role->find($data->id)->delete();
    }
}
