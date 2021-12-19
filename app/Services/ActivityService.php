<?php

namespace App\Services;

use App\Repositories\ActivityRepository;

class ActivityService
{
    protected $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function getAll()
    {
        return $this->activityRepository->getAll();
    }

    public function getByUser($data)
    {
        return $this->activityRepository->getByUser($data->user_id);
    }
}
