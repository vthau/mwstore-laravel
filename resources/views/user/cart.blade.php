@extends('user.layouts.master')
@section('title', "Cart")

@section('content_page')
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home.index')}}">@lang('lang.home')</a></li>
                <li class="active"><a href="{{route('cart.index')}}">@lang('lang.cart')</a></li>
            </ul>
        </div>
    </div>
</div>
@auth
<div class="cart-main-area ptb-60 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                @if(count($carts))
                <div>
                    <div class="table-content table-responsive mb-45">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">@lang('lang.image')</th>
                                    <th class="product-name">@lang('lang.product_name')</th>
                                    <th class="product-price">@lang('lang.price')</th>
                                    <th class="product-quantity">@lang('lang.quantity')</th>
                                    <th class="product-subtotal">@lang('lang.total_money')</th>
                                    <th class="product-remove">@lang('lang.delete')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($carts as $cart)
                                @php $total += $cart->price() ; @endphp
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="{{route('product.detail', $cart->product->slug)}}"><img style="height: 102px; object-fit: cover; border-radius: 10px;" src="{{asset('admins/uploads/products/'.$cart->product->image)}}" alt="{{$cart->getName()}}"></a>
                                    </td>
                                    <td class="product-name"><a href="{{route('product.detail', $cart->product->slug)}}">{{$cart->getName()}}</a></td>
                                    <td class="product-price"><span class="amount">@money($cart->getPrice())</span></td>
                                    <td class="product-quantity">
                                        <div>
                                            <input name="quantity" class="product-quantity-update" data-id="{{$cart->product->id}}" type="number" min="1" value="{{$cart->quantity}}">
                                        </div>
                                    </td>
                                    <td class="product-subtotal">@money($cart->price())</td>
                                    <td class="product-remove"> <a><i class="fa fa-times del-cart" data-id="{{$cart->id}}" aria-hidden="true"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="buttons-cart">
                                <a href="index.php">@lang('lang.continue_shop')</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="cart_totals float-md-right text-md-right">
                                <h2>@lang('lang.total_money')</h2>
                                <br>
                                <table class="float-md-right">
                                    <tbody>
                                        <tr class="order-total">
                                            <th>@lang('lang.total_money')</th>
                                            <td>
                                                <strong><span class="amount">@money($cart->totalPrice())</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="wc-proceed-to-checkout">
                                    <a href="{{route('checkout.index')}}">@lang('lang.checkout')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <p style="text-align: center; color: #414dd1; font-size: 15px">@lang('lang.no_product_to_show')</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endauth
@guest
<div class="error404-area ptb-80 ptb-sm-80">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-wrapper text-center">
                    <div class="error-text">
                        <p>@lang('lang.signup_to_continue')</p>
                    </div>
                    <div class="error-button">
                        <a href="{{route('user.signin_get')}}">@lang('lang.signup')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection
