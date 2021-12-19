<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    protected $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getAll()
    {
        return $this->city->with('provinces.villages')->get();
    }

    public function getByCode($code)
    {
        return $this->city->where('city_code', $code)->first();
    }
}
