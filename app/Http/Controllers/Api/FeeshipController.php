<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FeeshipService;
use Exception;

class FeeshipController extends Controller
{
    protected $feeshipService;

    public function __construct(FeeshipService $feeshipService)
    {
        $this->feeshipService = $feeshipService;
    }

    public function all_feeship()
    {
        $feeships = $this->feeshipService->getAll();
        return $this->successResponse($feeships);
    }

    public function new_feeship(Request $req)
    {
        try {
            $this->feeshipService->updateOrSave($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete_feeship(Request $req)
    {
        try {
            $this->feeshipService->delete($req);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
