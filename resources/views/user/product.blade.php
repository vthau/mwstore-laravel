@extends('user.layouts.master')
@section('title', $product->name)
@section('canonical', url()->current())
@section('meta_desc', $product->description)

@section('title_og', $product->name)
@section('desc_og', $product->description)
@section('img_og', asset('admins/uploads/products/'.$product->image))

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="">@lang('lang.product_detail')</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="main-product-thumbnail ptb-60 ptb-sm-60">
    <div class="container">
        <div class="thumb-bg">
            <div class="row">
                @if(count($gallerys))
                <div class="col-lg-5 mb-all-40">
                    @php
                    $active = true; $i = 0;
                    @endphp
                    <div class="tab-content">
                        @foreach($gallerys as $gallery)
                        @php $i++; @endphp
                        <div id="thumb{{$i}}" class="tab-pane fade show <?php if ($active) {
                                                                            echo 'active';
                                                                            $active = false;
                                                                        } ?>">
                            <a data-fancybox="images" href="{{asset('admins/uploads/gallerys/'.$gallery->image)}}"><img src="{{asset('admins/uploads/gallerys/'.$gallery->image)}}" id="zoom-img" class="product-image" data-zoom-image="{{asset('admins/uploads/gallerys/'.$gallery->image)}}" alt="{{$product->name}}"></a>
                        </div>
                        @endforeach
                    </div>
                    <!-- Thumbnail Large Image End -->
                    <!-- Thumbnail Image End -->
                    @php
                    $active = true; $i = 0;
                    @endphp
                    <div class="product-thumbnail mt-15">
                        <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                            @foreach($gallerys as $gallery)
                            @php $i++; @endphp
                            <a class="<?php if ($active) {
                                            echo 'active';
                                            $active = false;
                                        } ?>" data-toggle="tab" href="#thumb{{$i}}"><img src="{{asset('admins/uploads/gallerys/'.$gallery->image)}}" alt="{{$product->name}}"></a>
                            @endforeach
                        </div>
                    </div>
                    <!-- Thumbnail image end -->
                </div>
                @else
                <div class="col-lg-5 mb-all-40">
                    <div class="tab-content">
                        <div id="thumb1" class="tab-pane fade show active">
                            <img class="product-image" id="zoom-img" data-zoom-image="{{asset('admins/uploads/products/'.$product->image)}}" src="{{asset('admins/uploads/products/'.$product->image)}}" alt="{{$product->name}}">
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-lg-7">
                    <div class="thubnail-desc fix">
                        <h3 class="product-header">{{$product->name}}</h3>
                        <div class="d-flex">
                            <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                            <div class="fb-like" data-href="{{url()->current()}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                            <div class="zalo-share-button" data-href="{{url()->current()}}" data-oaid="2905292136695329731" data-layout="1" data-color="blue" data-customize=false></div>
                            <div class="zalo-follow-only-button ml-2" data-oaid="2905292136695329731"></div>
                        </div>
                        <div class="rating-summary fix mtb-10">
                            <div class="rating">
                                @for ($m = 0; $m < floor($product->star()); $m++) <i class="fas fa-star"></i>
                                    @endfor

                                    @for ($n = floor($product->star()); $n < 5; $n++) <i class="far fa-star"></i>
                                        @endfor
                                        {{number_format((float)$product->star(), 1, '.', '')}} <i class="fas fa-eye"></i>
                                        <span class="visit">{{$product->visit}}</span>
                            </div>
                            <div class="rating-feedback">
                                <p>
                                    @if(count($comments))
                                    {{count($comments)}} @lang('lang.product_review')
                                    @else
                                    @lang('lang.no_review')
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="pro-price mtb-30">
                            <p class="d-flex align-items-center"><span class="prev-price"></span><span class="price">@money($product->price)</span><span class="saving-price" style="display: none;"></span></p>
                        </div>
                        <p class="mb-20 pro-desc-details">{{$product->description}}</p>
                        <div class="box-quantity d-flex hot-product2">
                            <form action="{{route('cart.store')}}" method="POST">
                                @csrf
                                <div style="display: flex;">
                                    <input type="hidden" name="product_id" value="{{$product->id}}" />
                                    <input class="quantity mr-15 custom-box-quantity" type="number" name="quantity" min="1" value="1" />
                                    <button class="btn btn-primary custom-btn-submit" type="submit"> @lang('lang.add_cart')</button>
                                    <div class="ml-md-2 pro-actions">
                                        <div class="ml-2 actions-secondary">
                                            <a href="" title="" data-original-title="WishList"><i class="fas fa-heartbeat" style="color: #FF006F;"></i>
                                                <span> @lang('lang.add_wishlist')</span></a>
                                            <a href="" title="" data-original-title="Compare"><i class="fas fa-sync-alt" style="color: #414DD1;"></i>
                                                <span> @lang('lang.add_compare')</span></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="pro-ref mt-20">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="thumnail-desc pb-100 pb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="main-thumb-desc nav tabs-area" role="tablist">
                    <li><a class="active" data-toggle="tab" href="#dtail">@lang('lang.desc')</a></li>
                    <li><a data-toggle="tab" href="#comment-fb">@lang('lang.comment_fb')</a></li>
                    <li><a data-toggle="tab" href="#all-review">@lang('lang.review')</a></li>
                    @auth
                    <li><a data-toggle="tab" href="#your-review">@lang('lang.your_review')</a></li>
                    @endauth

                </ul>
                <div class="tab-content thumb-content border-default">

                    <div id="dtail" class="tab-pane fade show active">
                        @if(!$post)
                        <p>{{$product->description}}</p>
                        @else
                        <div class="row" style="padding: 0 10px">
                            <h3 class="mb-4"> {!! $post->title !!}</h3>
                            {!! $post->content !!}
                        </div>
                        @endif
                    </div>

                    <div id="comment-fb" class="tab-pane fade">
                        <div class="fb-comments" data-href="{{url()->current()}}" data-width="800" data-numposts="20"></div>
                    </div>

                    <div id="all-review" class="tab-pane fade ">
                        @if(count($comments))
                        @php $i = 1; @endphp
                        @foreach($comments as $comment)
                        <div class="row d-flex <?php if ($i % 2 == 0) {
                                                    echo "justify-content-end";
                                                    $i++;
                                                } ?>">
                            <div class="row comment-box">
                                <div class="comment-box-image">
                                    <img class="avatar-comment" src="{{asset('admins/uploads/avatars/'.$comment->user->image)}}">
                                </div>
                                <div class="ml-1 mr-2 col">
                                    <div class="row">
                                        <p><b>{{$comment->user->name}}</b></p>
                                    </div>
                                    <div class="row">
                                        <p class="break-word">{{$comment->comment}}</p>
                                    </div>
                                    <div class="row">
                                        <div class="mr-2">
                                            <div class="list-star">
                                                @for ($j = 0; $j < $comment->star; $j++)
                                                    <i class="fas fa-star"></i>
                                                    @endfor

                                                    @for ($k = $comment->star; $k < 5; $k++) <i class="far fa-star"></i>
                                                        @endfor
                                            </div>
                                        </div>
                                        <div>
                                            <div class="time-comment">
                                                {{$comment->time}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p>@lang('lang.no_review')</p>
                        @endif
                    </div>
                    @auth
                    <div id="your-review" class="tab-pane fade">
                        @if(!$your_comment)
                        <div class="review border-default universal-padding mt-30">
                            <h2 class="review-title mb-30">
                                @lang('lang.product'): <br>
                                <span>{{$product->name}}</span>
                            </h2>
                            <p class="review-mini-title">@lang('lang.review')</p>
                            <ul class="review-list">
                                <li class="review-list-li">
                                    <i class="fa fa-star-o" data-index="1"></i>
                                    <i class="fa fa-star-o" data-index="2"></i>
                                    <i class="fa fa-star-o" data-index="3"></i>
                                    <i class="fa fa-star-o" data-index="4"></i>
                                    <i class="fa fa-star-o" data-index="5"></i>
                                </li>
                            </ul>
                            <div class="riview-field mt-40">
                                <form autocomplete="off" action="" id="form-review" method="POST">
                                    <div class="form-group">
                                        <label class="req" for="comments">@lang('lang.review')</label>
                                        <input type="hidden" class="productID" value="{{$product->id}}">
                                        <textarea class="form-control review-comment" rows="5" id="comment" name="review-comment" required="required"></textarea>
                                    </div>
                                    <div class="customer-btn review-submit">@lang('lang.send')</div>
                                </form>
                            </div>
                        </div>
                        @else
                        <h5 class="text-center mb-4"> @lang('lang.reviewed')</h5>
                        <div class="row d-flex justify-content-center">
                            <div class="row comment-box">
                                <div class="comment-box-image">
                                    <img class="avatar-comment" src="{{asset('admins/uploads/avatars/'.Auth::user()->image)}}">
                                </div>
                                <div class="ml-1 col">
                                    <div class="row">
                                        <p><b>{{Auth::user()->name}}</b></p>
                                    </div>
                                    <div class="row">
                                        <p class="break-word">{{$your_comment->comment}}</p>
                                    </div>
                                    <div class="row">
                                        <div class="mr-2">
                                            <div class="list-star">
                                                @php $star = floor($your_comment->star); @endphp
                                                @for ($j = 0; $j < $star; $j++) <i class="fas fa-star"></i>
                                                    @endfor

                                                    @for ($k = $star; $k < 5; $k++) <i class="far fa-star"></i>
                                                        @endfor
                                            </div>
                                        </div>
                                        <div>
                                            <div class="time-comment">
                                                {{$your_comment->time}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mr-2 feature-review">
                                    <input type="hidden" class="productID" value="{{$product->id}}">
                                    @if ($your_comment->status == 0)
                                    <i class="fa fa-spinner" style="color: green;"></i>
                                    @else
                                    <i class="fa fa-check-circle-o" style="color: green;"></i>
                                    @endif
                                    <i class="fa fa-edit" id="edit-comment"></i>
                                    <i class="fas fa-trash" data-id="{{$your_comment->id}}" id="delete-comment"></i>
                                </div>
                            </div>
                        </div>

                        <div class="review border-default universal-padding mt-30 box-edit">
                            <h2 class="review-title mb-30 text-center">
                                @lang('lang.edit_review')
                            </h2>
                            <p class="review-mini-title">@lang('lang.review')</p>
                            <ul class="review-list">
                                <li class="review-list-li">
                                    @for ($k = 1; $k <= 5; $k++) <i class="fa fa-star-o" data-index="{{$k}}"></i>
                                        @endfor
                                </li>
                            </ul>
                            <div class="riview-field mt-40">
                                <form autocomplete="off" action="" id="form-review" method="POST">
                                    <div class="form-group">
                                        <label class="req" for="comments">@lang('lang.review')</label>
                                        <input type="hidden" class="productID" value="{{$product->id}}">
                                        <textarea class="form-control review-comment" rows="5" id="comment" name="review-comment" required="required">{{$your_comment->comment}}</textarea>
                                    </div>
                                    <div class="customer-btn review-update">@lang('lang.review')</div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hot-deal-products pb-90 pb-sm-50">
    <div class="container">
        <div class="post-title pb-10">
            <h2>@lang('lang.product_related')</h2>
        </div>
        <div class="hot-deal-active owl-carousel">
            @foreach($product_brands as $product_brand)
            <div class="single-product">
                <div class="pro-img">
                    <a href="{{$product_brand->slug}}">
                        <img class="primary-img lazy" style="height: 226px; object-fit: cover;" data-src="{{asset('admins/uploads/products/'.$product_brand->image)}}" alt="{{$product_brand->name}}">
                    </a>
                    <p class="quick_view product-text-view" title="Lượt xem"> <i class="fas fa-eye"></i>{{$product->visit}}</p>
                </div>
                <div class="pro-content">
                    <div class="pro-info">
                        <h4><a href="{{$product_brand->id}}">{{$product_brand->name}}</a></h4>
                        <p>
                            <span class="price">@money($product_brand->price)</span>
                        </p>
                        <div class="rating">
                            @for ($m = 0; $m < floor($product_brand->star()); $m++) <i class="fas fa-star"></i>
                                @endfor

                                @for ($n = floor($product_brand->star()); $n < 5; $n++) <i class="far fa-star"></i>
                                    @endfor
                        </div>
                    </div>
                    <div class="pro-actions">
                        <div class="actions-primary">
                            <a href="{{route('product.detail', $product_brand->slug)}}" title="@lang('lang.view_detail_more')">@lang('lang.view_detail')</a>
                        </div>
                        <div class="actions-secondary">
                            <a href="#" title="@lang('lang.add_compare')"><i class="lnr lnr-sync"></i> <span>@lang('lang.add_compare')</span></a>
                            <a href="#" title=">@lang('lang.add_wishlist')"><i class="lnr lnr-heart"></i> <span>@lang('lang.add_wishlist')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
