<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'feeship_id',
        'coupon_code',
        'status',
        'total_order',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function feeship()
    {
        return $this->belongsTo('App\Models\Feeship', 'feeship_id');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon', 'coupon_code', 'code');
    }

    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping', 'order_code', 'code');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_code', 'code');
    }

    //HAS tham so thu nhat la cua thang Belong, tham so thu 2 la cua thang Has
    //belong to, tham so thu la cua thang Belong, tham so thu 2 la cua thang Has
}
