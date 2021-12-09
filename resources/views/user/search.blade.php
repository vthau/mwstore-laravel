@extends('user.layouts.master')
@section('title', 'Tìm kiếm')

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('search')}}">@lang('lang.search')</a></li>
            </ul>
        </div>
    </div>
</div>

@if(count($products))
<div class="error404-area ptb-60 ptb-sm-60">
    <div class="container">
        <h4 class="title-name title-search mb-20">@lang('lang.result_for') {{ $keyword}} </h4>
        <ul class="work-list">
            @foreach($products as $product)
            <li class="work-item">
                <div class="single-product">
                    <div class="pro-img">
                        <a href="{{route('product.detail', $product->slug)}}">
                            <img class="primary-img" style="height: 226px; object-fit: cover;" src="{{asset('admins/uploads/products/'.$product->image)}}" alt="{{$product->name}}">
                        </a>
                        <p class="quick_view product-text-view" title="Lượt xem"> <i class="fas fa-eye"></i>{{$product->visit}}</p>
                    </div>
                    <div class="pro-content">
                        <div class="pro-info">
                            <h4><a href="{{route('product.detail', $product->slug)}}">{{$product->name}}</a></h4>
                            <p>
                                <span class="price">@money($product->price)</span>
                            </p>
                            <div class="rating">
                                @for ($m = 0; $m < floor($product->star()); $m++) <i class="fas fa-star"></i>
                                    @endfor

                                    @for ($n = floor($product->star()); $n < 5; $n++) <i class="far fa-star"></i>
                                        @endfor
                                        {{ number_format((float)$product->star(), 1, '.', '')}}
                            </div>
                        </div>
                        <div class="pro-actions">
                            <div class="actions-primary">
                                <a href="{{route('product.detail', $product->slug)}}" title="@lang('lang.view_detail_more')">@lang('lang.view_detail')</a>
                            </div>
                            <div class="actions-secondary">
                                <a href="#" title="@lang('lang.add_compare')"><i class="lnr lnr-sync"></i> <span>@lang('lang.add_compare')</span></a>
                                <a href="#" title="@lang('lang.add_wishlist')"><i class="lnr lnr-heart"></i> <span>@lang('lang.add_wishlist')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@else
<h4 class="title-name title-search mt-20 text-center">@lang('lang.no_product_to_show')</h4>
@endif
@endsection
