<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $fillable = ['user_id', 'user_name', 'user_content', 'admin_content', 'time'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public static function addActivity($user_content, $admin_content)
    {
        $user = auth()->user();
        if ($user) {
            Activity::create([
                "user_id" => $user->id,
                "user_name" => $user->name,
                "user_content" => $user_content,
                "admin_content" => $user->name . "_   " . $user->id . "   " . $admin_content,
                "time" => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }
    }

    public static function signinToken()
    {
        $user_content = "Đăng nhập vào tài khoản bằng token";
        $admin_content = "vừa đăng nhập vào tài khoản bằng token";
        self::addActivity($user_content, $admin_content);
    }

    public static function signinSocial()
    {
        $user_content = "Đăng nhập vào tài khoản bằng mạng xã hội";
        $admin_content = "vừa đăng nhập vào tài khoản bằng mạng xã hội";
        self::addActivity($user_content, $admin_content);
    }

    public static function signin()
    {
        $user_content = "Đăng nhập vào tài khoản";
        $admin_content = "vừa đăng nhập vào tài khoản";
        self::addActivity($user_content, $admin_content);
    }

    public static function signout()
    {
        $user_content = "Đăng xuất vào tài khoản";
        $admin_content = "vừa đăng xuất vào tài khoản";
        self::addActivity($user_content, $admin_content);
    }

    public static function updateAvatar()
    {
        $user_content = "Thay đổi ảnh đại diện";
        $admin_content = "vừa thay đổi ảnh đại diện";
        self::addActivity($user_content, $admin_content);
    }

    public static function updatePassword()
    {
        $user_content = "Thay đổi mật khẩu";
        $admin_content = "vừa thay đổi mật khẩu";
        self::addActivity($user_content, $admin_content);
    }

    public static function updateProfile()
    {
        $user_content = "Thay đổi thông tin";
        $admin_content = "vừa thay đổi thông tin";
        self::addActivity($user_content, $admin_content);
    }

    public static function addCart()
    {
        $user_content = "Thêm một sản phầm vào giỏ hàng";
        $admin_content = "vừa thêm một sản phầm vào giỏ hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function updateCart()
    {
        $user_content = "Cập nhập một sản phầm vào giỏ hàng";
        $admin_content = "vừa cập nhập một sản phầm vào giỏ hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function deleteCart()
    {
        $user_content = "Xóa một sản phầm vào giỏ hàng";
        $admin_content = "vừa xóa một sản phầm vào giỏ hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function addComment()
    {
        $user_content = "Thêm một đánh giá về sản phẩm";
        $admin_content = "vừa thêm một đánh giá về sản phẩm";
        self::addActivity($user_content, $admin_content);
    }

    public static function updateComment()
    {
        $user_content = "Cập nhập một đánh giá về sản phẩm";
        $admin_content = "vừa cập nhập một đánh giá về sản phẩm";
        self::addActivity($user_content, $admin_content);
    }

    public static function deleteComment()
    {
        $user_content = "Xóa một đánh giá về sản phẩm";
        $admin_content = "vừa xóa một đánh giá về sản phẩm";
        self::addActivity($user_content, $admin_content);
    }

    public static function addOrder()
    {
        $user_content = "Đặt một đơn hàng";
        $admin_content = "vừa đặt một đơn hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function updateOrder()
    {
        $user_content = "Cập nhập một đơn hàng";
        $admin_content = "vừa cập nhập một đơn hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function deleteOrder()
    {
        $user_content = "Xóa một một đơn hàng";
        $admin_content = "vừa xóa một đơn hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function useCoupon()
    {
        $user_content = "Sử dụng mã giảm giá";
        $admin_content = "vừa sử dụng mã giảm giá";
        self::addActivity($user_content, $admin_content);
    }

    public static function viewProduct()
    {
        $user_content = "Xem một sản phẩm";
        $admin_content = "vừa xem một sản phẩm";
        self::addActivity($user_content, $admin_content);
    }

    public static function searchProduct()
    {
        $user_content = "Tìm kiếm một sản phẩm";
        $admin_content = "vừa tìm kiếm một sản phẩm";
        self::addActivity($user_content, $admin_content);
    }

    public static function viewOrder()
    {
        $user_content = "Xem danh sách đơn hàng";
        $admin_content = "vừa xem danh sách đơn hàng";
        self::addActivity($user_content, $admin_content);
    }

    public static function viewOrderDetail()
    {
        $user_content = "Xem chi tiết đơn hàng";
        $admin_content = "vừa xem chi tiết đơn hàng";
        self::addActivity($user_content, $admin_content);
    }
}
