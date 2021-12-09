<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false;
    protected  $fillable = ['city_code', 'province_code', 'village_code', 'feeship'];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_code', 'city_code');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'province_code', 'province_code');
    }

    public function village()
    {
        return $this->belongsTo('App\Models\Village', 'village_code', 'village_code');
    }

    public static function getFeeshipJson()
    {
        $feeships = Feeship::latest('id')->get();

        $res = [];
        foreach ($feeships as $feeship) {
            $tmp = [];
            $tmp['city'] = $feeship->city->name;
            $tmp['province'] = $feeship->province->name;
            $tmp['village'] = $feeship->village->name;
            $tmp['feeship'] = $feeship->feeship;
            $tmp['id'] = $feeship->id;
            $res[] = $tmp;
        }
        return $res;
    }
}
