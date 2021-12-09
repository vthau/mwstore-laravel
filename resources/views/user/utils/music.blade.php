@extends('user.layouts.master')
@section('title', 'MW Store | Nghe nhạc')
<link rel="stylesheet" href="{{asset('users/css/music.css')}}" rel="stylesheet">

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('music.index')}}">@lang('lang.music')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        <div class="row music-player">
            <div class="col-md-6 music-left">
                <div class="player-content">
                    <img id="bg-song" src="{{asset('users/img/logo.png')}}" alt="" />
                </div>
                <div class="player-info">
                    <p id="singer-song">@lang('lang.loading')...</p>
                    <p id="title-song">@lang('lang.loading')...</p>
                </div>
                <div class="player-controls">
                    <div class="control">
                        <div class="button" id="play-previous">
                            <i class="fas fa-backward"></i>
                        </div>
                    </div>
                    <div class="control">
                        <div class="button" id="play-pause-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="control">
                        <div class="button" id="play-next">
                            <i class="fas fa-forward"></i>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 music-right">
                <div class="list-header">
                    <p><i class="fas fa-bars"></i> @lang('lang.list_music')</p>
                    <select class="form-control-sm form-control type-song">
                    </select>
                </div>
                <div class="list-content">
                    <ul id="songs">
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="{{asset('users/js/music.js')}}"></script>
@endsection
