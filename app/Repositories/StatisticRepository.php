<?php

namespace App\Repositories;

use App\Models\Statistic;
use Carbon\Carbon;

class StatisticRepository
{
    protected $statistic;

    public function __construct(Statistic $statistic)
    {
        $this->statistic = $statistic;
    }

    public function getByDate($date)
    {
        return $this->statistic->where("order_date", $date)->first();
    }

    public function filterDate($data)
    {
        return $this->statistic->whereBetween('order_date', [$data->start_date, $data->end_date])->get();
    }

    public function filterOrder($data)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $yesterday = Carbon::now('Asia/Ho_Chi_Minh')->subdays(1)->toDateString();
        $last_five_days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(5)->toDateString();
        $last_ten_days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(10)->toDateString();
        $last_week = Carbon::now('Asia/Ho_Chi_Minh')->subWeek(1)->toDateString();
        $last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->toDateString();
        $last_year = Carbon::now('Asia/Ho_Chi_Minh')->subYear(1)->toDateString();

        if ($data->date_filter === 'TODAY') {
            $statistics = Statistic::whereBetween('order_date', [$now, $now]);
        } elseif ($data->date_filter == 'YESTERDAY') {
            $statistics = Statistic::whereBetween('order_date', [$yesterday, $now]);
        } elseif ($data->date_filter == 'LAST_FIVE_DAYS') {
            $statistics = Statistic::whereBetween('order_date', [$last_five_days, $now]);
        } elseif ($data->date_filter == 'LAST_TEN_DAYS') {
            $statistics = Statistic::whereBetween('order_date', [$last_ten_days, $now]);
        } elseif ($data->date_filter == 'LAST_ONE_WEEK') {
            $statistics = Statistic::whereBetween('order_date', [$last_week, $now]);
        } elseif ($data->date_filter == 'LAST_ONE_MONTH') {
            $statistics = Statistic::whereBetween('order_date', [$last_month, $now]);
        } elseif ($data->date_filter == 'LAST_ONE_YEAR') {
            $statistics = Statistic::whereBetween('order_date', [$last_year, $now]);
        }
        return $statistics->orderBy('order_date', 'ASC')->get();
    }

    public function getAll()
    {
        return $this->statistic->all();
    }

    public function updateOrSave($order_date, $sales, $profit, $quantity, $total_order)
    {
        $statistic = $this->statistic->where("order_date", $order_date)->first();

        if ($statistic) {
            $statistic->sales = $statistic->sales + $sales;
            $statistic->profit =  $statistic->profit + $profit;
            $statistic->quantity =  $statistic->quantity + $quantity;
            $statistic->total_order = $statistic->total_order + $total_order;
            $statistic->save();
        } else {
            $statistic = new $this->statistic;
            $statistic->order_date = $order_date;
            $statistic->sales = $sales;
            $statistic->profit =  $profit;
            $statistic->quantity =  $quantity;
            $statistic->total_order = $total_order;
            $statistic->save();
        }
    }
}
