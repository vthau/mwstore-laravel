<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BrandService;
use Exception;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function get_all_brand()
    {
        $brands = $this->brandService->getAllBrand();
        return $this->successResponse($brands);
    }

    public function update_brand(Request $req)
    {
        try {
            $this->brandService->updateOrSave($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_brand(Request $req)
    {
        try {
            $this->brandService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function import_excel(Request $req)
    {
        try {
            $this->brandService->importExcel($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function export_excel()
    {
        return $this->brandService->exportExcel();
    }
}
