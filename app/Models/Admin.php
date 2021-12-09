<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use  Notifiable, HasApiTokens;

    protected $table = 'admins';
    protected $guarded = ['admin'];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function checkPermissionAccess($pemission_check)
    {
        $admin = auth('admin')->user();
        if ($admin->role == config('role.FULL_PERMISSION')) return true;

        $roles = $admin->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            if ($permissions->contains('key_code', $pemission_check)) {
                return true;
            }
        }
    }
}
