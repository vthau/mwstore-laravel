<?php

namespace App\Services;

use App\Exports\ExportExcelCoupon;
use App\Imports\ImportExcelCoupon;
use App\Repositories\CouponRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Excel;
use Exception;
use Illuminate\Support\Facades\Mail;

class CouponService
{
    protected $couponRepository;
    protected $userRepository;

    public function __construct(CouponRepository $couponRepository, UserRepository $userRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->userRepository = $userRepository;
    }

    protected function checkUseCoupon($coupon)
    {
        $useds =  explode(",", $coupon->used);
        return in_array(auth()->user()->id, $useds);
    }

    public function getCount()
    {
        return $this->couponRepository->getCount();
    }

    public function getAll()
    {
        return $this->couponRepository->getAll();
    }

    public function save($data)
    {
        $coupon = $this->couponRepository->getByCode($data->code);
        if ($coupon) {
            throw new Exception("COUPON_EXIST");
        }

        DB::beginTransaction();

        try {
            $this->couponRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function update($data)
    {
        DB::beginTransaction();

        try {
            $this->couponRepository->update($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function sendCoupon($data)
    {
        try {
            $user = $this->userRepository->getById($data->user_id);
            $coupon = $this->couponRepository->getByCode($data->code);
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('m');
            $title_mail = "MW Store gửi tặng bạn mã khuyến mãi tháng" . ' ' . $now  . " này";

            Mail::send('admin.mail.send-coupon',  ['coupon' => $coupon, 'user' => $user], function ($message) use ($title_mail, $user) {
                $message->to($user->email)->subject($title_mail);
            });
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function useCoupon($data)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $coupon = $this->couponRepository->getByDate($data->code, $today);

        if (!$coupon) {
            throw new Exception("NOT_FOUND");
        }

        if ($this->checkUseCoupon($coupon)) {
            throw new Exception("HAS_USED");
        }
        return ['code' => $coupon->code, 'percent' => $coupon->percent];
    }

    public function delete($data)
    {
        DB::beginTransaction();

        try {
            $this->couponRepository->delete($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function importExcel($data)
    {
        try {
            $file = $data->file('file');
            return Excel::import(new ImportExcelCoupon, $file);
        } catch (Exception $e) {
            throw new Exception('FAIL');
        }
    }

    public function exportExcel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelCoupon, 'coupon_' . $time . '.xlsx');
    }
}
