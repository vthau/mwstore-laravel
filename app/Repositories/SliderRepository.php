<?php

namespace App\Repositories;

use App\Models\Slider;

class SliderRepository
{
    protected $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function getAll()
    {
        return $this->slider->with("product")->get();
    }

    public function getLimit()
    {
        return $this->slider->with(['product'])->latest('id')->take(10)->get();
    }

    public function save($data)
    {
        $slider = $this->slider->create($data->all());
        return $slider->fresh();
    }

    public function update($data)
    {
        $slider = $this->slider->find($data->id);

        if ($data->hasFile('image')) {
            $image = $slider->image;
            $slider->image = "";
            deleteImage($image, 'sliders');
        }
        $slider->fill($data->only(["name", "show_hide"]));
        $slider->save();

        return $slider->fresh();
    }

    public function delete($data)
    {
        return $this->slider->find($data->id)->delete();
    }
}
