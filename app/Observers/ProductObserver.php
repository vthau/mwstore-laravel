<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function creating(Product $product)
    {
        if ($file = request()->file('image')) {
            $image = uploadImage($file, 'products');
        }
        if ($src = request()->src) {
            $image = downloadImage($src, 'products');
        }
        $product->image = $image;
        $product->slug = Str::slug(request()->name);
    }

    public function updating(Product $product)
    {
        if ($file = request()->file('image')) {
            $image = uploadImage($file, 'products');
            $product->image = $image;
        }
        $product->slug =  Str::slug(request()->name);
    }

    public function deleting(Product $product)
    {
        deleteImage($product->image, 'products');
        $gallerys = $product->gallerys;
        $sliders = $product->sliders;
        foreach ($gallerys as $gallery) {
            $gallery->delete();
        }
        foreach ($sliders as $sliders) {
            $sliders->delete();
        }
    }
}
