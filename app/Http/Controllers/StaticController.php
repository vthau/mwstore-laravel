<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\User;
use App\Models\PostProduct;
use App\Models\Comment;
use App\Models\Visitor;


class StaticController extends Controller
{
    public function index()
    {
        $order_count = Order::count();
        $brand_count = Brand::count();
        $comment_count = Comment::count();
        $user_count = User::count();
        $product_count = Product::count();
        $slider_count = Slider::count();
        $post_count = PostProduct::count();
        $visit_count = Visitor::all()->sum('visit');

        return view('admin.static')->with(compact(['order_count', 'brand_count', 'comment_count', 'user_count', 'product_count', 'slider_count', 'post_count', 'visit_count']));
    }
}
