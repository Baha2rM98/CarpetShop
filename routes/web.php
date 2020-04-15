<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;

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


Route::domain(Helper::getApplicationSubDomain())->group(function () {


    Route::get('/register', 'AuthAdmin\AdminRegisterController@showRegistrationForm')->name('admin.register.form');


    Route::post('/register', 'AuthAdmin\AdminRegisterController@register')->name('admin.register');


    Route::get('/login', 'AuthAdmin\AdminLoginController@showLoginForm')->name('admin.login.form');


    Route::post('/login', 'AuthAdmin\AdminLoginController@login')->name('admin.login');


    Route::post('/logout', 'AuthAdmin\AdminLoginController@logout')->name('admin.logout');


    Route::middleware('auth:admin')->group(function () {


        Route::get('/', 'Admin\AdminController@dashboard')->name('admin.dashboard');


        Route::resource('/categories', 'Admin\CategoryController');


        Route::get('/category/{id}/attributes', 'Admin\CategoryController@indexAttributes')->name('category.attributes');


        Route::post('/category/{id}/attributes', 'Admin\CategoryController@saveAttributes');


        Route::resource('/attribute-groups', 'Admin\AttributeGroupController');


        Route::resource('/attribute-values', 'Admin\AttributeValueController');


        Route::resource('/brands', 'Admin\BrandController');


        Route::post('/photos/upload', 'Admin\PhotoController@uploadPhoto')->name('photos.upload');


        Route::resource('/products', 'Admin\ProductController');


        Route::resource('/coupons', 'Admin\CouponController');


        Route::get('/comments', 'Admin\CommentController@viewComments')->name('comment.index');


        Route::post('/comment/{id}', 'Admin\CommentController@confirmComment')->name('comment.confirmation');


        Route::get('/orders', 'Admin\OrderController@getOrders')->name('order.index');
    });
});


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


    Route::post('/favorite/add/{id}', 'Shop\UserController@addToFavorite')->name('favorite.add');


    Route::get('/favorites', 'Shop\UserController@getFavorites')->name('favorite.index');


    Route::post('/favorite/delete/{id}', 'Shop\UserController@deleteFromFavorites')->name('favorite.delete');
    

    // Checkout
});
