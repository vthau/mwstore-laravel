<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CouponService;
use Exception;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function use_coupon(Request $req)
    {
        try {
            $result = $this->couponService->useCoupon($req);
            return $this->successResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function all_coupon()
    {
        $coupons = $this->couponService->getAll();
        return $this->successResponse($coupons);
    }

    public function delete_coupon(Request $req)
    {
        try {
            $this->couponService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update_coupon(Request $req)
    {
        try {
            $this->couponService->update($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function new_coupon(Request $req)
    {
        try {
            $this->couponService->save($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function send_coupon(Request $req)
    {
        try {
            $this->couponService->sendCoupon($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function import_excel(Request $req)
    {
        try {
            $this->couponService->importExcel($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function export_excel()
    {
        return $this->couponService->exportExcel();
    }
}
