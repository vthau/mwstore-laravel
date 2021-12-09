<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = cache()->remember('sliders', 600, function () {
            return Slider::with(['product'])->latest('id')->take(10)->get();
        });
        $product_feathers = cache()->remember('product_feathers', 600, function () {
            return Product::where('feather', 1)->latest('id')->take(15)->get();
        });
        $product_news = cache()->remember('product_news', 600, function () {
            return  Product::latest('id')->take(15)->get();
        });
        $brands = cache()->remember('brands', 600, function () {
            return Brand::with(['products'])->latest('id')->get();
        });

        return view('user.index')->with(compact(['brands', 'sliders', 'product_feathers', 'product_news']));
    }
}
