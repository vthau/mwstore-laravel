<?php

namespace App\Services;

use App\Repositories\StatisticRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CommentRepository;
use App\Repositories\BrandRepository;
use App\Repositories\OrderRepository;

class StatisticService
{
    protected $statisticRepository;
    protected $userRepository;
    protected $productRepository;
    protected $couponRepository;
    protected $commentRepository;
    protected $brandRepository;
    protected $orderRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        CouponRepository $couponRepository,
        CommentRepository $commentRepository,
        BrandRepository $brandRepository,
        OrderRepository $orderRepository,
        StatisticRepository $statisticRepository
    ) {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->couponRepository = $couponRepository;
        $this->commentRepository = $commentRepository;
        $this->brandRepository = $brandRepository;
        $this->orderRepository = $orderRepository;
        $this->statisticRepository = $statisticRepository;
    }

    protected function handleResult($statistics)
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

    public function getAll()
    {
        $statistics = $this->statisticRepository->getAll();
        return $this->handleResult($statistics);
    }

    public function filterDate($data)
    {
        $statistics = $this->statisticRepository->filterDate($data);
        return $this->handleResult($statistics);
    }

    public function filterOrder($data)
    {
        $statistics = $this->statisticRepository->filterOrder($data);
        return $this->handleResult($statistics);
    }

    public function countGeneral()
    {
        $user = $this->userRepository->getCount();
        $product = $this->productRepository->getCount();
        $coupon = $this->couponRepository->getCount();
        $comment = $this->commentRepository->getCount();
        $brand = $this->brandRepository->getCount();
        $order = $this->orderRepository->getCount();

        return  [$brand, $product, $coupon, $user, $order, $comment];
    }
}
