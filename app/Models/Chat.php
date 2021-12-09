<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    protected  $fillable = ['from_id', 'to_id', 'message'];
    private static $USER_CHAT = 0;
    private static $ADMIN_CHAT = 1;

    private static function getFloatRight($chat, $userID, $type)
    {
        if (($chat->from_id == $userID && $type == self::$USER_CHAT) || ($chat->from_id == 1 && $type == self::$ADMIN_CHAT)) return 'to-right';
        return '';
    }

    public static function getSrcAvatar($type)
    {
        if ($type == self::$USER_CHAT) return url('users/img/admin.png');
        return '';
    }

    private static function generatorChatHTML($chats, $userID, $type)
    {
        if (!$chats) {
            return '<h6 style="text-align: center; margin-top: 140px;">Không có tin nhắn.</h6>';
        }

        $xhtml = '';
        foreach ($chats as $chat) {
            $floatRight = self::getFloatRight($chat, $userID, $type);
            $srcAvatar = self::getSrcAvatar($type);

            $xhtml .= '
                        <div class="box-mess ' . $floatRight . '">
                            <div class="box-image">
                                <img class="img-user"  src="' . $srcAvatar . '" alt="">
                            </div>
                            <div class="mess-content">
                                <p>' . $chat->message . '</p>
                            </div>
                        </div>
                    ';
        }

        return $xhtml;
    }

    public static function getUserChat()
    {
        $userID = Auth::user()->id;
        $chats = Chat::where([
            'from_id' => $userID,
            'to_id' => 1,
        ])->orWhere([
            'from_id' => 1,
            'to_id' => $userID,
        ])->get();

        return self::generatorChatHTML($chats, $userID, self::$USER_CHAT);
    }

    public static function getAdminChat($userID)
    {
        $chats = Chat::where([
            'from_id' => 1,
            'to_id' =>  $userID,
        ])->orWhere([
            'from_id' => $userID,
            'to_id' => 1,
        ])->get();

        return self::generatorChatHTML($chats, $userID, self::$ADMIN_CHAT);
    }
}
