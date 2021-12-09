<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    public function admin(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.ADMIN'));
    }

    public function role(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.ROLE'));
    }

    public function brand(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.BRAND'));
    }

    public function product(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.PRODUCT'));
    }

    public function gallery(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.GALLERY'));
    }

    public function post(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.POST'));
    }

    public function slider(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.SLIDER'));
    }

    public function coupon(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.COUPON'));
    }

    public function order(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.ORDER'));
    }

    public function feeship(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.FEESHIP'));
    }

    public function user(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.USER'));
    }

    public function notification(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.NOTIFICATION'));
    }

    public function comment(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.COMMENT'));
    }

    public function info(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.INFO'));
    }

    public function static(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.STATISTIC'));
    }

    public function visitor(Admin $admin)
    {
        return $admin->checkPermissionAccess(config('role.VISITOR'));
    }
}
