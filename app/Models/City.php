<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    protected  $fillable = ['city_code', 'name', 'type'];
    protected $primaryKey = 'city_code';
    protected $table = 'city';

    public function provinces()
    {
        return $this->hasMany('App\Models\Province', 'city_code', 'city_code');
    }
}
