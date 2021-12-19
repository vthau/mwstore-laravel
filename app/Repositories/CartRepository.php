<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getByUser()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        $totalPrice = $this->cart->totalPriceChecked();
        return ["carts" => $carts, "total_price" => $totalPrice];
    }

    public function getByChecked()
    {
        $carts = auth()->user()->carts()->with('product')->where("checked", 1)->get();
        $totalPrice = $this->cart->totalPriceChecked();
        return ["carts" => $carts, "total_price" => $totalPrice];
    }

    public function getTotalPriceChecked()
    {
        return $this->cart->totalPriceChecked();
    }

    public function checked($data)
    {
        $check = 0;
        $user_id = auth()->user()->id;
        if ($data->type === "CHECK") $check = 1;

        return $this->cart->where(['user_id' => $user_id, 'id' => $data->id])->first()->update(['checked' => $check]);
    }

    public function updateOrSave($data)
    {
        return $this->cart->updateOrStore($data);
    }

    public function delete($data)
    {
        $user_id = auth()->user()->id;
        return $this->cart->where(['user_id' => $user_id, 'id' => $data->id])->delete();
    }

    public function deleteChecked()
    {
        $user_id = auth()->user()->id;
        return $this->cart->where('user_id', $user_id)->where('checked', 1)->delete();
    }
}
