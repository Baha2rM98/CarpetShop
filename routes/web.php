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


Route::get('/cart/add/{id}', 'Shop\CartController@addToCart')->name('cart.add');


Route::post('/remove/from/cart/{id}', 'Shop\CartController@removeItem')->name('cart.remove');


Route::get('/cart', 'Shop\CartController@getCart')->name('cart.cart');


Route::middleware('auth')->group(function () {


    Route::get('/profile', 'Shop\UserController@profile')->name('user.dashboard');


    Route::post('/apply-coupon', 'Shop\CouponController@applyCoupon')->name('coupon.apply');


    Route::post('/post-comment/{productId}', 'Shop\CommentController@saveComment')->name('comment.post');


    Route::post('/profile/favorite/add/{id}', 'Shop\UserController@addToFavorite')->name('favorite.add');


    Route::get('/profile/favorites', 'Shop\UserController@getFavorites')->name('favorite.index');


    Route::post('/profile/favorite/delete/{id}', 'Shop\UserController@deleteFromFavorites')->name('favorite.delete');


    Route::get('/payment-verified', 'Shop\OrderController@paymentVerified')->name('payment.verified');


    // Checkout
});
