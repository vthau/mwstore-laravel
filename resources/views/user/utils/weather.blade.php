@extends('user.layouts.master')
@section('title', 'MW Store | Thời tiết')

@section('content_page')

<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('weather.index')}}">@lang('lang.weather')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        <div class="row weather">
            <h2 class="title-weather">@lang('lang.weather')</h2>
            <p class="weather-city"></p>
            <div class="weather-content">
                <div class="box-temp">
                    <img class="img-temp" src="{{asset('users/img/weather/thermometer.png')}}" alt="">
                    <p class="text-temp">No info</p>
                </div>
                <div class="box-weather-common">
                    <div class="row-weather">
                        <div class="col-weather">
                            <img class="img-temp" src="{{asset('users/img/weather/humidity.png')}}" alt="">
                            <p class="weather-info-text humidity">No info</p>
                        </div>
                        <View class="col-weather mal">
                            <img class="img-temp" src="{{asset('users/img/weather/wind.png')}}" alt="">
                            <p class="weather-info-text speed">No info</p>
                        </View>
                    </div>
                    <div class="row-weather">
                        <div class="col-weather">
                            <img class="img-temp" src="{{asset('users/img/weather/sunrise.png')}}" alt="">
                            <p class="weather-info-text sunrise">No info</p>
                        </div>
                        <View class="col-weather mal">
                            <img class="img-temp" src="{{asset('users/img/weather/sunset.png')}}" alt="">
                            <p class="weather-info-text sunset">No info</p>
                        </View>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    axios.get('https://api.openweathermap.org/data/2.5/weather?q=Saigon,Vietnam&units=metric&appid=09522e7c1b90d4c879371c025ae95996')
        .then(function(response) {
            const {
                main,
                wind,
                sys,
                name,
                dt
            } = response.data;
            $(".weather-city").html(name + "    " + moment(
                dt * 1000,
            ).format('DD/MM/YYYY'));
            $(".text-temp").html(main.temp + " °C");
            $(".humidity").html(main.humidity + " %");
            $(".speed").html();
            $(".sunrise").html(moment(
                sys.sunrise * 1000,
            ).format('hh:mm A'));
            $(".sunset").html(moment(
                sys.sunset * 1000,
            ).format('hh:mm A'));
        })
        .catch(function(error) {
            console.log(error);
        });
</script>

@endsection
