<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class ChatController extends Controller
{
  public function get_user_chat()
  {
    $chat = Chat::getUserChat();
    echo $chat;
  }

  public function get_admin_chat(Request $req)
  {
    $chat = Chat::getAdminChat($req->user_id);
    echo $chat;
  }

  public function send_user_chat(Request $req)
  {
    $user_id = Auth::user()->id;
    $chat = new Chat;
    $chat->from_id = $user_id;
    $chat->to_id = 1;
    $chat->message = $req->message;
    $chat->save();
  }

  public function send_admin_chat(Request $req)
  {
    $chat = new Chat;
    $chat->to_id = $req->user_id;
    $chat->from_id = 1;
    $chat->message = $req->message;
    $chat->save();
  }
}