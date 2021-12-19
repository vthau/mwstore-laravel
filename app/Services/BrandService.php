<?php

namespace App\Services;

use App\Exports\ExportExcelBrand;
use App\Imports\ImportExcelBrand;
use App\Repositories\BrandRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Excel;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getCount()
    {
        return $this->brandRepository->getCount();
    }

    public function getAllBrand()
    {
        return $this->brandRepository->getAllBrand();
    }

    public function updateOrSave($data)
    {
        DB::beginTransaction();

        try {
            $brand = $this->brandRepository->updateOrSave($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception('FAIL');
        }

        DB::commit();

        return $brand;
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $brand = $this->brandRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception('FAIL');
        }

        DB::commit();

        return $brand;
    }

    public function importExcel($data)
    {
        try {
            $file = $data->file('file');
            return Excel::import(new ImportExcelBrand, $file);
        } catch (Exception $e) {
            throw new Exception('FAIL');
        }
    }

    public function exportExcel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelBrand, 'brand_' . $time . '.xlsx');
    }
}
