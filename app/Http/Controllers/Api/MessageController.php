<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function get_message(Request $req)
    {
        $messages = Message::with(["user", "admin"])
            ->where(["user_id" => $req->user_id, "admin_id" => $req->admin_id])->get();
        return response()->json(["status" => "SUCCESS", "data" => $messages]);
    }

    public function new_message(Request $req)
    {
        Message::create($req->all());
        return response()->json(["status" => "SUCCESS"]);
    }
}
