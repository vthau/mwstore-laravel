@extends('admin.layouts.master')
@section('title', 'Chi tiết đơn hàng')
@section('title_page', 'Chi tiết đơn hàng')
@section('sub_title_page', 'Chi tiết đơn hàng')

@section('content_page')
<div class="card-header">Thông tin người mua</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Tên khách hàng</th>
                <th class="text-center">Email</th>
                <th class="text-center">Số điện thoại</th>
                <th class="text-center">Địa chỉ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php $user = $order->user; @endphp
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper ml-4">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="rounded-circle border-circle" src="{{asset('admins/uploads/avatars/'.$user->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$user->name}}</div>
                                <div class="widget-subheading opacity-7">{{$user->status}}</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center text-muted">{{$user->email}}</td>
                <td class="text-center text-muted">{{ Str::limit($user->phone, 4)}}</td>
                <td class="text-center text-muted">{{$user->address}}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="card-header mt-3">Thông tin nguời nhận</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Tên người nhận</th>
                <th class="text-center">Email</th>
                <th class="text-center">Số điện thoại</th>
                <th class="text-center">Hình thức thanh toán</th>
                <th class="text-center">Ghi chú</th>
                <th class="text-center">Địa chỉ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php $shipping = $order->shipping; @endphp
                <td class="text-center text-muted">{{$shipping->name}}</td>
                <td class="text-center text-muted">{{$shipping->email}}</td>
                <td class="text-center text-muted">{{ Str::limit($shipping->phone, 4)}}</td>
                <td class="text-center text-muted">
                    @if($shipping->method == 0)
                    Tiền mặt
                    @elseif($shipping->method == 1)
                    VN Pay
                    @elseif($shipping->method == 2)
                    Momo
                    @endif
                </td>
                <td class="text-center text-muted">{{$shipping->note}}</td>
                <td class="text-center text-muted">{{$shipping->address}}</td>

            </tr>
        </tbody>
    </table>
</div>

<div class="card-header mt-3">sản phẩm đã đặt</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Tên sản phẩm</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-center">Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @php $products = $order->orderDetails; @endphp
            @foreach($products as $product)
            <tr>
                <td class="text-center text-muted">1</td>
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper ml-4">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="border-circle" src="{{asset('admins/uploads/products/'.$product->product_image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$product->product_name}}</div>
                                <div class="widget-subheading opacity-7"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center text-muted">@money($product->product_price)</td>
                <td class="text-center text-muted">{{$product->product_quantity}}</td>
                <td class="text-center text-muted">@money($product->total_price)</td>
                <td class="text-center text-muted">{{$product->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-header mt-3">Thanh toán</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Tiền sản phẩm</th>
                @if($order->coupon_code != "NO")
                <th class="text-center">Giảm giá</th>
                @endif
                <th class="text-center">Phí vận chuyển</th>
                <th class="text-center">Tiền cần thanh toán</th>
                <th class="text-center">In đơn hàng</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            @php
            $coupon = 0;
            $total = $order->total_order;
            @endphp

            @if($order->feeship_id != "NO")
            @php $feeship = $order->feeship->feeship; @endphp
            @else
            @php $feeship = 25000; @endphp
            @endif

            @if($order->coupon_code != "NO")
            @php $coupon = $total * ($order->coupon->percent/100); @endphp
            @endif

            <tr>
                <td class="text-center text-muted">@money($total)</td>
                @if($order->coupon_code != "NO")
                <td class="text-center text-muted">@money($coupon)</td>
                @endif
                <td class="text-center text-muted">@money($feeship)</td>
                <td class="text-center text-muted">@money($total + $feeship - $coupon)</td>
                <td class="text-center text-muted"><a href="{{route('order.admin_print', $order->code)}}">In đơn hàng</a></td>
                <td class="text-center text-muted">
                    @if($order->status == 1)
                    Chờ xác nhận
                    @else
                    Đã xử lý
                    @endif
                </td>
                <td class="text-center text-muted">
                    @if($order->status == 1)
                    <a href="{{route('order.delivery', $order->id)}}" class="btn btn-success btn-sm">Xác nhận & giao hàng</a>
                    <a href="{{route('order.admin_delete', $order->id)}}" class="btn btn-danger btn-sm del-order-admin">Xóa</a>
                    @else
                    <a href="{{route('order.admin_delete', $order->id)}}" class="btn btn-danger btn-sm del-order-admin">Xóa</a>
                    @endif
                </td>
            </tr>
        </tbody>
</div>
@endsection
