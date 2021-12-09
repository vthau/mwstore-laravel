<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Cart;

class CartController extends Controller
{

    public function store(Request $req)
    {
        Cart::updateOrStore($req);
        Activity::addCart();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function get_cart()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        $totalPrice = Cart::totalPriceChecked();
        if ($carts) {
            return response()->json([
                "status" => "SUCCESS",
                "carts" => $carts,
                "total_price" => $totalPrice,
            ]);
        }

        return $carts;
    }

    public function get_cart_checked()
    {
        $carts = auth()->user()->carts()->with('product')->where("checked", 1)->get();
        $totalPrice = Cart::totalPriceChecked();
        if ($carts) {
            return response()->json([
                "status" => "SUCCESS",
                "carts" => $carts,
                "total_price" => $totalPrice,
            ]);
        }

        return $carts;
    }

    public function checked(Request $req)
    {
        $user_id = auth()->user()->id;
        $cart = Cart::where(['user_id' => $user_id, 'id' => $req->id])->first();
        if ($cart) {
            if ($req->type === "CHECK") {
                $cart->checked = 1;
            } else {
                $cart->checked = 0;
            }

            $cart->save();
            Activity::updateCart();
            return response()->json([
                "status" => "SUCCESS",
            ]);
        }

        return $cart;
    }

    public function delete(Request $req)
    {
        $user_id = auth()->user()->id;
        Cart::where(['user_id' => $user_id, 'id' => $req->id])->delete();
        Activity::deleteCart();
        return response()->json([
            "status"    =>   "SUCCESS"
        ]);
    }
}
