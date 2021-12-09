<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        $users = User::all();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
        return view('admin.coupon.list')->with(compact(['coupons', 'today', 'users']));
    }

    public function create()
    {
        return view('admin.coupon.add');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit')->with(compact(['coupon']));
    }

    public function update(CouponRequest $req, $id)
    {
        $coupon = Coupon::find($id);
        $coupon->fill($req->all());
        $coupon->save();
        return redirect()->route('coupon.index');
    }

    public function store(CouponRequest $req)
    {
        $coupon = new Coupon;
        $coupon->fill($req->all());
        $coupon->save();
        return redirect()->route('coupon.index');
    }

    public function destroy($id)
    {
        Coupon::destroy($id);
        return \redirect()->route('coupon.index');
    }

    private function has_used($coupon)
    {
        $useds =  explode(",", $coupon->used);
        return in_array(Auth::user()->id, $useds);
    }

    public function use_coupon(Request $req)
    {
        session()->forget(['coupon', 'message', 'error']);

        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $coupon = Coupon::where([
            ['code', '=', $req->code],
            ['end_coupon', '>=', $today]
        ])->first();

        if (!$coupon) {
            session(['error' => 'Mã giảm giá không đúng hoặc đã hết hạn']);
        } else {
            if ($this->has_used($coupon)) {
                session(['error' => 'Bạn đã sử dụng mã giảm giá này rồi']);
            } else {
                $new_oupon = [
                    'code' => $coupon->code,
                    'percent' => $coupon->percent,
                ];
                session(['coupon' =>  $new_oupon]);
                session(['message' => 'Thêm mã giảm giá thành công']);
            }
        }
    }
}
