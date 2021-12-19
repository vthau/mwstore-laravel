<?php

namespace App\Repositories;

use App\Models\Village;

class VillageRepository
{
    protected $village;

    public function __construct(Village $village)
    {
        $this->village = $village;
    }

    public function getByCode($code)
    {
        return $this->village->where('village_code', $code)->first();
    }
}
