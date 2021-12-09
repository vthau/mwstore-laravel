<?php

namespace App\Observers;

use App\Models\Gallery;

class GalleryObserver
{
    public function deleting(Gallery $gallery)
    {
        deleteImage($gallery->image, 'gallerys');
    }
}
