<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'image',
        'brand_id',
        'description',
        'feather',
    ];

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function sliders()
    {
        return $this->hasMany('App\Models\Slider', 'product_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'product_id')->where('status', 1);
    }

    public function carts()
    {
        return $this->belongsToMany('App\Models\Cart', 'product_id');
    }

    public function post()
    {
        return $this->hasOne('App\Models\PostProduct', 'product_id');
    }

    public function gallerys()
    {
        return $this->hasMany('App\Models\Gallery', 'product_id');
    }

    public function star()
    {
        return $this->comments()->where('status', 1)->avg('star');
    }

    public function productRelated()
    {
        return Product::where('brand_id', $this->brand_id)->latest('id')->take(15)->get();
    }

    public static function getProduct($brand_name)
    {
        $brand =  Brand::firstOrCreate(
            ['name' => ucfirst($brand_name)],
            ['description' => ucfirst($brand_name)]
        );

        $brand_id = $brand->id;

        function getPrice($str)
        {
            $result = "";
            $n = strlen($str) - 5;
            for ($i = 0; $i < $n; $i++) {
                if ($str[$i] >= "0" && $str[$i] <= "9") {
                    $result .= $str[$i];
                }
            }
            return trim($result);
        }

        if ($brand !== "") {
            $html =  file_get_html("https://www.thegioididong.com/dtdd-" . $brand_name);
            $dataProducts = $html->find("ul.listproduct li.item.ajaxed");
            $products = [];

            for ($i = 0; $i < count($dataProducts); $i++) {
                $product = [];
                $product["brand"] = $brand_id;
                $product["name"] = trim($dataProducts[$i]->find("a h3", 0)->innertext);
                $product["price"] = getPrice(str_replace(".", "",  $dataProducts[$i]->find("a strong.price", 0)->innertext));
                $product["desc"] = trim($dataProducts[$i]->find("div.utility p", 0)->innertext . " " . $dataProducts[$i]->find("div.utility p", 1)->innertext . " " . $dataProducts[$i]->find("div.utility p", 2)->innertext);
                $product["image"] = trim($dataProducts[$i]->find("div.item-img img.lazyload", 0)->{"data-src"});
                $products[] = $product;
            }

            return $products;
        }
    }
}
