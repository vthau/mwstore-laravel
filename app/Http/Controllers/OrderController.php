<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\UserOrder;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user'])->where(['user_id' => Auth::user()->id, ['status', '<>', 3]])->latest('id')->get();
        return view('user.order.order')->with(compact(['orders']));
    }

    public  function manage()
    {
        $orders = Order::with(['user'])->latest('id')->get();
        return view('admin.order.manage')->with(compact(['orders']));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'shipping', 'orderDetails', 'feeship', 'coupon'])->findOrFail($id);
        return view('user.order.detail')->with(compact(['order']));
    }

    public function delete($id)
    {
        Order::where('id', $id)->update(['status' => 3]);
        return back();
    }

    public function admin_delete($id)
    {
        Order::destroy($id);
        return \redirect()->route('order.manage');
    }

    public function admin_detail($id)
    {
        $order = Order::with(['user', 'shipping', 'orderDetails', 'feeship', 'coupon'])->findOrFail($id);
        return view('admin.order.detail')->with(compact(['order']));
    }

    private function insert_order($data_order)
    {
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->code = $data_order['order_code'];
        $order->feeship_id = $data_order['feeship_id'];
        $order->coupon_code = $data_order['coupon_code'];
        $order->status = 1;
        $order->total_order = Cart::totalPrice();
        $order->save();
    }

    private function insert_shipping($data_order)
    {
        $shipping = new Shipping;
        $shipping->fill($data_order);
        $shipping->user_id = Auth::user()->id;
        $shipping->save();
    }

    private function insert_order_detail($order_code)
    {
        $carts = Auth::user()->carts;
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
            $coupon->used = $coupon->used . "," . Auth::user()->id;
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

        $order = Order::where('code', $data_order['order_code'])->first();
        event(new UserOrder($order));
        session()->forget(['data_order', 'coupon', 'feeship_id', 'address', 'feeship', 'total_money']);
    }

    public function confirm_order(OrderRequest $req)
    {
        if (!session('feeship')) {
            return back()->with('error_shipping', 'Vui lòng chọn địa chỉ nhận hàng.');
        }

        $data_order = [
            'order_code' => strtoupper(substr(md5(microtime()), rand(0, 26), 8)),
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'note' => $req->note,
            'method' => $req->payment,
            'coupon_code' =>  session('coupon.code', 'NO'),
            'feeship_id' => session('feeship_id'),
            'address' => session('address'),
        ];

        //cash payment
        if ($req->payment == 0) {
            $this->handle_order_shipping_coupon($data_order);
            Cart::where('user_id', Auth::user()->id)->delete();
            return redirect()->route('order.index');
        }

        $total_money =  session('total_money');
        session(['data_order' =>  $data_order]);

        //vnpay payment
        if ($req->payment == 1) {
            $vnp_OrderInfo = 'Thanh toán mua hàng tại hệ thống MW Store -' . Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $vnp_BankCode = $req->bank_code;

            $inputData = [
                "vnp_Version" => "2.0.0",
                "vnp_TmnCode" => env('VPN_TMN_CODE'),
                "vnp_Amount" => $total_money * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" =>  $_SERVER['REMOTE_ADDR'],
                "vnp_Locale" => 'vn',
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_ReturnUrl" => env('RETURN_URL_PAYMENT'),
                "vnp_TxnRef" => $data_order['order_code'],
            ];

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = env('VPN_URL') . "?" . $query;
            if (env('VPN_HASH_SERECT')) {
                $vnpSecureHash = hash('sha256', env('VPN_HASH_SERECT') . $hashdata);
                $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            }
            return redirect($vnp_Url);
        }

        //momo payment
        if ($req->payment == 2) {
            $response = \MoMoAIO::purchase([
                'amount' => $total_money,
                'returnUrl' => env('RETURN_URL_PAYMENT'),
                'notifyUrl' => 'http://localhost:8000/order/ipn/',
                'orderId' => $data_order['order_code'],
                'requestId' => $data_order['order_code'],
                'orderInfo' => 'Thanh toán mua hàng tại hệ thống MW Store -' . Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s'),
            ])->send();

            if ($response->isRedirect()) {
                $redirectUrl = $response->getRedirectUrl();

                return redirect($redirectUrl);
                // TODO: chuyển khách sang trang MoMo để thanh toán
            }
        }
    }

    public function payment_callback(Request $req)
    {
        if ($req->has('vnp_ResponseCode') && $req->vnp_ResponseCode != '00') {
            return view('user.order.order-fail');
        }

        if ($req->has('errorCode') && $req->errorCode != 0) {
            return view('user.order.fail');
        }

        $data_order = session('data_order');
        $this->handle_order_shipping_coupon($data_order);

        Cart::where('user_id', Auth::user()->id)->delete();
        return redirect()->route('order.index');
    }

    public function delivery($id)
    {
        Order::where('id', $id)->update([
            'status' => 2,
        ]);

        return back();
    }

    public function print_order($order_code)
    {
        $order = Order::where('code', $order_code)->first();
        $pdf = PDF::loadView('admin.order.print', compact('order'))->setPaper('a4', 'landscape');
        return $pdf->download('MW_Store_' . $order->code . '.pdf');
    }

    public function print_order_new($code)
    {
        $str = base64_decode($code);
        try {
            $key = explode("--", $str);
            $order = Order::where(['code' => $key[1], "id" => $key[0], "user_id" => $key[2]])->first();
            if ($order) {
                $pdf = PDF::loadView('admin.order.print', compact('order'))->setPaper('a4', 'landscape');
                return $pdf->download('MW_Store_' . $order->code . '.pdf');
            }
        } catch (Exception $e) {
        }
        return abort(404);
    }
}
