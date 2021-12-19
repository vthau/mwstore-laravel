<?php

namespace App\Services;

use App\Exports\ExportExcelUser;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCount()
    {
        return $this->userRepository->getCount();
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function getById($data)
    {
        return $this->userRepository->getById($data);
    }

    public function authToken()
    {
        $user = auth()->user()->load("activities");
        $user->tokens()->delete();
        $token = $user->createToken($user->email)->plainTextToken;
        return ["user" => $user, "token" => $token];
    }

    public function save($data)
    {
        $user = $this->userRepository->getByEmail($data->email);
        if ($user) {
            throw new Exception("EMAIL_EXIST");
        }

        DB::beginTransaction();

        try {
            $this->userRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function updateAvatar($data)
    {
        DB::beginTransaction();

        try {
            $this->userRepository->updateAvatar($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function updateProfile($data)
    {
        DB::beginTransaction();

        try {
            $this->userRepository->updateProfile($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function updatePassword($data)
    {
        $user_id = auth()->user()->id;
        $user = $this->userRepository->getById($user_id);

        if (!Hash::check($data->old_password, $user->password)) {
            throw new Exception("WRONG_PASSWORD");
        }

        DB::beginTransaction();

        try {
            $this->userRepository->updatePassword($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $this->userRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function signIn($data)
    {
        $credentials = $data->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user =  auth()->user();
            $token = $user->createToken($user->email)->plainTextToken;
            return ["user" => $user, "token" => $token];
        }

        throw new Exception("FAIL");
    }

    public function signOut()
    {
        try {
            auth()->user()->tokens()->delete();
            Auth::guard('web')->logout();
            session()->flush();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function exportExcel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelUser, 'user_' . $time . '.xlsx');
    }
}
