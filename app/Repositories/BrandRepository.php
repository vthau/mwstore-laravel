<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{
    protected $brand;


    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getCount()
    {
        return $this->brand->count();
    }

    public function getAllBrand()
    {
        return $this->brand->all();
    }

    public function updateOrSave($data)
    {
        $brand = $this->brand->updateOrCreate(['id' => $data->id], ['description' => $data->description, 'name' =>  $data->name]);
        return $brand->fresh();
    }

    public function delete($data)
    {
        return $this->brand->find($data->id)->delete();
    }
}
