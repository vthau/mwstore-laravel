<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function search(Request $req)
    {
        $keyword = $req->keyword;
        $keyword == "" ? $products = [] : $products = Product::where('name', 'like', $keyword . '%')->get();
        return view('user.search')->with(compact(['keyword', 'products']));
    }

    public function search_live(Request $req)
    {
        $products = Product::where('name', 'like', '%' . $req->keyword . '%')->get();
        return response()->json($products);
    }
}
