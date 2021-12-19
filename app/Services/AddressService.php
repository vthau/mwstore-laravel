<?php

namespace App\Services;

use App\Repositories\FeeshipRepository;
use App\Repositories\CityRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\VillageRepository;

class AddressService
{
    protected $feeshipRepository;
    protected $cityRepository;
    protected $provinceRepository;
    protected $villageRepository;

    public function __construct(FeeshipRepository $feeshipRepository, CityRepository $cityRepository, ProvinceRepository $provinceRepository, VillageRepository $villageRepository)
    {
        $this->feeshipRepository = $feeshipRepository;
        $this->cityRepository = $cityRepository;
        $this->provinceRepository = $provinceRepository;
        $this->villageRepository = $villageRepository;
    }

    protected function getDetailAddress($data)
    {
        $city = $this->cityRepository->getByCode($data->city_code);
        $province = $this->provinceRepository->getByCode($data->province_code);
        $village = $this->villageRepository->getByCode($data->village_code);
        return $city->name . ", " . $province->name . ", " . $village->name;
    }

    public function getAll()
    {
        return $this->cityRepository->getAll();
    }

    public function calcFeeship($data)
    {
        $feeship = $this->feeshipRepository->getByCode($data);
        $address = $this->getDetailAddress($data);

        if (!$feeship) {
            return ['feeship' => '25000', 'feeship_id' =>  'NO', 'address' => $address];
        }
        return ['feeship' => $feeship->feeship, 'feeship_id' =>  $feeship->id, 'address' => $address];
    }
}
