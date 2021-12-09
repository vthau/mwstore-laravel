<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function get_token(Request $req)
    {
        $tokens = Notification::where("user_id", $req->user_id)->get();
        return response()->json(["status" => "SUCCESS", "data" => $tokens]);
    }

    public function all_token()
    {
        $tokens = Notification::all();
        return response()->json(["status" => "SUCCESS", "data" => $tokens]);
    }

    public function noti_guest(Request $req)
    {
        $noti = Notification::where("token", $req->token)->first();
        if (!$noti) {
            $noti = new Notification;
            $noti->token = $req->token;
            $noti->save();
        }

        return response()->json(["status" => "SUCCESS"]);
    }

    public function noti_user(Request $req)
    {
        $noti = Notification::where("token", $req->token)->first();

        if (!$noti) {
            $noti = new Notification;
            $noti->token = $req->token;
        }

        $noti->user_id = auth()->user()->id;
        $noti->save();

        return response()->json(["status" => "SUCCESS"]);
    }
}
