<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slider;

class ProductController extends Controller
{
    public function get_product($slug)
    {
        $product = Product::with(['gallerys', 'post'])->where('slug', $slug)->first();

        if ($product) {
            $product['star'] = $product->star();

            Activity::viewProduct();
            return response()->json([
                'status' => "SUCCESS",
                'product' => $product,
            ]);
        }

        return $product;
    }

    public function get_product_feather()
    {
        $product_feathers =  Product::with('comments')->where('feather', 1)->latest('id')->take(15)->get();

        foreach ($product_feathers as $product_feather) {
            $star = $product_feather->star();
            if (!$star) $star = 0;
            $product_feather['star'] = $star;
        }

        return $product_feathers;
    }

    public function get_product_view()
    {
        $products = Product::orderBy("visit", "DESC")->take(15)->get();
        return $products;
    }

    public function get_product_new()
    {
        $product_news =  Product::with('comments')->latest('id')->take(15)->get();

        foreach ($product_news as $product_new) {
            $star = $product_new->star();
            if (!$star) $star = 0;
            $product_new['star'] = $star;
        }

        return $product_news;
    }

    public function get_product_more()
    {
        $product_mores =  Product::with('comments')->paginate(4);

        foreach ($product_mores as $product_more) {
            $star = $product_more->star();
            if (!$star) $star = 0;
            $product_more['star'] = $star;
        }

        return $product_mores;
    }

    public function get_product_brand($brand_id)
    {
        $product_brands =  Product::with('comments')->where('brand_id', $brand_id)->latest('id')->take(8)->get();

        if ($product_brands) {
            foreach ($product_brands as $product_brand) {
                $star = $product_brand->star();
                if (!$star) $star = 0;
                $product_brand['star'] = $star;
            }

            return response()->json([
                'status' => "SUCCESS",
                'products' => $product_brands,
            ]);
        }


        return $product_brands;
    }

    public function update_view_product($slug)
    {
        Product::where('slug', $slug)->first()->increment('visit');
    }

    public function search(Request $req)
    {
        $products = Product::query()->with('comments')
            ->where('name', 'like',  '%' . $req->keyword . '%')
            ->where('price', '>=', $req->min_price)
            ->where('price', '<=', $req->max_price);

        if ($req->brand !== null) {
            $products->where('brand_id', $req->brand);
        }
        if ($req->price !== null) {
            $products->orderBy('price', (string)$req->price);
        }
        if ($req->view !== null) {
            $products->orderBy('visit', (string)$req->view);
        }

        $products =  $products->get();

        if ($products) {
            foreach ($products as $product) {
                $star = $product->star();
                if (!$star) $star = 0;
                $product['star'] = $star;
            }

            Activity::searchProduct();
            return response()->json([
                'status' => "SUCCESS",
                'products' => $products,
            ]);
        }

        return $products;
    }

    public function all_product()
    {
        $products = Product::with("brand")->latest('id')->get();
        return response()->json([
            "status" => "SUCCESS",
            "products" => $products,
        ]);
    }

    public function product_not_post()
    {
        $products = Product::doesnthave('post')->with("brand")->latest('id')->get();
        return response()->json([
            "status" => "SUCCESS",
            "products" => $products,
        ]);
    }

    public function top_product()
    {
        $products = Product::orderBy("visit", "DESC")->take(10)->latest('id')->get();
        return response()->json([
            "status" => "SUCCESS",
            "data" => $products,
        ]);
    }

    public function new_product(Request $req)
    {
        $product = new Product;
        $product->fill($req->all());
        $product->quantity = 100;
        $product->save();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function update_product(Request $req)
    {
        $product = Product::find($req->id);

        if ($req->hasFile('image')) {
            $image = $product->image;
            $product->image = "";
            deleteImage($image, 'product');
        }
        $product->fill($req->all());
        $product->save();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function product_crawl(Request $req)
    {
        $products = Product::getProduct($req->brand);
        return response()->json(["status" => "SUCCESS", "data" => $products]);
    }

    public function add_product_crawl(Request $req)
    {
        $product = Product::where("name", $req->name)->first();
        if ($product) {
            return response()->json(["status" => "PRODUCT_EXIST"]);
        }
        $product = new Product;
        $product->fill($req->all());
        $product->quantity = 100;
        $product->feather = 1;
        $product->save();
        return response()->json(["status" => "SUCCESS"]);
    }

    public function delete_product(Request $req)
    {
        Product::find($req->id)->delete();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }
}
