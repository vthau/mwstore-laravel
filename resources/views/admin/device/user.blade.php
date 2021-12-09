@extends('admin.layouts.master')
@section('title', 'Thông tin thiết bị người dùng')
@section('title_page', 'Thông tin thiết bị')
@section('sub_title_page', 'Thông tin thiết bị người dùng')

@section('content_page')
<div class="card-body">
    <h5 class="card-title text-center mt-3 pb-4" style="font-size: 25px; border-bottom: 1px solid rgba(26,54,126,0.125);"><i class="fas fa-cogs" style="font-size: 40px;"></i> <br>{{$device->user->name}}</h5>
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <div class="card-device" style="width: 55%">
                <div class="card-device-title">
                    <i class="fas fa-user-clock" style="font-size: 25px;"></i>
                    <br />
                    Thời gian hoạt động gần nhất
                </div>
                <div class="card-device-body">
                    {{$device->last_login}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="col-md-4 text-center">
            <div class="card-device">
                <div class="card-device-title">
                    <i class="fas fa-desktop" style="font-size: 25px;"></i>
                    <br />
                    Thiết bị
                </div>
                <div class="card-device-body">
                    {{$device->device}}
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card-device">
                <div class="card-device-title">
                    <i class="fa fa-windows" style="font-size: 25px;"></i>
                    <br />
                    Hệ điều hành
                </div>
                <div class="card-device-body">
                    {{$device->os}}
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card-device">
                <div class="card-device-title">
                    <i class="fa fa-chrome" style="font-size: 25px;"></i>
                    <br />
                    Trình duyệt
                </div>
                <div class="card-device-body">
                    {{$device->browser}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
