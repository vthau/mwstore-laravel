<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\PostProduct;
use App\Models\Product;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostProduct::all();
        return view('admin.post.list')->with(compact(['posts']));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.post.add')->with(compact(['products']));
    }

    public function store(PostRequest $req)
    {
        $post = new PostProduct;
        $post->fill($req->all());
        $post->save();
        return redirect()->route('post.index');
    }

    public function edit(PostProduct $post)
    {
        return view('admin.post.edit')->with(compact(['post']));
    }

    public function update(PostRequest $req, $id)
    {
        $post = PostProduct::find($id);
        $post->fill($req->all());
        $post->save();
        return redirect()->route('post.index');
    }

    public function destroy($id)
    {
        PostProduct::destroy($id);
        return \redirect()->route('post.index');
    }
}
