<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Mail;
use App\Exports\ExportExcelCoupon;
use App\Imports\ImportExcelCoupon;
use Excel;

class CouponController extends Controller
{
    private function has_used($coupon)
    {
        $useds =  explode(",", $coupon->used);
        return in_array(auth()->user()->id, $useds);
    }

    public function use_coupon(Request $req)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $coupon = Coupon::where([['code', '=', $req->code], ['end_coupon', '>=', $today]])->first();

        if (!$coupon) return response()->json(["status" => "NOT_FOUND"]);
        if ($this->has_used($coupon)) return response()->json(["status" => "HAS_USED"]);

        return response()->json([
            "status" => "SUCCESS",
            'code' => $coupon->code,
            'percent' => $coupon->percent,
        ]);
    }

    public function all_coupon()
    {
        $coupons = Coupon::all();
        return response()->json([
            "status" => "SUCCESS",
            "coupons" => $coupons,
        ]);
    }

    public function delete_coupon(Request $req)
    {
        Coupon::destroy($req->id);
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function update_coupon(Request $req)
    {
        Coupon::updateOrCreate(
            [
                'id'   =>   $req->id,
                'code'   =>   $req->code,
            ],
            [
                'name' => $req->name,
                'quantity' =>  $req->quantity,
                'percent' =>  $req->percent,
                'start_coupon' =>  $req->start_coupon,
                'end_coupon' =>  $req->end_coupon,
            ]
        );
        return response()->json([
            'status' => "SUCCESS",
        ]);
    }

    public function new_coupon(Request $req)
    {
        $coupon = Coupon::where("code", $req->code)->first();
        if ($coupon) {
            return response()->json([
                'status' => "COUPON_EXIST",
            ]);
        }

        $coupon = new Coupon;
        $coupon->fill($req->all());
        $coupon->save();
        return response()->json([
            'status' => "SUCCESS",
        ]);
    }

    public function send_coupon(Request $req)
    {
        $user = User::find($req->user_id);
        $coupon = Coupon::where('code', $req->code)->first();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('m');
        $title_mail = "MW Store gửi tặng bạn mã khuyến mãi tháng" . ' ' . $now  . " này";

        Mail::send('admin.mail.send-coupon',  ['coupon' => $coupon, 'user' => $user], function ($message) use ($title_mail, $user) {
            $message->to($user->email)->subject($title_mail);
        });

        return response()->json([
            'status' => "SUCCESS",
        ]);
    }

    public function import_excel(Request $req)
    {
        $file = $req->file('file');
        if (Excel::import(new ImportExcelCoupon, $file)) {
            return response()->json(["status" => "SUCCESS"]);
        }

        return response()->json(["status" => "FAIL"]);
    }

    public function export_excel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelCoupon, 'coupon_' . $time . '.xlsx');
    }
}
