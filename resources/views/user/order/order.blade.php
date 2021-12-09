@extends('user.layouts.master')
@section('title', 'Đơn hàng')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('order.index')}}">@lang('lang.order')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        <div class="row">
            @if(count($orders))
            <div class="col-md-12">
                <div class="box-both">
                    <table class="table" style=" width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="">@lang('lang.name')</th>
                                <th class="text-center">@lang('lang.time')</th>
                                <th class="text-center">@lang('lang.status')</th>
                                <th class="text-center">@lang('lang.more')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($orders as $order)
                            <tr>
                                <td class="text-center text-muted">@php echo $i; $i++; @endphp</td>
                                <td class="text-center text-muted">{{$order->user->name}}</td>
                                <td class="text-center text-muted">{{$order->created_at}}</td>
                                <td class="text-center text-muted">
                                    @if($order->status == 1)
                                    @lang('lang.not_confirm')
                                    @else
                                    @lang('lang.deliveryed')
                                    @endif
                                </td>
                                <td class="text-center text-muted">
                                    <a href="{{route('order.show', $order->id)}}" class="btn btn-success btn-sm">Xem đơn hàng</a>
                                    @if($order->status == 2)
                                    <a href="{{route('order.delete', $order->id)}}" class="btn btn-danger btn-sm">Xóa</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="text-center text-noti" style="margin: 0 auto;">@lang('lang.no_order')</div>
            @endif
        </div>
    </div>
</div>
@endsection
