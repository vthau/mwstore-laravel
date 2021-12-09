<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

class PermissionGateAndPolicyAccess
{

    public function setGateAndPolicyAccess()
    {
        $this->defineGateAdmin();
    }

    public function defineGateAdmin()
    {
        Gate::define(config('role.ADMIN'), 'App\Policies\AdminPolicy@admin');
        Gate::define(config('role.ROLE'), 'App\Policies\AdminPolicy@role');
        Gate::define(config('role.BRAND'), 'App\Policies\AdminPolicy@brand');
        Gate::define(config('role.PRODUCT'), 'App\Policies\AdminPolicy@product');
        Gate::define(config('role.GALLERY'), 'App\Policies\AdminPolicy@gallery');
        Gate::define(config('role.POST'), 'App\Policies\AdminPolicy@post');
        Gate::define(config('role.SLIDER'), 'App\Policies\AdminPolicy@slider');
        Gate::define(config('role.COUPON'), 'App\Policies\AdminPolicy@coupon');
        Gate::define(config('role.ORDER'), 'App\Policies\AdminPolicy@order');
        Gate::define(config('role.FEESHIP'), 'App\Policies\AdminPolicy@feeship');
        Gate::define(config('role.USER'), 'App\Policies\AdminPolicy@user');
        Gate::define(config('role.NOTIFICATION'), 'App\Policies\AdminPolicy@notification');
        Gate::define(config('role.COMMENT'), 'App\Policies\AdminPolicy@comment');
        Gate::define(config('role.INFO'), 'App\Policies\AdminPolicy@info');
        Gate::define(config('role.STATISTIC'), 'App\Policies\AdminPolicy@static');
        Gate::define(config('role.VISITOR'), 'App\Policies\AdminPolicy@visitor');
    }
}
