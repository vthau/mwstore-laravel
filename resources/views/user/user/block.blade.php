@extends('user.layouts.master')
@section('title', 'MW Store | Khóa tài khoản')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('user.blocked')}}">@lang('lang.block_user')</a></li>
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
                        <h3>@lang('lang.block_account_noti')</h3>
                    </div>
                    <div class="error-button">
                        <a href="{{route('home.index')}}">@lang('lang.home')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
