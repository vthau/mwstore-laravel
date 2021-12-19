<?php

namespace App\Repositories;

use App\Models\Shipping;

class ShippingRepository
{
    protected $shipping;

    public function __construct(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function save($data)
    {
        $shipping = new $this->shipping;
        $shipping->order_code = $data->order_code;
        $shipping->name = $data->name;
        $shipping->email = $data->email;
        $shipping->phone = $data->phone;
        $shipping->note = $data->note;
        $shipping->method = $data->method;
        $shipping->address = $data->address;
        $shipping->user_id = auth()->user()->id;
        $shipping->save();
        return $shipping->fresh();
    }
}
