<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{
    protected $feeship;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function getTokenByUser($data)
    {
        return $this->notification->where("user_id", $data->user_id)->get();
    }

    public function getAll()
    {
        return $this->notification->all();
    }

    public function saveUser($data)
    {
        $user_id = auth()->user()->id;
        $notification = $this->notification->updateOrCreate([
            'token' => $data->token,
        ], ['user_id' => $user_id]);
        return $notification->fresh();
    }

    public function saveGuest($data)
    {
        $notification = $this->notification->updateOrCreate(['token' => $data->token]);
        return $notification->fresh();
    }
}
