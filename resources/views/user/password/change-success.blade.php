@extends('user.layouts.master')
@section('title', 'Thay đổi mật khẩu thành công')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="">@lang('lang.change_pass_success')</a></li>
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
                        <p>@lang('lang.change_pass_success').</p>
                    </div>
                    <div class="error-button">
                        <a href="{{route('user.signin_get')}}">@lang('lang.signup')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
