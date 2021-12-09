<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
