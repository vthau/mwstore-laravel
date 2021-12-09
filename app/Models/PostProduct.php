<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostProduct extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'description',
        'content',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
