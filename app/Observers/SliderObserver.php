<?php

namespace App\Observers;

use App\Models\Slider;

class SliderObserver
{
    public function creating(Slider $slider)
    {
        $file = request()->file('image');
        $image = uploadImage($file, 'sliders');;
        $slider->image = $image;
    }

    public function updating(Slider $slider)
    {
        if ($file = request()->file('image')) {
            $image = uploadImage($file, 'sliders');
            $slider->image = $image;
        }
    }

    public function deleting(Slider $slider)
    {
        deleteImage($slider->image, 'sliders');
    }
}
