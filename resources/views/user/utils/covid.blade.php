@extends('user.layouts.master')
@section('title', 'MW Store | Covid')
<link rel="stylesheet" href="{{asset('users/css/covid.css')}}" rel="stylesheet">
@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('covid.index')}}">@lang('lang.covid')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        <div class="row">
            <h2>@lang('lang.info_covid')</h2>
        </div>
        <div class="row">
            <div class="covid-box col-10">
                <div class="covid-header">
                    <p><i class="fas fa-bars"></i> @lang('lang.list_country')</p>
                    <select class="form-control-sm form-control countrys">
                    </select>
                </div>
                <div class="covid-body">
                    <img class="img-country" src="https://disease.sh/assets/img/flags/vn.png" alt="">
                    <h4 class="covid-day">VietNam</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">@lang('lang.today_case')</th>
                                <th class="text-center" scope="col">@lang('lang.total_case')</th>
                                <th class="text-center" scope="col">@lang('lang.today_recover')</th>
                                <th class="text-center" scope="col">@lang('lang.total_recover')</th>
                                <th class="text-center" scope="col">@lang('lang.today_death')</th>
                                <th class="text-center" scope="col">@lang('lang.total_death')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center today-case"></td>
                                <td class="text-center total-case"></td>
                                <td class="text-center today-recovered"></td>
                                <td class="text-center total-recovered"></td>
                                <td class="text-center today-deaths"></td>
                                <td class="text-center total-deaths"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('users/js/covid.js')}}"></script>
@endsection
