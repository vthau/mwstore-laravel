<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'brand_id');
    }

    public static function sort($brand_ids)
    {
        foreach ($brand_ids as $key =>  $brand_id) {
            Brand::where('id', $brand_id)->update(['brand_order' =>  $key]);
        }
    }
}
