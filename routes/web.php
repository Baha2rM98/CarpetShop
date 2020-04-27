<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/', 'Shop\ShopHomeController@index');


Route::get('/product/{sku}', 'Shop\ProductController@getProduct')->name('product.introduce');


Route::get('/category/{slug}/products', 'Shop\ProductController@getProductsByCategory')->name('category.index');


Auth::routes();
Route::post('/register', 'Auth\RegisterController@register')->name('user.register');


Route::get('/recovery', 'Auth\ResetPasswordController@recoveryView')->name('recovery');


Route::post('/verify', 'Auth\ResetPasswordController@verifyEmail')->name('verify.email');


Route::get('/recover/{email}', 'Auth\ResetPasswordController@recoverPasswordView')->name('recover.password.view');


Route::post('/recover/{email}', 'Auth\ResetPasswordController@recoverPassword')->name('recover.password');


Route::get('/cart/add/{id}', 'Shop\CartController@addToCart')->name('cart.add');


Route::post('/remove/from/cart/{id}', 'Shop\CartController@removeItem')->name('cart.remove');


Route::get('/cart', 'Shop\CartController@getCart')->name('cart.cart');


Route::middleware('auth')->group(function () {
    Route::post('/apply-coupon', 'Shop\CouponController@applyCoupon')->name('coupon.apply');


    Route::post('/post-comment/{productId}', 'Shop\CommentController@saveComment')->name('comment.post');


    Route::get('/profile', 'Shop\UserController@profile')->name('user.dashboard');


    Route::get('/profile/edit', 'Shop\UserController@editProfile')->name('profile.edit');


    Route::post('/profile/edit', 'Shop\UserController@updateProfile')->name('profile.update');


    Route::get('/profile/change/password', 'Auth\ResetPasswordController@editPassword')->name('password.edit');


    Route::post('/profile/change/password', 'Auth\ResetPasswordController@updatePassword')->name('password.update.post');


    Route::post('/profile/favorite/add/{id}', 'Shop\UserController@addToFavorite')->name('favorite.add');


    Route::get('/profile/favorites', 'Shop\UserController@getFavorites')->name('favorite.index');


    Route::post('/profile/favorite/{id}', 'Shop\UserController@deleteFromFavorites')->name('favorite.delete');


    Route::get('/profile/addresses', 'Shop\UserController@getAddresses')->name('address.index');


    Route::get('/profile/address/create', 'Shop\UserController@createAddressView')->name('address.create');


    Route::post('/profile/address/create', 'Shop\UserController@storeAddress')->name('address.store');


    Route::get('/profile/address/edit/{id}', 'Shop\UserController@editAddressView')->name('address.edit');


    Route::post('/profile/address/edit/{id}', 'Shop\UserController@updateAddress')->name('address.update');


    Route::post('/profile/address/{id}', 'Shop\UserController@deleteAddress')->name('address.delete');


    Route::get('/profile/orders', 'Shop\UserController@getOrders')->name('order.index');


    Route::get('/profile/order/{id}/products', 'Shop\UserController@getOrderDetails')->name('order.details');


    Route::get('/profile/reckoning/{id}', 'Shop\UserController@reckoningUnpaid')->name('reckoning.unpaid');


    Route::get('/profile/checkout/{id}', 'Shop\UserController@paymentVerification')->name('unpaid.order.verified');


    Route::post('/profile/delete/order/{id}', 'Shop\UserController@removeUnpaidOrder')->name('remove.order');


    Route::get('/order/verification', 'Shop\OrderController@orderVerification')->name('order.verified');


    Route::get('/order/failed', 'Shop\OrderController@orderFailure')->name('order.failure');


    Route::get('/checkout/{id}', 'Shop\PaymentController@paymentVerification')->name('payment.verified');
});
