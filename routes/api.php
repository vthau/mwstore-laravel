<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['middleware' => ['visitor', 'user_online']], function () {
    Route::get('slider', 'Api\SliderController@get_slider')->name('slider.get');

    Route::group(['prefix' => 'message'], function () {
        Route::post('get-message', 'Api\MessageController@get_message');
        Route::post('new-message', 'Api\MessageController@new_message');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('new', 'Api\ProductController@get_product_new')->name('product.new');
        Route::get('more', 'Api\ProductController@get_product_more');
        Route::post('search', 'Api\ProductController@search');
        Route::get('feather', 'Api\ProductController@get_product_feather')->name('product.feather');
        Route::get('view', 'Api\ProductController@get_product_view')->name('product.feather');
        Route::get('{slug}', 'Api\ProductController@get_product')->name('product.get');
        Route::get('brand/{brand_id}', 'Api\ProductController@get_product_brand')->name('product.brand');
        Route::get('update/{slug}', 'Api\ProductController@update_view_product')->name('product.update');
    });

    Route::group(['prefix' => 'brand'], function () {
        Route::get('get', 'Api\BrandController@get_all_brand');
    });

    Route::group(['prefix' => 'signin'], function () {
        Route::post('/', 'Api\UserController@signin');
        Route::get('redirect/{social}', 'Api\SocialLoginController@social_redirect');
        Route::get('callback/{social}', 'Api\SocialLoginController@social_callback');
    });

    Route::post('signup', 'Api\UserController@signup');

    Route::group(['prefix' => 'comment'], function () {
        Route::post('product', 'Api\CommentController@get_product_comment');
    });

    Route::group(['prefix' => 'address'], function () {
        Route::get('get', 'Api\AddressController@get_address');
        Route::post('feeship', 'Api\AddressController@calc_feeship');
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::post('noti-guest', 'Api\NotificationController@noti_guest');
        Route::post('get-token', 'Api\NotificationController@get_token');
        Route::post('all-token', 'Api\NotificationController@all_token');
    });



    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('signout', 'Api\UserController@signout');
        Route::post('auth-token', 'Api\UserController@auth_token');

        Route::group(['prefix' => 'user'], function () {
            Route::post('update-profile', 'Api\UserController@update_profile');
            Route::post('update-avatar', 'Api\UserController@update_avatar');
            Route::post('update-password', 'Api\UserController@update_password');
        });

        Route::post('use-coupon', 'Api\CouponController@use_coupon');

        Route::post('notification/noti-user', 'Api\NotificationController@noti_user');

        Route::group(['prefix' => 'order'], function () {
            Route::get("/", 'Api\OrderController@index');
            Route::get("callback", 'Api\OrderController@callback');
            Route::get('detail/{id}', 'Api\OrderController@show');
            Route::post('new', 'Api\OrderController@new_order');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::post('get', 'Api\CommentController@get_comment');
            Route::post('new', 'Api\CommentController@update_comment');
            Route::post('update', 'Api\CommentController@update_comment');
            Route::post('delete', 'Api\CommentController@delete_comment');
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('get', 'Api\CartController@get_cart');
            Route::get('get-checked', 'Api\CartController@get_cart_checked');
            Route::post('new', 'Api\CartController@store');
            Route::post('checked', 'Api\CartController@checked');
            Route::post('delete', 'Api\CartController@delete');
        });

        Route::group(['prefix' => 'activity'], function () {
            Route::get('get-activity', 'Api\ActivityController@get_activity');
        });

        Route::group(['prefix' => 'export'], function () {
            Route::get('order/{code}', 'Api\OrderController@print_order');
        });
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['auth:admin_api']], function () {
        Route::post('auth-token', 'Api\AdminController@auth_token');
        Route::post('update-profile', 'Api\AdminController@update_profile');
        Route::post('update-password', 'Api\AdminController@update_password');
        Route::post('update-admin', 'Api\AdminController@update_admin');
        Route::post('new-admin', 'Api\AdminController@new_admin');
        Route::post('delete-admin', 'Api\AdminController@delete_admin');
        Route::post('signin', 'Api\AdminController@signin');
        Route::post('signout', 'Api\AdminController@signout');
        Route::get('all-admin', 'Api\AdminController@all_admin');

        Route::group(['prefix' => 'brand'], function () {
            Route::get('all-brand', 'Api\BrandController@get_all_brand');
            Route::post('update-brand', 'Api\BrandController@update_brand');
            Route::post('delete-brand', 'Api\BrandController@delete_brand');
        });

        Route::group(['prefix' => 'coupon'], function () {
            Route::get('all-coupon', 'Api\CouponController@all_coupon');
            Route::post('new-coupon', 'Api\CouponController@new_coupon');
            Route::post('send-coupon', 'Api\CouponController@send_coupon');
            Route::post('update-coupon', 'Api\CouponController@update_coupon');
            Route::post('delete-coupon', 'Api\CouponController@delete_coupon');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::get('all-comment', 'Api\CommentController@all_comment');
            Route::get('notconfirm-comment', 'Api\CommentController@notconfirm_comment');
            Route::post('update-comment', 'Api\CommentController@confirm_comment');
            Route::post('delete-comment', 'Api\CommentController@delete_comment_admin');
        });

        Route::group(['prefix' => 'activity'], function () {
            Route::get('get-activity', 'Api\ActivityController@get_activity');
            Route::get('all-activity', 'Api\ActivityController@all_activity');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('all-user', 'Api\UserController@all_user');
            Route::post('delete-user', 'Api\UserController@delete_user');
        });

        Route::group(['prefix' => 'permission'], function () {
            Route::get('all-permission', 'Api\PermissionController@all_permission');
        });

        Route::group(['prefix' => 'role'], function () {
            Route::get('all-role', 'Api\RoleController@all_role');
            Route::post('get-role', 'Api\RoleController@get_role');
            Route::post('new-role', 'Api\RoleController@new_role');
            Route::post('update-role', 'Api\RoleController@update_role');
            Route::post('delete-role', 'Api\RoleController@delete_role');
        });

        Route::group(['prefix' => 'address'], function () {
            Route::get('all-address', 'Api\AddressController@get_address');
        });

        Route::group(['prefix' => 'feeship'], function () {
            Route::get('all-feeship', 'Api\FeeshipController@all_feeship');
            Route::post('new-feeship', 'Api\FeeshipController@new_feeship');
            Route::post('delete-feeship', 'Api\FeeshipController@delete_feeship');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('all-order', 'Api\OrderController@all_order');
            Route::post('confirm-order', 'Api\OrderController@confirm_order');
            Route::post('detail-order', 'Api\OrderController@order_detail');
            Route::post('delete-order', 'Api\OrderController@delete_order');
        });

        Route::group(['prefix' => 'slider'], function () {
            Route::get('all-slider', 'Api\SliderController@all_slider');
            Route::post('new-slider', 'Api\SliderController@new_slider');
            Route::post('update-slider', 'Api\SliderController@update_slider');
            Route::post('delete-slider', 'Api\SliderController@delete_slider');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('all-product', 'Api\ProductController@all_product');
            Route::get('top-product', 'Api\ProductController@top_product');
            Route::post('product-crawl', 'Api\ProductController@product_crawl');
            Route::post('add-product-crawl', 'Api\ProductController@add_product_crawl');
            Route::post('new-product', 'Api\ProductController@new_product');
            Route::post('update-product', 'Api\ProductController@update_product');
            Route::post('delete-product', 'Api\ProductController@delete_product');
            Route::get('not-post', 'Api\ProductController@product_not_post');
        });

        Route::group(['prefix' => 'visitor'], function () {
            Route::get('all-visitor', 'Api\VisitorController@all_visitor');
            Route::get('count-visitor', 'Api\VisitorController@count_visitor');
            Route::get('device-visitor', 'Api\VisitorController@device_visitor');
        });

        Route::group(['prefix' => 'post'], function () {
            Route::get('all-post', 'Api\PostProductController@all_post');
            Route::post('get-post', 'Api\PostProductController@get_post');
            Route::post('update-post', 'Api\PostProductController@update_post');
            Route::post('delete-post', 'Api\PostProductController@delete_post');
        });

        Route::group(['prefix' => 'gallery'], function () {
            Route::post('gallery-product', 'Api\GalleryController@gallery_product');
            Route::post('new-gallery', 'Api\GalleryController@new_gallery');
            Route::post('delete-gallery', 'Api\GalleryController@delete_gallery');
        });

        Route::group(['prefix' => 'statistic'], function () {
            Route::post('get-statistic', 'Api\StatisticController@get_statistic');
            Route::post('filter-date', 'Api\StatisticController@filter_date');
            Route::post('filter-other', 'Api\StatisticController@filter_other');
            Route::post('count-general', 'Api\StatisticController@count_general');
        });

        Route::group(['prefix' => 'import'], function () {
            Route::post('brand', 'Api\BrandController@import_excel');
            Route::post('coupon', 'Api\CouponController@import_excel');
        });

        Route::group(['prefix' => 'message'], function () {
            Route::post('get-message', 'Api\MessageController@get_message');
            Route::post('new-message', 'Api\MessageController@new_message');
        });

        Route::group(['prefix' => 'export'], function () {
            Route::get('brand', 'Api\BrandController@export_excel');
            Route::get('coupon', 'Api\CouponController@export_excel');
            Route::get('user', 'Api\UserController@export_excel');
            Route::get('visitor', 'Api\VisitorController@export_excel');
            Route::get('order/{code}', 'Api\OrderController@print_order');
        });
    });

    Route::post('signin', 'Api\AdminController@signin');
});
