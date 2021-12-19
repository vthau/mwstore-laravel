<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getAll()
    {
        return $this->permission->where([["key_code", "<>", "ADMIN"], ["key_code", "<>", "ROLE"]])->get();
    }
}
