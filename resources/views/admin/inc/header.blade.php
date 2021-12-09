<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <link rel="shortcut icon" href="{{asset('admins/img/favicon.ico')}}">
    <meta name="description" content="Trang quản trị web site MW Store.">
    <meta name="msapplication-tap-highlight" content="no">

    <link href="{{asset('admins/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admins/css/admin-style.css')}}" rel="stylesheet">
    <link href="{{asset('admins/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('admins/css/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('admins/css/select2.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('admins/js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admins/js/select2.min.js')}}"></script>


    <style>
        /* img[alt*="000webhost"],
        img[alt*="000webhost"][style],
        img[src*="000webhost"],
        img[src*="000webhost"][style],
        body>div:nth-last-of-type(1)[style] {
            opacity: 0 !important;
            pointer-events: none !important;
            width: 0px !important;
            height: 0px !important;
            visibility: hidden !important;
            display: none !important;
        } */
    </style>

</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <a href="{{route('admin.index')}}" class="">
                    <img src="{{asset('admins/img/logo.png')}}" alt="logo-image" style="width: 120px;">
                </a>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content pr-0">
                <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <a href="{{route('admin.index')}}" class="nav-link">
                                <i class="nav-link-icon fa fa-home"> </i>
                                Trang chủ
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">

                            <div class="widget-content-wrapper">

                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{Auth::guard('admin')->user()->name}}
                                    </div>
                                    <div class="widget-subheading">
                                        {{Auth::guard('admin')->user()->description}}
                                    </div>
                                </div>

                                <div class="ml-3 widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <div width="42" class="avatar-center avatar-border rounded-circle">
                                                <img width="42" class="rounded-circle" src="{{asset('admins/img/avatars/' . Auth::guard('admin')->user()->image)}}" alt="">
                                            </div>
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <a tabindex="0" class="dropdown-item" href="{{route('admin.signout')}}">Đăng Xuất</a>
                                        </div>
                                    </div>
                                </div>
                                <div class=" widget-content-right header-user-info ml-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
