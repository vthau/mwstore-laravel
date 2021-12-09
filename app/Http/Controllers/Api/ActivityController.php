<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;


class ActivityController extends Controller
{
    public function all_activity()
    {
        $activities =  Activity::latest()->paginate(4);
        return response()->json([
            'status' => "SUCCESS",
            'data' => $activities,
        ]);
    }

    public function get_activity(Request $req)
    {
        $activities =  Activity::where("user_id", $req->user_id)->latest()->paginate(4);
        return response()->json([
            'status' => "SUCCESS",
            'data' => $activities,
        ]);
    }
}
