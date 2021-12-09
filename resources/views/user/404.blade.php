@extends('user.layouts.master')
@section('title', 'MW Store | @lang('lang.not_found')')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="404.php">404</a></li>
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
                        <h1>404</h1>
                        <h2>@lang('lang.not_found')</h2>
                        <p>@lang('lang.not_found_again').</p>
                    </div>
                    <div class="error-button">
                        <a href="index.php">@lang('lang.home')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
