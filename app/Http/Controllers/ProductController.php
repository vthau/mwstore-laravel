<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\GalleryRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\Brand;
use App\Models\Comment;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand'])->get();
        return view('admin.product.list')->with(compact(['products']));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.product.add')->with(compact(['brands']));
    }

    public function store(ProductRequest $req)
    {
        $product = new Product;
        $product->fill($req->all());
        $product->save();
        return redirect()->route('product.index');
    }

    public function detail($slug)
    {
        $product = Product::with(['gallerys', 'post'])->where('slug', $slug)->first();
        if (!$product) {
            return abort(404);
        }
        $product->increment('visit');
        $gallerys = $product->gallerys;
        $post = $product->post;
        $product_brands = $product->productRelated();
        $comments = Comment::with(['user'])->where([
            'product_id' => $product->id,
            'status' => 1,
        ])->latest('id')->take(15)->get();

        $your_comment = [];
        if (Auth::check()) {
            $your_comment = Comment::where([
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,
            ])->first();
        }

        return view('user.product')->with(compact(['product', 'product_brands', 'your_comment', 'comments', 'gallerys', 'post']));
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        return view('admin.product.edit')->with(compact(['product', 'brands']));
    }

    public function update(ProductRequest $req, $id)
    {
        $product = Product::find($id);
        if ($req->hasFile('image')) {
            deleteImage($product->image, 'products');
        }
        $product->fill($req->all());
        $product->save();

        return redirect()->route('product.index');
    }

    public function reference()
    {
        return view('admin.product.reference');
    }

    private function generator_HTML($products)
    {
        if (!$products) return '';
        $xhtml = "";
        foreach ($products as $product) {
            $xhtml .= '<div class="product-item">
                            <div class="over-add">
                                <div class="btn-add" data-brand="' . $product["brand"] . '" data-name="' . $product["name"] . '" data-price="' . $product["price"] . '" data-desc="' . $product["desc"] . '" data-src="' . $product["image"] . '">Thêm vào</div>
                            </div>
                            <div class="box-product-img">
                                <img src="' . $product["image"] . '" alt="" class="product-img" />
                            </div>
                            <div class="box-product-info">
                                <p class="product-info product-name">' . $product["name"] . '</p>
                                <p class="product-info product-price">' . $product["price"] . '</p>
                                <p class="product-info product-desc">' . $product["desc"] . '</p>
                            </div>
						</div>';
        }
        return $xhtml;
    }

    public function get_product_crawl(Request $req)
    {
        $products = Product::getProduct($req->brand);
        echo $this->generator_HTML($products);
    }

    public function add_product_crawl(Request $req)
    {
        $product = new Product;
        $product->fill($req->all());
        $product->quantity = 100;
        $product->feather = 1;
        $product->save();
    }

    public function product_gallery($id)
    {
        $gallerys = Gallery::where('product_id', $id)->get();
        $product = Product::findOrFail($id);
        return view('admin.product.gallery')->with(compact(['gallerys', 'product']));
    }

    public function product_gallery_store(GalleryRequest $req, $product_id)
    {
        $files = $req->file('image');
        foreach ($files as $file) {
            $image = uploadImage($file, 'gallerys');
            $gallery = new Gallery;
            $gallery->product_id = $product_id;
            $gallery->image = $image;
            $gallery->save();
        }

        return back();
    }

    public function delete_gallery($id)
    {
        Gallery::find($id)->delete();
        return back();
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return \redirect()->route('product.index');
    }
}
