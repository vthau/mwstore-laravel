<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.user.info')->with(compact(['user']));
    }

    public function all_user()
    {
        $users = User::get(['id', 'name', 'image', 'phone', 'email', 'status', 'address']);
        return view('admin.user.list')->with(compact(['users']));
    }

    public function online_user(Request $req)
    {
        if ($req->getMethod() == 'GET') {
            return view('admin.user.online');
        }

        $res = User::userOnline();
        return response()->json($res);
    }

    public function more_feature($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.more')->with(compact(['user']));
    }

    public function update(UserRequest $req)
    {
        $user = User::find(Auth::user()->id);

        if ($req->hasFile('image') && $user->image != "default.png") {
            deleteImage($user->image, 'avatars');
        }
        $user->fill($req->all());
        $user->save();

        return redirect()->route('user.index')->with([
            'update-success' => 'Cập nhập thông tin thành công'
        ]);;
    }

    public function blocked()
    {
        if (!session('block')) {
            return redirect()->route('home.index');
        }
        return view('user.user.block');
    }

    public function unblock(Request $req)
    {
        User::where('id', $req->id)->update([
            'block' => 0,
        ]);
        session()->forget('block');
    }

    public function block(Request $req)
    {
        User::where('id', $req->id)->update([
            'block' => 5,
        ]);
    }

    public function forgot_password()
    {
        return view('user.password.forgot-password');
    }

    public function new_password($code)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $user = User::where('forgot_password', $code)->first();
        if (!$user || $user->expired < $now) {
            return view('user.mail.expired');
        }
        return view('user.password.new-password');
    }

    public function set_password(PasswordRequest $req)
    {
        $user = User::where('email', session('email'))->first();
        if (!$user) {
            return abort(404);
        }

        $user->expired = null;
        $user->forgot_password = null;
        $user->password = Hash::make($req->password);
        $user->save();
        session()->forget('email');

        return view('user.password.change-success');
    }

    public function delete(Request $req)
    {
        User::find($req->id)->delete();
    }
}
