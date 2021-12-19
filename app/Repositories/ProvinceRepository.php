<?php

namespace App\Repositories;

use App\Models\Province;

class ProvinceRepository
{
    protected $province;

    public function __construct(Province $province)
    {
        $this->province = $province;
    }

    public function getByCode($code)
    {
        return $this->province->where('province_code', $code)->first();
    }
}
