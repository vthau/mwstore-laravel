@extends('user.layouts.master')
@section('title', 'Thông tin người dùng')

@section('content_page')

<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('user.index')}}">@lang('lang.user_info')</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="register-account ptb-50 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="register-title">
                    <h3 class="mb-10 text-center title-name title-search">@lang('lang.user_info')</h3>
                </div>
            </div>
        </div>
        <!-- Row End -->
        @if (session()->has('update-success'))
        <p class="update-info-success">{{session('update-success')}}</p>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <form class="form-register" action="{{route('user.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <legend>@lang('lang.user_info_detail')</legend>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="f-name"><span class="require">*</span>@lang('lang.name')</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" placeholder="@lang('lang.name')..." value="{{$user->name}}" required minlength="2">
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="email"><span class="require">*</span>Email</label>
                            <div class="col-md-10">
                                <input type="email" class="form-control" name="email" placeholder="Email..." disabled="disabled" value="{{$user->email}}" required>
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="number"><span class="require"></span>@lang('lang.phone')</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" name="phone" placeholder="@lang('lang.phone')..." value="{{$user->phone}}">
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="number"><span class="require"></span>@lang('lang.status')</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="status" placeholder="@lang('lang.status')..." value="{{$user->status}}">
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="number"><span class="require"></span>@lang('lang.address')</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="address" placeholder="@lang('lang.address')..." value="{{$user->address}}">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="newsletter-input">
                        <legend>@lang('lang.image')</legend>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="number"><span class="require"></span>@lang('lang.avatar')</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" name="image" id="validatedCustomFile" accept=".PNG, .JPEG, .JPG">
                            </div>
                        </div>
                    </fieldset>
                    @if ($errors->has('file_error'))
                    <p class="update-info-fail">{{$errors->first('file_error')}}</p>
                    @endif

                    @if($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                    @endif
                    <p class="text-center mtb-10">@lang('lang.keep_update')</p>
                    <img class="rounded-circle border-circle" src="{{asset('admins/uploads/avatars/'.$user->image)}}" alt="">
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
