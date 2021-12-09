<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'code',
        'quantity',
        'percent',
        'start_coupon',
        'end_coupon',
        'status',
    ];
}
