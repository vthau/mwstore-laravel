﻿@extends('user.layouts.master')
@section('title', 'MW Store | Liên hệ')

@section('content_page')

<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('contact.index')}}">@lang('lang.contact')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area ptb-60 ptb-sm-60">
    <div class="container">
        <div id="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.650597055417!2d106.67998241462075!3d10.761388462414164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1b8a072901%3A0x2fb4502ebd044212!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBTxrAgcGjhuqFtIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaA!5e0!3m2!1svi!2s!4v1622878056287!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <h3 class="info-info">@lang('lang.contact')</h3>
        <div class="info-contact">
            <div class="item-contact"><i class="fas fa-map-marked-alt"></i> @lang('lang.address'): 280 An Dương Vương, Quận 5, TP Hồ Chí Minh</div>
            <div class="item-contact"><i class="fas fa-mobile-alt"></i> @lang('lang.phone'): 123.456.7898</div>
            <div class="item-contact"><i class="fas fa-envelope"></i> Email: daihocsupham@hcmue.edu.vn</div>
            <div class="item-contact"><i class="fab fa-facebook-f"></i> Facebook: fb.com/daihocsupham.hcmue</div>
        </div>
    </div>
</div>
@endsection
