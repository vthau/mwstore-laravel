<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository
{
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function getCount()
    {
        return $this->coupon->count();
    }

    public function getAll()
    {
        return $this->coupon->all();
    }

    public function getById($id)
    {
        return $this->coupon->find($id);
    }

    public function getByCode($code)
    {
        return $this->coupon->where("code", $code)->first();
    }

    public function useCoupon($coupon_code)
    {
        $coupon = $this->coupon->where('code', $coupon_code)->first();
        $coupon->used = $coupon->used . "," . auth()->user()->id;
        $coupon->decrement('quantity');
        $coupon->save();
    }

    public function getByDate($code, $today)
    {
        return $this->coupon->where([['code', '=', $code], ['end_coupon', '>=', $today]])->first();
    }

    public function update($data)
    {
        return $this->coupon->where("code", $data->code)->update($data->all());
    }

    public function save($data)
    {
        return $this->coupon->create($data->all());
    }

    public function delete($data)
    {
        return $this->coupon->find($data->id)->delete();
    }
}
