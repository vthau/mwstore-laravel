<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class SliderController extends Controller
{
    public function get_slider()
    {
        $sliders = Slider::with(['product'])->latest('id')->take(10)->get();
        return $sliders;
    }

    public function all_slider()
    {
        $sliders = Slider::with("product")->get();
        return response()->json([
            "status" => "SUCCESS",
            "sliders" => $sliders,
        ]);
    }

    public function delete_slider(Request $req)
    {
        Slider::find($req->id)->delete();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function new_slider(Request $req)
    {
        $slider = new Slider;
        $slider->fill($req->all());
        $slider->save();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function update_slider(Request $req)
    {
        $slider = Slider::find($req->id);

        if ($req->hasFile('image')) {
            $image = $slider->image;
            $slider->image = "";
            deleteImage($image, 'sliders');
        }
        $slider->fill($req->only(["name", "show_hide"]));
        $slider->save();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }
}
