<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['user_id', 'social_id', 'social_name'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
