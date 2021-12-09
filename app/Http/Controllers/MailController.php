<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Mail;


class MailController extends Controller
{
    public function send_coupon(Request $req)
    {
        $user = User::find($req->user_id);
        $coupon = Coupon::where('code', $req->coupon_code)->first();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('m');
        $title_mail = "MW Store gửi tặng bạn mã khuyến mãi tháng" . ' ' . $now  . " này";

        Mail::send('admin.mail.send-coupon',  ['coupon' => $coupon, 'user' => $user], function ($message) use ($title_mail, $user) {
            $message->to($user->email)->subject($title_mail);
        });
    }

    private function send_mail_reset_password($user)
    {
        $expired = Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15)->format('d-m-Y H:i:s');
        $forgot_password = md5($user->email . $expired);

        $user->expired = $expired;
        $user->forgot_password = md5($user->email . $expired);
        $user->save();

        $title_mail = "MW Store: Đặt lại mật khẩu tài khoản.";

        Mail::send('user.mail.forgot-password',  ['user' => $user, 'forgot_password' => $forgot_password], function ($message) use ($title_mail, $user) {
            $message->to($user->email)->subject($title_mail);
        });

        session(['email' => $user->email]);
    }

    public function handle_mail_reset_password(Request $req)
    {
        $user = User::where('email', $req->email)->first();
        if (!$user) {
            return back()->with(['error' => "Địa chỉ email không tồn tại trong hệ thống"]);
        }
        $this->send_mail_reset_password($user);
        return back()->with(['success' => "Thành công, kiểm tra email để đặt lại mật khẩu"]);
    }
}
