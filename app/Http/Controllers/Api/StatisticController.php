<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StatisticService;

class StatisticController extends Controller
{
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function get_statistic()
    {
        $statistics = $this->statisticService->getAll();
        return $this->successResponse($statistics);
    }

    public function filter_date(Request $req)
    {
        $statistics = $this->statisticService->filterDate($req);
        return $this->successResponse($statistics);
    }

    public function filter_other(Request $req)
    {
        $statistics = $this->statisticService->filterOrder($req);
        return $this->successResponse($statistics);
    }

    public function count_general()
    {
        $statistics = $this->statisticService->countGeneral();
        return $this->successResponse($statistics);
    }
}
