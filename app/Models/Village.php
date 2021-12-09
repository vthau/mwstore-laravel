<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public $timestamps = false;
    protected  $fillable = ['village_code', 'name', 'type', 'province_code'];
    protected $primaryKey = 'village_code';
    protected $table = 'village';

    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'province_code', 'province_code');
    }
}
