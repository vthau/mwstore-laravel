<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VisitorService;
use App\Exports\ExportExcelVisitor;
use Excel;
use Carbon\Carbon;

class VisitorController extends Controller
{
    protected $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function all_visitor()
    {
        $visitors = $this->visitorService->getAll();
        return $this->successResponse($visitors);
    }

    public function count_visitor()
    {
        $result = $this->visitorService->countVisitor();
        return $this->successResponse($result);
    }

    public function device_visitor()
    {
        $result = $this->visitorService->countDevice();
        return $this->successResponse($result);
    }

    public function export_excel()
    {
        return $this->visitorService->exportExcel();
    }
}
