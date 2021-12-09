@extends('admin.layouts.master')
@section('title', 'MW Store | Trang quản trị')
@section('title_page', 'Trang chủ')
@section('sub_title_page', 'Trang chủ quản trị')

@section('content_page')
<div class="row">
    <div class="col-12">
        <div class="index-home">
            <h3 class="text-center">Xin chào <b>{{Auth::guard('admin')->user()->name}}</b> đến với trang quản trị của <b>MW Store</b></h3>
            <div class="index-icon">
                <img src="{{asset('admins/img/logo.png')}}" alt="logo-image" style="width: 120px;" />
                <div width="42" class="avatar-center avatar-border rounded-circle">
                    <img width="42" class="rounded-circle" src="{{asset('admins/img/avatars/' . Auth::guard('admin')->user()->image)}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
