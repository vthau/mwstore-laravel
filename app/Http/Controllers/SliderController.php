<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Models\Product;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.list')->with(compact(['sliders']));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.slider.add')->with(compact(['products']));
    }

    public function store(SliderRequest $req)
    {
        $slider = new Slider;
        $slider->fill($req->all());
        $slider->save();
        return redirect()->route('slider.index');
    }

    public function edit(Slider $slider)
    {
        $products = Product::all();
        return view('admin.slider.edit')->with(compact(['products', 'slider']));
    }

    public function update(SliderRequest $req, $id)
    {
        $slider = Slider::find($id);
        if ($req->hasFile('image')) {
            deleteImage($slider->image, 'sliders');
        }
        $slider->fill($req->all());
        $slider->save();
        return redirect()->route('slider.index');
    }

    public function destroy($id)
    {
        Slider::find($id)->delete();
        return redirect()->route('slider.index');
    }
}
