<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Comment;
use Carbon\Carbon;

class StatisticController extends Controller
{

    private function handle_result($statistics)
    {
        $date = [];
        $sale = [];
        $profit = [];
        $quantity = [];
        $total = [];

        foreach ($statistics as $statistic) {
            $date[] = $statistic->order_date;
            $sale[] = $statistic->sales;
            $profit[] = $statistic->profit;
            $quantity[] = $statistic->quantity;
            $total[] = $statistic->total_order;
        }

        $result = ["date" => $date, "sale" => $sale, "profit" => $profit, "quantity" => $quantity, "total" => $total];
        return $result;
    }

    public function get_statistic()
    {
        $statistics = Statistic::all();
        $data = $this->handle_result($statistics);

        return response()->json([
            "status" => "SUCCESS",
            "data" => $data,
        ]);
    }

    public function filter_date(Request $req)
    {
        $statistics = Statistic::whereBetween('order_date', [$req->start_date, $req->end_date]);
        $result = $this->handle_result($statistics);
        return response()->json([
            "status" => "SUCCESS",
            "data" => $result,
        ]);
    }

    public function filter_other(Request $req)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $yesterday = Carbon::now('Asia/Ho_Chi_Minh')->subdays(1)->toDateString();
        $last_five_days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(5)->toDateString();
        $last_ten_days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(10)->toDateString();
        $last_week = Carbon::now('Asia/Ho_Chi_Minh')->subWeek(1)->toDateString();
        $last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->toDateString();
        $last_year = Carbon::now('Asia/Ho_Chi_Minh')->subYear(1)->toDateString();

        if ($req->date_filter === 'TODAY') {
            $statistics = Statistic::whereBetween('order_date', [$now, $now]);
        } elseif ($req->date_filter == 'YESTERDAY') {
            $statistics = Statistic::whereBetween('order_date', [$yesterday, $now]);
        } elseif ($req->date_filter == 'LAST_FIVE_DAYS') {
            $statistics = Statistic::whereBetween('order_date', [$last_five_days, $now]);
        } elseif ($req->date_filter == 'LAST_TEN_DAYS') {
            $statistics = Statistic::whereBetween('order_date', [$last_ten_days, $now]);
        } elseif ($req->date_filter == 'LAST_ONE_WEEK') {
            $statistics = Statistic::whereBetween('order_date', [$last_week, $now]);
        } elseif ($req->date_filter == 'LAST_ONE_MONTH') {
            $statistics = Statistic::whereBetween('order_date', [$last_month, $now]);
        } elseif ($req->date_filter == 'LAST_ONE_YEAR') {
            $statistics = Statistic::whereBetween('order_date', [$last_year, $now]);
        }
        $statistics = $statistics->orderBy('order_date', 'ASC')->get();

        $result = $this->handle_result($statistics);
        return response()->json([
            "status" => "SUCCESS",
            "data" => $result,
        ]);
    }

    public function count_general()
    {
        $user = User::all()->count();
        $product = Product::all()->count();
        $coupon = Coupon::all()->count();
        $comment = Comment::all()->count();
        $brand = Brand::all()->count();
        $order = Order::all()->count();

        return response()->json([
            "status" => "SUCCESS",
            "data" => [$brand, $product, $coupon, $user, $order, $comment],
        ]);
    }
}
