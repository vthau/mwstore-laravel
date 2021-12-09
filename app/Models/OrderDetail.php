<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_code',
        'product_id',
        'product_name',
        'product_price',
        'product_quantity',
        'product_image',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_code', 'code');
    }
}
