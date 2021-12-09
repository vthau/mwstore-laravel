<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'vi'])) abort(400);
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('order/print/{id}', 'OrderController@print_order')->name('order.print');
});

Route::get('blocked', 'UserController@blocked')->name('user.blocked');
Route::group(['middleware' => ['block_user', 'visitor', 'user_online']], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::resource('contact', 'ContactController');
    Route::resource('news', 'NewsController');
    Route::resource('music', 'MusicController');
    Route::resource('covid', 'CovidController');
    Route::resource('weather', 'WeatherController');
    Route::any('search', 'SearchController@search')->name('search');
    Route::post('search-live', 'SearchController@search_live')->name('search.live');
    Route::get('product/{id}', 'ProductController@detail')->name('product.detail');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::group(['prefix' => 'signup'], function () {
        Route::get('/', 'UserAuthController@signup')->name('user.signup_get');
        Route::post('/', 'UserAuthController@handle_signup')->name('user.signup_post');
    });
    Route::group(['prefix' => 'signin'], function () {
        Route::get('/', 'UserAuthController@signin')->name('user.signin_get');
        Route::post('/', 'UserAuthController@handle_signin')->name('user.signin_post');
        Route::get('google', 'SocialLoginController@redirect_to_google')->name('social.google');
        Route::get('zalo', 'SocialLoginController@redirect_to_zalo')->name('social.zalo');
        Route::get('facebook', 'SocialLoginController@redirect_to_facebook')->name('social.facebook');
        Route::get('zalo-social', 'SocialLoginController@handle_signin_zalo');
        Route::get('google-social', 'SocialLoginController@handle_signin_google');
        Route::get('facebook-social', 'SocialLoginController@handle_signin_facebook');
    });
    Route::get('forgot-password', 'UserController@forgot_password')->name('user.forgot_password');
    Route::get('new-password/{code}', 'UserController@new_password')->name('user.new_password');
    Route::post('set-password', 'UserController@set_password')->name('user.set_password');
    Route::post('send-mail-password', 'MailController@handle_mail_reset_password')->name('mail.reset_password');
    Route::group(['middleware' => ['auth_user']], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@index')->name('user.index');
            Route::post('update', 'UserController@update')->name('user.update');
        });
        Route::get('signout', 'UserAuthController@signout')->name('user.signout');
        Route::group(['prefix' => 'comment'], function () {
            Route::post('update', 'CommentController@update')->name('comment.update');
            Route::post('store', 'CommentController@store')->name('comment.store');
            Route::post('delete', 'CommentController@delete')->name('comment.delete');
        });
        Route::group(['prefix' => 'cart'], function () {
            Route::post('delete', 'CartController@delete')->name('cart.delete');
            Route::post('update', 'CartController@update')->name('cart.update');
            Route::post('store', 'CartController@store')->name('cart.store');
        });
        Route::group(['prefix' => 'checkout'], function () {
            Route::get('/', 'CheckoutController@index')->name('checkout.index');
            Route::post('calc-feeship', 'CheckoutController@calc_feeship')->name('checkout.calc_feeship');
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('/', 'OrderController@index')->name('order.index');
            Route::get('detail/{id}', 'OrderController@show')->name('order.show');
            Route::get('delete/{id}', 'OrderController@delete')->name('order.delete');

            Route::get('payment_callback', 'OrderController@payment_callback')->name('payment.callback');
            Route::post('order-confirm', 'OrderController@confirm_order')->name('order.confirm');
            Route::get('print-order/{id}', 'OrderController@print_order')->name('order.print');
        });
        Route::post('use-coupon', 'CouponController@use_coupon')->name('coupon.use_coupon');
        Route::post('select-delivery', 'DeliveryController@select_delivery');
        Route::group(['prefix' => 'chat'], function () {
            Route::post('get', 'ChatController@get_user_chat');
            Route::post('send', 'ChatController@send_user_chat');
        });
    });
});

//print
Route::group(['prefix' => 'print'], function () {
    Route::get('order/{code}', 'OrderController@print_order_new'); //middleware admin
});

