<?php

namespace App\Repositories;

use App\Models\Activity;

class ActivityRepository
{
    protected $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function getAll()
    {
        return $this->activity->latest()->paginate(4);
    }

    public function getByUser($user_id)
    {
        return $this->activity->where("user_id", $user_id)->latest()->paginate(4);
    }
}
