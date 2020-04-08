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


        Route::get('/', 'Backend\AdminController@dashboard');


        Route::resource('/categories', 'Backend\CategoryController');


        Route::get('/category/{id}/attributes', 'Backend\CategoryController@indexAttributes')->name('category.attributes');


        Route::post('/category/{id}/attributes', 'Backend\CategoryController@saveAttributes');


        Route::resource('/attribute-groups', 'Backend\AttributeGroupController');


        Route::resource('/attribute-values', 'Backend\AttributeValueController');


        Route::resource('/brands', 'Backend\BrandController');


        Route::post('/photos/upload', 'Backend\PhotoController@uploadPhoto')->name('photos.upload');


        Route::resource('/products', 'Backend\ProductController');


        Route::resource('/coupons', 'Backend\CouponController');
    });
});


Route::get('/', 'Frontend\ShopHomeController@index');


Route::get('/product/{slug}', 'Frontend\ProductController@getProduct')->name('product.introduce');


Route::get('/category/{id}/products', 'Frontend\ProductController@getProductsByCategory')->name('category.index');


Auth::routes();
Route::post('/register', 'Auth\RegisterController@register')->name('user.register');


Route::get('/add-to-cart/{id}', 'Frontend\CartController@addToCart')->name('cart.add');


Route::post('/remove-cart-item/{id}', 'Frontend\CartController@removeItem')->name('cart.remove');


Route::get('/shopping-cart', 'Frontend\CartController@getCart')->name('cart.cart');


Route::middleware('auth')->group(function () {


    Route::get('/dashboard', 'Frontend\UserController@dashboard')->name('user.dashboard');


    Route::post('/apply-coupon', 'Frontend\CouponController@applyCoupon')->name('coupon.apply');

    // Checkout
});
