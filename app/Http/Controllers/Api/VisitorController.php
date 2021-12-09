<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Exports\ExportExcelVisitor;
use Excel;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function all_visitor()
    {
        $visitors = Visitor::all();

        return response()->json([
            "status" => "SUCCESS",
            "visitors" => $visitors,
        ]);
    }

    public function export_excel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelVisitor, 'visitor_' . $time . '.xlsx');
    }

    public function count_visitor()
    {
        $now_start = Carbon::now('Asia/Ho_Chi_Minh')->startOfDay()->format('Y-m-d H:i:s');
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $last_week = Carbon::now('Asia/Ho_Chi_Minh')->subWeek(1)->format('Y-m-d H:i:s');
        $last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m-d H:i:s');
        $last_year = Carbon::now('Asia/Ho_Chi_Minh')->subYear(1)->format('Y-m-d H:i:s');

        $today_count = Visitor::whereBetween('time', [$now_start, $now])->count();
        $week_count = Visitor::whereBetween('time', [$last_week, $now])->count();
        $month_count = Visitor::whereBetween('time', [$last_month, $now])->count();
        $year_count = Visitor::whereBetween('time', [$last_year, $now])->count();
        $all_count = Visitor::count();

        return response()->json([
            "status" => "SUCCESS",
            "data" => ["today" => $today_count, "week" => $week_count, "month" => $month_count, "year" => $year_count, "all" => $all_count],
        ]);
    }

    public function device_visitor()
    {
        $count_mobile = Visitor::where("device", "Mobile")->count();
        $count_table = Visitor::where("device", "Tablet")->count();
        $desktop = Visitor::where("device", "Desktop")->count();

        return response()->json(["status" => "SUCCESS", "data" => [$count_mobile, $count_table, $desktop]]);
    }
}
