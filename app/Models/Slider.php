<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'name',
        'product_id',
        'show_hide',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
