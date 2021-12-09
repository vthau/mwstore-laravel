<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::oldest('brand_order')->get();
        return view('admin.brand.list')->with(compact(['brands']));
    }

    public function create()
    {
        return view('admin.brand.add');
    }

    public function store(BrandRequest $req)
    {
        $brand = new Brand;
        $brand->fill($req->all());
        $brand->save();

        return redirect()->route('brand.index');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit')->with(compact(['brand']));
    }

    public function update(BrandRequest $req, $id)
    {
        Brand::where('id', $id)->update($req->only('name', 'description'));
        return redirect()->route('brand.index');
    }

    public function sort(Request $req)
    {
        Brand::sort($req->page_id_array);
    }

    public function destroy($id)
    {
        Brand::destroy($id);
        return \redirect()->route('brand.index');
    }
}