//admin route
Route::get('admin/signin', 'AdminAuthController@signin')->name('admin.signin');
Route::post('admin/signin', 'AdminAuthController@handle_signin')->name('admin.handle_signin');
Route::group(['prefix' => 'admin',  'middleware' => ['auth:admin', 'auth_admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('signout', 'AdminAuthController@signout')->name('admin.signout');
    Route::post('send-coupon', 'MailController@send_coupon');
    Route::group(['middleware' => 'can:' . config('role.ROLE')], function () {
        Route::resource('role', 'RoleController');
    });
    Route::group(['middleware' => 'can:' . config('role.POST')], function () {
        Route::resource('post', 'PostProductController');
    });
    Route::group(['middleware' => 'can:' . config('role.STATISTIC')], function () {
        Route::get('static', 'StaticController@index')->name('static.index');
    });
    Route::group(['middleware' => 'can:' . config('role.SLIDER')], function () {
        Route::resource('slider', 'SliderController');
    });
    Route::group(['middleware' => 'can:' . config('role.INFO')], function () {
        Route::get('device', 'DeviceController@admin_device')->name('device.admin');
        Route::resource('visitor', 'VisitorController');
    });
    Route::group(['middleware' => 'can:' . config('role.ADMIN')], function () {
        Route::get('list', 'AdminController@list')->name('admin.list');
        Route::get('add', 'AdminController@add')->name('admin.add');
        Route::get('edit/{id}', 'AdminController@edit')->name('admin.edit');
        Route::post('update/{id}', 'AdminController@update')->name('admin.update');
        Route::post('store', 'AdminController@store')->name('admin.store');
        Route::get('delete/{id}', 'AdminController@destroy')->name('admin.delete');
    });
    Route::group(['middleware' => 'can:' . config('role.BRAND')], function () {
        Route::post('brand/sort', 'BrandController@sort');
        Route::resource('brand', 'BrandController');
    });
    Route::group(['middleware' => 'can:' . config('role.COUPON')], function () {
        Route::post('coupon/send', 'CouponController@send');
        Route::resource('coupon', 'CouponController');
    });
    Route::group(['middleware' => 'can:' . config('role.COMMENT')], function () {
        Route::group(['prefix' => 'comment'], function () {
            Route::get('/', 'CommentController@index')->name('comment.index');
            Route::get('not-confirm', 'CommentController@get_not_confirm')->name('comment.not_confirm');
            Route::get('confirm/{id}', 'CommentController@set_confirm')->name('comment.confirm');
            Route::post('delete', 'CommentController@delete')->name('comment.delete');
        });
    });
    Route::group(['middleware' => 'can:' . config('role.ORDER')], function () {
        Route::group(['prefix' => 'order'], function () {
            Route::get('/', 'OrderController@manage')->name('order.manage');
            Route::get('/{id}', 'OrderController@admin_detail')->name('order.admin_detail');
            Route::get('print-order/{id}', 'OrderController@print_order')->name('order.admin_print');
            Route::get('order-delete/{id}', 'OrderController@admin_delete')->name('order.admin_delete');
            Route::get('order-delivery/{id}', 'OrderController@delivery')->name('order.delivery');
        });
    });
    Route::group(['middleware' => 'can:' . config('role.FEESHIP')], function () {
        Route::group(['prefix' => 'delivery'], function () {
            Route::post('select', 'DeliveryController@select_delivery')->name('delivery.select');
            Route::get('/', 'DeliveryController@index')->name('delivery.index');
            Route::post('store', 'DeliveryController@store')->name('delivery.store');
            Route::post('show', 'DeliveryController@show')->name('delivery.show');
            Route::post('delete', 'DeliveryController@delete')->name('delivery.delete');
        });
    });
    Route::group(['middleware' => 'can:' . config('role.PRODUCT')], function () {
        Route::group(['prefix' => 'product'], function () {
            Route::get('reference', 'ProductController@reference')->name('product.reference');
            Route::get('gallery/{id}', 'ProductController@product_gallery')->name('product.gallery');
            Route::get('delete-gallery/{id}', 'ProductController@delete_gallery')->name('product.gallery.delete');
            Route::post('gallery-store/{id}', 'ProductController@product_gallery_store')->name('product.gallery.store');
            Route::post('get-product-crawl', 'ProductController@get_product_crawl')->name('product.get_product_crawl');
            Route::post('add-product-crawl', 'ProductController@add_product_crawl')->name('product.add_product_crawl');
        });
        Route::resource('product', 'ProductController');
    });
    Route::group(['middleware' => 'can:' . config('role.USER')], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@all_user')->name('user.list');
            Route::get('more/{id}', 'UserController@more_feature')->name('user.more');
            Route::post('unblock', 'UserController@unblock')->name('user.unblock');
            Route::post('block', 'UserController@block')->name('user.block');
            Route::post('delete', 'UserController@delete')->name('user.delete');
            Route::match(['get', 'post'], 'online', 'UserController@online_user')->name('user.online');
        });
        Route::get('device/{id}', 'DeviceController@user_device')->name('device.user');
        Route::group(['prefix' => 'chat'], function () {
            Route::post('get', 'ChatController@get_admin_chat');
            Route::post('send', 'ChatController@send_admin_chat');
        });
    });
});
