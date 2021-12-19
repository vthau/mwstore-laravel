<?php

namespace App\Repositories;

use App\Models\Unpaid;

class UnpaidRepository
{
    protected $unpaid;

    public function __construct(Unpaid $unpaid)
    {
        $this->unpaid = $unpaid;
    }

    public function getByCode($data)
    {
        return $this->unpaid->where('order_code', $data->vnp_TxnRef)
            ->orWhere("order_code", $data->orderId)->first();
    }

    public function save($data)
    {
        return $this->unpaid->create($data);
    }
}
