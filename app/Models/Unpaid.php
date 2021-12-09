<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unpaid extends Model
{
    protected $primaryKey = 'order_code';
    public $incrementing = false;

    protected $fillable = [
        'order_code',
        'name',
        'email',
        'phone',
        'note',
        'method',
        'coupon_code',
        'feeship_id',
        'address',
    ];
}
