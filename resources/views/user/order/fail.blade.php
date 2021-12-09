@extends('user.layouts.master')
@section('title', 'Giao dịch thất bại')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('checkout.index')}}">@lang('lang.transaction_failed')</a></li>
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
                        <p>@lang('lang.transaction_failed')</p>
                    </div>
                    <div class="error-button">
                        <a href="{{route('checkout.index')}}">@lang('lang.checkout')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
