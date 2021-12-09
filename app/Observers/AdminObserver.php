<?php

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{

    public function creating(Admin $admin)
    {
        if ($file = request()->file('image')) {
            $image = uploadImage($file, 'admins/avatars');
            $admin->image = $image;
        }
    }

    public function updating(Admin $admin)
    {
        if ($file = request()->file('image')) {
            $image = uploadImage($file, 'admins/avatars');
            $admin->image = $image;
        }
    }

    public function deleting(Admin $admin)
    {
        if ($admin->image != "default.png") {
            deleteImage($admin->image, 'admins/avatars');
        }
    }
}
