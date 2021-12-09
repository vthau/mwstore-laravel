<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function gallery_product(Request $req)
    {
        $gallerys = Gallery::with("product")->where('product_id', $req->id)->get();

        return response()->json([
            "status" => "SUCCESS",
            "gallerys" => $gallerys,
        ]);
    }

    public function new_gallery(Request $req)
    {
        $files = $req->file('image');
        foreach ($files as $file) {
            $image = uploadImage($file, 'gallerys');
            $gallery = new Gallery;
            $gallery->product_id = $req->product_id;
            $gallery->image = $image;
            $gallery->save();
        }

        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function delete_gallery(Request $req)
    {
        Gallery::find($req->id)->delete();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }
}
