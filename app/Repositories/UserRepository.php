<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $coupon;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getCount()
    {
        return $this->user->count();
    }

    public function getAll()
    {
        return $this->user->with("device")->latest('id')->get();
    }

    public function getById($id)
    {
        return $this->user->find($id);
    }

    public function getByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    public function save($data)
    {
        $user = new $this->user;
        $user->fill($data->all());
        $user->password = Hash::make($data->password);
        $user->save();
        return $user->fresh();
    }

    public function saveUserSocial($social_user)
    {
        $user = new $this->user;
        $user->fill((array)$social_user);
        $image = downloadImage($social_user->avatar, 'avatars');
        $user->image = $image;
        $user->password = Hash::make("12345678");
        $user->save();
        $user->fresh();
        return $user;
    }

    public function updateAvatar($data)
    {
        $user_id = auth()->user()->id;
        $user = $this->user->find($user_id);

        if ($data->hasFile('image') && $user->image != "default.png") {
            $image = $user->image;
            $user->image = "";
            deleteImage($image, 'avatars');
        }
        $user->save();
        return $user->fresh();
    }

    public function updateProfile($data)
    {
        $user_id = auth()->user()->id;
        return $this->user->find($user_id)->update($data->all());
    }

    public function updatePassword($data)
    {
        $user_id = auth()->user()->id;
        $user = $this->user->find($user_id);
        $user->password = Hash::make($data->new_password);
        $user->save();
        return $user->fresh();
    }

    public function delete($data)
    {
        return $this->user->find($data->id)->delete();
    }
}
