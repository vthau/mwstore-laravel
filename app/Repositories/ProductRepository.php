<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    protected $product;


    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getCount()
    {
        return $this->product->count();
    }

    public function searchProduct($data)
    {
        $products = $this->product->query()->with('comments')
            ->where('name', 'like',  '%' . $data->keyword . '%')
            ->where('price', '>=', $data->min_price)
            ->where('price', '<=', $data->max_price);

        if ($data->brand !== null) {
            $products->where('brand_id', $data->brand);
        }
        if ($data->price !== null) {
            $products->orderBy('price', (string)$data->price);
        }
        if ($data->view !== null) {
            $products->orderBy('visit', (string)$data->view);
        }

        return $products->get();
    }

    public function getBySlug($slug)
    {
        return $this->product->with(['gallerys', 'post'])->where('slug', $slug)->first();
    }

    public function getByName($name)
    {
        return $this->product->where("name", $name)->first();
    }

    public function getByBrand($brand_id)
    {
        return $this->product->with('comments')->where('brand_id', $brand_id)->latest('id')->take(8)->get();
    }

    public function getProductFeather()
    {
        return $this->product->with('comments')->where('feather', 1)->latest('id')->take(12)->get();
    }

    public function getProductNew()
    {
        return $this->product->with('comments')->latest('id')->take(15)->get();
    }

    public function getProductTop()
    {
        return $this->product->orderBy("visit", "DESC")->take(15)->get();
    }

    public function getProductNoPost()
    {
        return $this->product->doesnthave('post')->with("brand")->latest('id')->get();
    }

    public function getProductCrawl($data)
    {
        return $this->product->getProduct($data->brand);
    }

    public function getAllProduct()
    {
        return $this->product->with(["brand"])->latest('id')->get();
    }

    public function getProductPaginate()
    {
        return $this->product->with('comments')->paginate(4);
    }

    public function updateView($slug)
    {
        return $this->product->where('slug', $slug)->first()->increment('visit');
    }

    public function save($data)
    {
        $product = new $this->product;
        $product->fill($data->all());
        $product->quantity = 100;
        $product->save();
        return $product->fresh();
    }

    public function saveProductCrawl($data)
    {
        $product = new $this->product;
        $product->fill($data->all());
        $product->quantity = 100;
        $product->feather = 1;
        $product->save();
        return $product->fresh();
    }

    public function update($data)
    {
        $product = $this->product->find($data->id);

        if ($data->hasFile('image')) {
            $image = $product->image;
            $product->image = "";
            deleteImage($image, 'product');
        }

        $product->fill($data->all());

        $product->update();

        return $product;
    }


    public function delete($data)
    {
        return $this->product->find($data->id)->delete();
    }
}
