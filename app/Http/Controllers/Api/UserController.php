<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportExcelUser;
use Excel;
use Carbon\Carbon;

class UserController extends Controller
{
    public function auth_token(Request $req)
    {
        $user = auth()->user()->load("activities");
        $user->tokens()->delete();
        $token = $user->createToken($user->email)->plainTextToken;
        Activity::signinToken();
        return response()->json([
            "status" => "AUTH_SUCCESS",
            "user" => $user,
            "token" => $token,
        ]);
    }

    public function signup(Request $req)
    {
        $user = User::where('email', $req->email)->first();
        if ($user) {
            return response()->json(["status" => "EMAIL_EXIST"]);
        }

        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            "status" => "SIGN_UP_SUCCESS",
        ]);
    }

    public function signin(Request $req)
    {
        $credentials = $req->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user =  auth()->user();
            $token = $user->createToken($user->email)->plainTextToken;
            Activity::signin();
            return response()->json([
                "status" => "SIGN_IN_SUCCESS",
                "user" => $user,
                "token" => $token,
            ]);
        }

        return response()->json([
            "status" => "SIGN_IN_FAIL",
        ]);
    }

    public function signout()
    {
        Activity::signout();
        auth()->user()->tokens()->delete();
        Auth::guard('web')->logout();
        session()->flush();
        cookie('laravel_session', '', -1);

        return response()->json([
            "status" => "SIGN_OUT_SUCCESS",
        ]);
    }

    public function update_profile(Request $req)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $user->fill($req->all());
        $user->save();
        Activity::updateProfile();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function update_avatar(Request $req)
    {
        $user = User::find(Auth::user()->id);

        if ($req->hasFile('image') && $user->image != "default.png") {
            $image = $user->image;
            $user->image = "";
            deleteImage($image, 'avatars');
        }
        $user->save();

        Activity::updateAvatar();
        return response()->json([
            "status" => "SUCCESS",
            "user" => $user,
        ]);
    }

    public function update_password(Request $req)
    {
        $user = User::find(auth()->user()->id);
        $password = $user->password;
        $old_password = $req->old_password;
        $new_password = $req->new_password;

        if (Hash::check($old_password, $password)) {
            $user->password = Hash::make($new_password);
            $user->save();
            Activity::updatePassword();
            return response()->json([
                "status" => "SUCCESS",
            ]);
        }

        return response()->json([
            "status" => "FAIL",
        ]);
    }

    public function all_user(Request $req)
    {
        $users = User::with("device")->latest('id')->get();
        return response()->json([
            "status" => "SUCCESS",
            "users" => $users,
        ]);
    }

    public function delete_user(Request $req)
    {
        User::destroy($req->id);
        return response()->json(["status" => "SUCCESS"]);
    }

    public function export_excel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelUser, 'user_' . $time . '.xlsx');
    }
}
