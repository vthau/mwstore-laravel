<?php

namespace App\Repositories;

use App\Models\OrderDetail;

class OrderDetailRepository
{
    protected $orderDetail;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function save($order_code)
    {
        $carts =  auth()->user()->carts()->where('checked', 1)->get();
        foreach ($carts as $cart) {
            $this->orderDetail->create([
                'order_code' => $order_code,
                'product_id' => $cart->product->id,
                'product_name' => $cart->product->name,
                'product_price' => $cart->product->price,
                'product_quantity' => $cart->quantity,
                'product_image' => $cart->product->image,
                'total_price' => $cart->price(),
            ]);
        }
    }
}
