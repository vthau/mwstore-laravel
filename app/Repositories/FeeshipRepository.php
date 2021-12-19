<?php

namespace App\Repositories;

use App\Models\Feeship;

class FeeshipRepository
{
    protected $feeship;

    public function __construct(Feeship $feeship)
    {
        $this->feeship = $feeship;
    }

    public function getAll()
    {
        return $this->feeship->with(["city", "province", "village"])->get();
    }

    public function getByCode($data)
    {
        return $this->feeship->where($data->all())->first();
    }

    public function getById($id)
    {
        return $this->feeship->find($id);
    }

    public function updateOrSave($data)
    {
        $feeship = $this->feeship->updateOrCreate([
            'city_code'   =>   $data->city_code,
            'province_code'   =>   $data->province_code,
            'village_code'   =>   $data->village_code,
        ], ['feeship' => $data->feeship]);
        return $feeship->fresh();
    }

    public function delete($data)
    {
        return $this->feeship->find($data->id)->delete();
    }
}
