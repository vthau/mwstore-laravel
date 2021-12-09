<?php

namespace App\Http\Controllers\Api;

use App\Exports\ExportExcelBrand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Activity;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Feeship;
use App\Models\Statistic;
use App\Models\Unpaid;
use Carbon\Carbon;
use Exception;
use PDF;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user'])
            ->where(['user_id' => auth()->user()->id, ['status', '<>', 3]])
            ->latest('id')->get();
        Activity::viewOrder();
        return response()->json([
            "status" => "SUCCESS",
            "orders" => $orders,
        ]);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'shipping', 'orderDetails', 'feeship', 'coupon'])->where(['id' => $id])->first();
        if ($order) {
            Activity::viewOrderDetail();
            return response()->json([
                "status" => "SUCCESS",
                "order" => $order,
            ]);
        }

        return $order;
    }

    private function insert_order($data_order)
    {
        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->code = $data_order['order_code'];
        $order->feeship_id = $data_order['feeship_id'];
        $order->coupon_code = $data_order['coupon_code'];
        $order->status = 0;
        $order->total_order = Cart::totalPriceChecked();
        $order->save();
    }

    private function insert_shipping($data_order)
    {
        $new_data = (object)$data_order;
        $shipping = new Shipping;
        $shipping->order_code = $new_data->order_code;
        $shipping->name = $new_data->name;
        $shipping->email = $new_data->email;
        $shipping->phone = $new_data->phone;
        $shipping->note = $new_data->note;
        $shipping->method = $new_data->method;
        $shipping->address = $new_data->address;
        $shipping->user_id = auth()->user()->id;
        $shipping->save();
    }

    private function insert_order_detail($order_code)
    {
        $carts =  auth()->user()->carts()->where('checked', 1)->get();
        foreach ($carts as $cart) {
            OrderDetail::create([
                'order_code' => $order_code,
                'product_id' => $cart->product->id,
                'product_name' => $cart->product->name,
                'product_price' => $cart->product->price,
                'product_quantity' => $cart->quantity,
                'product_image' => $cart->product->image,
                'total_price' => $cart->price(),
            ]);
        }
    }

    private function use_coupon($coupon_code)
    {
        if ($coupon_code != "NO") {
            $coupon = Coupon::where('code', $coupon_code)->first();
            $coupon->used = $coupon->used . "," . auth()->user()->id;
            $coupon->decrement('quantity');
            $coupon->save();
        }
    }

    private function handle_order_shipping_coupon($data_order)
    {
        $this->insert_order($data_order);
        $this->insert_shipping($data_order);
        $this->insert_order_detail($data_order['order_code']);
        $this->use_coupon($data_order['coupon_code']);
    }

    public function new_order(OrderRequest $req)
    {
        $data_order = [
            'order_code' => strtoupper(substr(md5(microtime()), rand(0, 26), 8)),
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'note' => $req->note,
            'method' => $req->payment,
            'coupon_code' =>  $req->coupon_code,
            'feeship_id' => $req->feeship_id,
            'address' => $req->address,
        ];

        if ($req->payment === 0) {
            $this->handle_order_shipping_coupon($data_order);
            Cart::where('user_id', auth()->user()->id)->where('checked', 1)->delete();

            return response()->json([
                "status" => "SUCCESS",
                "type" => "CASH",
            ]);
        }

        Unpaid::create($data_order);
        $coupon_price = 0;
        $feeship_price = 25000;
        $total_money = Cart::totalPriceChecked();

        if ($req->coupon_code !== "NO") {
            $coupon = Coupon::where("code", $req->coupon_code)->first();
            if ($coupon) {
                $coupon_price = ($coupon->percent / 100) * $total_money;
            }
        }
        if ($req->feeship_id !== "NO") {
            $feeship = Feeship::where("id", $req->feeship_id)->first();
            if ($feeship) {
                $feeship_price = $feeship->feeship;
            }
        }

        $total_money = $total_money + $feeship_price - $coupon_price;
        $order_title = 'Thanh toán mua hàng tại hệ thống MW Store - ' . Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');


        if ($req->payment === 1) {

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

                return response()->json([
                    "status" => "SUCCESS",
                    "type" => "VNPAY",
                    "url" =>  $redirectUrl,
                ]);
            }
        }

        if ($req->payment === 2) {
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

                return response()->json([
                    "status" => "SUCCESS",
                    "type" => "MOMO",
                    "url" => $redirectUrl,
                ]);
            }
        }
    }

    public function callback(Request $req)
    {
        if ($req->has('vnp_ResponseCode') && $req->vnp_ResponseCode != '00') {
            return response()->json(["status" => "FAIL"]);
        }
        if ($req->has('errorCode') && $req->errorCode != 0) {
            return response()->json(["status" => "FAIL"]);
        }

        $data_order = Unpaid::where('order_code', $req->vnp_TxnRef)
            ->orWhere("order_code", $req->orderId)->first();

        if (!$data_order) {
            return response()->json(["status" => "FAIL"]);
        }

        $this->handle_order_shipping_coupon($data_order);

        Cart::where('user_id', auth()->user()->id)->where('checked', 1)->delete();
        Activity::addOrder();
        Activity::useCoupon();

        $data_order->delete();
        return response()->json(["status" => "SUCCESS"]);
    }

    public function all_order()
    {
        $orders = Order::with("user")->latest('id')->get();
        return response()->json(["status" => "SUCCESS", "orders" => $orders]);
    }

    public function confirm_order(Request $req)
    {
        $order = Order::where('code', $req->code)->first();
        $order->status = 1;
        $order->save();
        $order_date = Carbon::parse($order->time)->format('Y-m-d');

        $statistic = Statistic::where("order_date", $order_date)->first();

        $sales = $order->total_order;
        $profit = $sales * 0.3;
        $total_order = 1;
        $quantity = 0;

        $order_details = $order->orderDetails;
        foreach ($order_details as $order_detail) {
            $quantity += $order_detail->product_quantity;
        }

        if ($statistic) {
            $statistic->sales = $statistic->sales + $sales;
            $statistic->profit =  $statistic->profit + $profit;
            $statistic->quantity =  $statistic->quantity + $quantity;
            $statistic->total_order = $statistic->total_order + $total_order;
            $statistic->save();
        } else {
            $statistic = new Statistic();
            $statistic->order_date = $order_date;
            $statistic->sales = $sales;
            $statistic->profit =  $profit;
            $statistic->quantity =  $quantity;
            $statistic->total_order = $total_order;
            $statistic->save();
        }

        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function delete_order(Request $req)
    {
        Order::where('code', $req->code)->delete();
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function order_detail(Request $req)
    {
        $order = Order::with(['user', 'shipping', 'orderDetails', 'feeship', 'coupon'])->where(['code' => $req->code])->first();
        if ($order) {
            return response()->json([
                "status" => "SUCCESS",
                "order" => $order,
            ]);
        }

        return $order;
    }

    public function print_order($code)
    {
        $str = base64_decode($code);

        try {
            $key = explode("--", $str);
            $order = Order::where(['code' => $key[1], "id" => $key[0], "user_id" => $key[2]])->first();
            if ($order) {
                $pdf = PDF::loadView('admin.order.print', compact('order'))->setPaper('a4', 'landscape');
                $file = $pdf->download('MW_Store_' . $order->code . '.pdf')->getOriginalContent();
                return $file;
            }
        } catch (Exception $e) {
        }
        return abort(404);
    }
}
