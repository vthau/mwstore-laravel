@extends('admin.layouts.master')
@section('title', 'Đơn hàng')
@section('title_page', 'Đơn hàng')
@section('sub_title_page', 'Danh sách đơn hàng')

@section('content_page')
<div class="card-header">Danh sách đơn hàng</div>
<div class="table-responsive" style="padding-bottom: 10px;">
    @if(count($orders))
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">STT</th>
                <th class="">Tên khách hàng</th>
                <th class="text-center">Thời gian</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Tính năng</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($orders as $order)
            <tr>
                <td class="text-center text-muted">@php echo $i; $i++; @endphp</td>
                <td>
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left mr-3">
                                <div class="widget-content-left">
                                    <img class="rounded-circle border-circle" src="{{asset('admins/uploads/avatars/'.$order->user->image)}}" alt="">
                                </div>
                            </div>
                            <div class="widget-content-left flex2">
                                <div class="widget-heading">{{$order->user->name}}</div>
                                <div class="widget-subheading opacity-7">{{$order->user->status}}</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center text-muted">{{$order->created_at}}</td>
                <td class="text-center text-muted">
                    @if($order->status ==1 )
                    Đơn hàng đang chờ xử lý
                    @else
                    Đã xử lý
                    @endif
                </td>
                <td class="text-center text-muted">
                    <a href="{{route('order.admin_detail', $order->id)}}" class="btn btn-success btn-sm">Chi tiết</a>
                    <a href="{{route('order.admin_delete', $order->id)}}" class="btn btn-danger btn-sm del-order-admin">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-noti">Không có đơn hàng nào để hiển thị</div>
    @endif
</div>
@endsection
