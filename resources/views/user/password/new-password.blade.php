@extends('user.layouts.master')
@section('title', 'Mật khẩu mới')

@section('content_page')

<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="">@lang('lang.new_password')</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="register-account ptb-50 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="register-title">
                    <h3 class="mb-10 text-center title-name title-search">@lang('lang.new_password')</h3>
                </div>
            </div>
        </div>
        <!-- Row End -->
        @if ($errors->has('password'))
        <p class="update-info-fail">{{$errors->first('password')}}</p>
        @endif
        @if (session('error'))
        <p class="update-info-fail">{{ session('error') }}</p>
        @endif
        @if (session('success'))
        <p class="update-info-success">{{ session('success') }}</p>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <form class="form-register" action="{{route('user.set_password')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <legend>@lang('lang.new_password')</legend>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="password"><span class="require">*</span>@lang('lang.password')</label>
                            <div class="col-md-10">
                                <input type="password" id="password" class="form-control" name="password" placeholder="Vui lòng nhập mật khẩu" value="" required>
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="password"><span class="require">*</span>@lang('lang.confirm_password')</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" id="password" name="password_confirmation" placeholder="Vui lòng nhập lại mật khẩu" value="" required>
                            </div>
                        </div>
                    </fieldset>
                    <div class="terms">
                        <div class="float-md-right">
                            <input type="submit" value="@lang('lang.update')" class="return-customer-btn">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
