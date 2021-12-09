﻿@extends('user.layouts.master')
@section('title', 'MW Store | Tin tức')

@section('content_page')

<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('news.index')}}">@lang('lang.news')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        @foreach ($posts as $post)
        <div class="row row-news">
            <a target="_blank" href="https://www.techrum.vn{{$post['href']}}">
                <img class="lazy" data-src="{{$post['image']}}" alt="{{$post['title']}}" />
            </a>
            <div class="box-post-content">
                <a target="_blank" class="post-title" href="https://www.techrum.vn{{$post['href']}}">
                    {{$post['title']}}</a>
                <p class="post-content">{{$post['content']}}</a></p>
                <div class="post-info">
                    <p class="post-info-item post-author">@lang('lang.author'): {{$post['author']}}</a></p>
                    <p class="post-info-item post-time">@lang('lang.time'): {{$post['time']}}</a></p>
                    <p class="post-info-item post-view">@lang('lang.view'): {{$post['view']}}</a></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
