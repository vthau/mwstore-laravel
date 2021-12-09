@extends('user.layouts.master')
@section('title', 'Quên mật khẩu')

@section('content_page')

<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('user.forgot_password')}}">@lang('lang.forgot_password')</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="register-account ptb-50 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="register-title">
                    <h3 class="mb-10 text-center title-name title-search">@lang('lang.forgot_password')</h3>
                </div>
            </div>
        </div>
        <!-- Row End -->
        @if (session('error'))
        <p class="update-info-fail">{{ session('error') }}</p>
        @endif
        @if (session('success'))
        <p class="update-info-success">{{ session('success') }}</p>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <form class="form-register" action="{{route('mail.reset_password')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <legend>@lang('lang.input_email')</legend>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="email"><span class="require">*</span>Email</label>
                            <div class="col-md-10">
                                <input type="email" class="form-control" name="email" placeholder="@lang('lang.input_email')..." value="" required>
                            </div>
                        </div>
                    </fieldset>
                    <div class="terms">
                        <div class="float-md-right">
                            <input type="submit" value="@lang('lang.send')" class="return-customer-btn">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
