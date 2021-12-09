@extends('user.layouts.master')
@section('title', 'MW Store | Liên kết hết hạn hoặc không tồn tại, vui lòng thử lại.')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('user.forgot_password')}}">@lang('lang.not_found')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-wrapper text-center">
                    <div class="error-text">
                        <p>@lang('lang.not_found_again').</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
