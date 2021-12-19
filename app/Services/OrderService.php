<?php

namespace App\Services;

use App\Models\Statistic;
use App\Repositories\OrderRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\CartRepository;
use App\Repositories\ShippingRepository;
use App\Repositories\FeeshipRepository;
use App\Repositories\CouponRepository;
use App\Repositories\UnpaidRepository;
use App\Repositories\StatisticRepository;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Excel;

class OrderService
{
    protected $orderRepository;
    protected $cartRepository;
    protected $shippingRepository;
    protected $orderDetailRepository;
    protected $couponRepository;
    protected $unpaidRepository;
    protected $feeshipRepository;
    protected $statisticRepository;

    public function __construct(StatisticRepository $statisticRepository, FeeshipRepository $feeshipRepository, UnpaidRepository $unpaidRepository, CouponRepository $couponRepository, OrderDetailRepository $orderDetailRepository, OrderRepository $orderRepository, CartRepository $cartRepository, ShippingRepository $shippingRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->shippingRepository = $shippingRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->couponRepository = $couponRepository;
        $this->unpaidRepository = $unpaidRepository;
        $this->feeshipRepository = $feeshipRepository;
        $this->statisticRepository = $statisticRepository;
    }

    public function getCount()
    {
        return $this->orderRepository->getCount();
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function getAllByAdmin()
    {
        return $this->orderRepository->getAllByAdmin();
    }

    public function getById($id)
    {
        return $this->orderRepository->getById($id);
    }

    public function getByCode($code)
    {
        return $this->orderRepository->getById($code);
    }

    protected function insertOrder($data)
    {
        $total_price = $this->cartRepository->getTotalPriceChecked();
        $this->orderRepository->save($data, $total_price);
    }

    protected function insertShipping($data)
    {
        $this->shippingRepository->save((object)$data);
    }

    protected function insertOrderDetail($order_code)
    {
        $this->orderDetailRepository->save($order_code);
    }

    protected function useCoupon($coupon_code)
    {
        if ($coupon_code != "NO") {
            $this->couponRepository->useCoupon($coupon_code);
        }
    }

    protected function handleNewOrder($data)
    {
        $this->insertOrder($data);
        $this->insertShipping($data);
        $this->insertOrderDetail($data['order_code']);
        $this->useCoupon($data['coupon_code']);
    }

    public function save($data)
    {
        $data_order = [
            'order_code' => strtoupper(substr(md5(microtime()), rand(0, 26), 8)),
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'note' => $data->note,
            'method' => $data->payment,
            'coupon_code' =>  $data->coupon_code,
            'feeship_id' => $data->feeship_id,
            'address' => $data->address,
        ];

        if ($data->payment === 0) {
            $this->handle_order_shipping_coupon($data_order);
            $this->cartRepository->deleteChecked();
            return ["type" => "CASH"];
        }

        $this->unpaidRepository->save($data_order);
        $coupon_price = 0;
        $feeship_price = 25000;
        $total_money = $this->cartRepository->getTotalPriceChecked();

        if ($data->coupon_code !== "NO") {
            $coupon = $this->couponRepository->getByCode($data->coupon_code);
            if ($coupon) {
                $coupon_price = ($coupon->percent / 100) * $total_money;
            }
        }

        if ($data->feeship_id !== "NO") {
            $feeship = $this->feeshipRepository->getById($data->feeship_id);
            if ($feeship) {
                $feeship_price = $feeship->feeship;
            }
        }

        $total_money = $total_money + $feeship_price - $coupon_price;
        $order_title = 'Thanh toán mua hàng tại hệ thống MW Store - ' . Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        if ($data->payment === 1) {

            $vnpay = \VNPay::purchase([
                "vnp_TxnRef" => $data_order['order_code'],
                "vnp_OrderInfo" => $order_title,
                "vnp_Amount" => $total_money * 100,
                'vnp_OrderType' => 100000,
                "vnp_IpAddr" =>  $_SERVER['REMOTE_ADDR'],
                "vnp_ReturnUrl" => env('RETURN_URL_PAYMENT_CLIENT'),
            ])->send();


            if ($vnpay->isRedirect()) {
                $redirectUrl = $vnpay->getRedirectUrl();
                return ["type" => "VNPAY", "url" => $redirectUrl];
            }
        }

        if ($data->payment === 2) {
            $response = \MoMoAIO::purchase([
                'amount' => $total_money,
                'returnUrl' =>  env('RETURN_URL_PAYMENT_CLIENT'),
                'notifyUrl' => env('RETURN_URL_PAYMENT_CLIENT'),
                'orderId' => $data_order['order_code'],
                'requestId' => $data_order['order_code'],
                'orderInfo' => $order_title,
            ])->send();

            if ($response->isRedirect()) {
                $redirectUrl = $response->getRedirectUrl();

                return ["type" => "MOMO", "url" => $redirectUrl];
            }
        }
    }

    public function callbackPayment($data)
    {
        if ($data->has('vnp_ResponseCode') && $data->vnp_ResponseCode != '00') {
            throw new Exception("FAIL");
        }

        if ($data->has('errorCode') && $data->errorCode != 0) {
            throw new Exception("FAIL");
        }

        $data_order = $this->unpaidRepository->getByCode($data);

        if (!$data_order) {
            throw new Exception("FAIL");
        }

        $this->handleNewOrder($data_order);
        $this->cartRepository->deleteChecked();
        $data_order->delete();
    }

    public function confirmOrder($data)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepository->getByCode($data->code);
            $order->status = 1;
            $order->save();

            $order_date = Carbon::parse($order->time)->format('Y-m-d');

            $sales = $order->total_order;
            $profit = $sales * 0.3;
            $total_order = 1;
            $quantity = 0;

            $order_details = $order->orderDetails;
            foreach ($order_details as $order_detail) {
                $quantity += $order_detail->product_quantity;
            }

            $this->statisticRepository->updateOrSave($order_date, $sales, $profit, $quantity, $total_order);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception($e->getMessage());
        }

        DB::commit();
    }

    public function delete($code)
    {
        DB::beginTransaction();

        try {
            $brand = $this->orderRepository->delete($code);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new Exception('FAIL');
        }

        DB::commit();

        return $brand;
    }

    public function exportPDF($code)
    {
        $str = base64_decode($code);

        try {
            $print = explode("--", $str);
            $order = $this->orderRepository->getByPrint($print);

            if ($order) {
                $pdf = PDF::loadView('admin.order.print', compact('order'))->setPaper('a4', 'landscape');
                $file = $pdf->download('MW_Store_' . $order->code . '.pdf')->getOriginalContent();
                return $file;
            }

            throw new Exception('FAIL');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
