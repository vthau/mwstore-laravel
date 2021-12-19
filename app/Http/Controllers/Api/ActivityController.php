<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;


class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function all_activity()
    {
        $activities = $this->activityService->getAll();
        return $this->successResponse($activities);
    }

    public function get_activity(Request $req)
    {
        $activities = $this->activityService->getByUser($req);
        return $this->successResponse($activities);
    }
}
