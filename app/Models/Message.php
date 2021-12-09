<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected  $fillable = ['user_id', 'admin_id', 'message', 'type'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }
}
