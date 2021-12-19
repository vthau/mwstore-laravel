<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository
{
    protected $gallery;

    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    public function getById($data)
    {
        return $this->gallery->with("product")->where('product_id', $data->id)->get();
    }

    public function save($data)
    {
        $files = $data->file('image');
        if ($files) {
            foreach ($files as $file) {
                $image = uploadImage($file, 'gallerys');
                $gallery = new Gallery;
                $gallery->product_id = $data->product_id;
                $gallery->image = $image;
                $gallery->save();
            }
        }
    }

    public function delete($data)
    {
        return $this->gallery->find($data->id)->delete();
    }
}
