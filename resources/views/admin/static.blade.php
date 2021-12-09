@extends('admin.layouts.master')
@section('title', 'Thống kê')
@section('title_page', 'Thống kê')
@section('sub_title_page', 'Thông kê')

@section('content_page')
<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title text-center mt-3 pb-4" style="font-size: 25px; border-bottom: 1px solid rgba(26,54,126,0.125);">
            <i class="fas fa-user-cog" style="font-size: 40px;"></i>
            <br>
            Thống kê tổng quan
        </h5>
        <div class="row mt-5 mb-4">
            <div class="col-md-3 text-center">
                <div class="card-device more-feature float-right">
                    <div class="card-device-title">
                        Đơn hàng
                        <br />
                        {{$order_count}}
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card-device more-feature">
                    <div class="card-device-title">
                        Thương hiệu
                        <br />
                        {{$brand_count}}
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card-device more-feature">
                    <div class="card-device-title">
                        Sản phẩm
                        <br />
                        {{$product_count}}
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card-device more-feature float-left">
                    <div class="card-device-title">
                        Slider
                        <br />
                        {{$slider_count}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-4">
            <div class="col-md-3 text-center">
                <div class="card-device more-feature float-right">
                    <div class="card-device-title">
                        Đánh giá
                        <br />
                        {{$comment_count}}
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card-device more-feature">
                    <div class="card-device-title">
                        Bài viết
                        <br />
                        {{$post_count}}
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card-device more-feature">
                    <div class="card-device-title">
                        Người dùng
                        <br />
                        {{$user_count}}
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card-device more-feature float-left">
                    <div class="card-device-title">
                        Lượt truy cập
                        <br />
                        {{$visit_count}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
