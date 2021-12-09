<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostProduct;

class PostProductController extends Controller
{
    public function all_post()
    {
        $posts = PostProduct::with("product")->get();
        return response()->json([
            "status" => "SUCCESS",
            "posts" => $posts,
        ]);
    }

    public function get_post(Request $req)
    {
        $post = PostProduct::with("product")->find($req)->first();
        if ($post) {
            return response()->json([
                "status" => "SUCCESS",
                "post" => $post,
            ]);
        }
        return $post;
    }

    public function update_post(Request $req)
    {
        PostProduct::updateOrCreate([
            'product_id'   =>   $req->product_id,
        ], $req->only("title", "content"));
        return response()->json([
            'status' => "SUCCESS",
        ]);
    }

    public function delete_post(Request $req)
    {
        PostProduct::destroy($req->id);
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }
}
