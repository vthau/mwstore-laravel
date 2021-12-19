<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getCount()
    {
        return $this->order->count();
    }

    public function getAll()
    {
        $user_id = auth()->user()->id;
        return $this->order->with('user')
            ->where(['user_id' => $user_id, ['status', '<>', 3]])
            ->latest('id')->get();
    }

    public function getAllByAdmin()
    {
        return $this->order->with("user")->latest('id')->get();
    }

    public function getById($id)
    {
        return $this->order->with(['user', 'shipping', 'orderDetails', 'feeship', 'coupon'])->where(['id' => $id])->first();
    }

    public function getByCode($code)
    {
        return $this->order->with(['user', 'shipping', 'orderDetails', 'feeship', 'coupon'])->where(['code' => $code])->first();
    }

    public function getByPrint($print)
    {
        return $this->order->where(['code' => $print[1], "id" => $print[0], "user_id" => $print[2]])->first();
    }

    public function save($data, $total_price)
    {
        $order = new $this->order;
        $order->user_id = auth()->user()->id;
        $order->code = $data['order_code'];
        $order->feeship_id = $data['feeship_id'];
        $order->coupon_code = $data['coupon_code'];
        $order->status = 0;
        $order->total_order = $total_price;
        $order->save();
    }

    public function delete($code)
    {
        return $this->order->where('code', $code)->delete();
    }
}
