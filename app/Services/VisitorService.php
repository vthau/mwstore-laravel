<?php

namespace App\Services;

use App\Exports\ExportExcelVisitor;
use App\Repositories\VisitorRepository;
use Carbon\Carbon;
use Excel;

class VisitorService
{
    protected $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    public function getAll()
    {
        return $this->visitorRepository->getAll();
    }

    public function countVisitor()
    {
        $now_start = Carbon::now('Asia/Ho_Chi_Minh')->startOfDay()->format('Y-m-d H:i:s');
        $last_week = Carbon::now('Asia/Ho_Chi_Minh')->subWeek(1)->format('Y-m-d H:i:s');
        $last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m-d H:i:s');
        $last_year = Carbon::now('Asia/Ho_Chi_Minh')->subYear(1)->format('Y-m-d H:i:s');

        $today_count = $this->visitorRepository->countByDate($now_start);
        $week_count = $this->visitorRepository->countByDate($last_week);
        $month_count = $this->visitorRepository->countByDate($last_month);
        $year_count = $this->visitorRepository->countByDate($last_year);
        $all_count = $this->visitorRepository->count();

        return ["today" => $today_count, "week" => $week_count, "month" => $month_count, "year" => $year_count, "all" => $all_count];
    }

    public function countDevice()
    {
        $count_mobile = $this->visitorRepository->countByDevice("Mobile");
        $count_table = $this->visitorRepository->countByDevice("Tablet");
        $desktop = $this->visitorRepository->countByDevice("Desktop");

        return [$count_mobile, $count_table, $desktop];
    }

    public function exportExcel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelVisitor, 'visitor_' . $time . '.xlsx');
    }
}
