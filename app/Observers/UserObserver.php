<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        if ($file = request()->file('image')) {
            $image = uploadImage($file, 'avatars');
            $user->image = $image;
        }
    }

    public function deleting(User $user)
    {
        if ($user->image != "default.png") {
            deleteImage($user->image, 'avatars');
        }
    }
}
