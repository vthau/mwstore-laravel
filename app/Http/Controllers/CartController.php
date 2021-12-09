<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $carts = [];
        if (Auth::check()) {
            $carts = Auth::user()->carts;
        }
        return view('user.cart')->with(compact(['carts']));
    }

    public function store(CartRequest $req)
    {
        Cart::updateOrStore($req);
        return redirect()->route('cart.index');
    }

    public function update(CartRequest $req)
    {
        Cart::updateOrStore($req);
    }

    public function delete(Request $req)
    {
        Cart::destroy($req->id);
    }
}
