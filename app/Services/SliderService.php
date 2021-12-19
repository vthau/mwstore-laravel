<?php

namespace App\Services;

use App\Repositories\SliderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SliderService
{
    protected $sliderRepository;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    public function getAll()
    {
        return $this->sliderRepository->getAll();
    }

    public function getLimit()
    {
        return $this->sliderRepository->getLimit();
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $brand = $this->sliderRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();

        return $brand;
    }

    public function update($data)
    {
        DB::beginTransaction();

        try {
            $brand = $this->sliderRepository->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();

        return $brand;
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $brand = $this->sliderRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception('FAIL');
        }

        DB::commit();

        return $brand;
    }
}
