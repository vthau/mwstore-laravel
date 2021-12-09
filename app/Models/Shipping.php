<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'name',
        'email',
        'phone',
        'note',
        'method',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_code', 'code');
    }
}
