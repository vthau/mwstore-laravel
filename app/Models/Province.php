<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;
    protected  $fillable = ['province_code', 'name', 'type', 'city_code'];
    protected $primaryKey = 'province_code';
    protected $table = 'province';

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_code', 'city_code');
    }

    public function villages()
    {
        return $this->hasMany('App\Models\Village', 'province_code', 'province_code');
    }
}
