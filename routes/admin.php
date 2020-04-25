<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where we can register Admin routes for our application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "web" and "api" middleware groups. Enjoy building your Admin!
|
*/

Route::middleware('web')->group(function () {


    Route::get('/register', 'AuthAdmin\AdminRegisterController@showRegistrationForm')->name('admin.register.form');


    Route::post('/register', 'AuthAdmin\AdminRegisterController@register')->name('admin.register');


    Route::get('/login', 'AuthAdmin\AdminLoginController@showLoginForm')->name('admin.login.form');


    Route::post('/login', 'AuthAdmin\AdminLoginController@login')->name('admin.login');


    Route::post('/logout', 'AuthAdmin\AdminLoginController@logout')->name('admin.logout');


    Route::middleware('auth:admin')->group(function () {


        Route::get('/', 'Admin\AdminController@dashboard')->name('admin.dashboard');


        Route::get('/latest/orders', 'Admin\AdminController@latestOrders')->name('admin.latest.orders.index');


        Route::get('/latest/comments', 'Admin\AdminController@latestComments')->name('admin.latest.comments.index');


        Route::get('/registered/users', 'Admin\AdminController@registeredUsers')->name('registered.users');


        Route::patch('/user/{id}/change', 'Admin\AdminController@changeUserStatus')->name('change.user.status');


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


        Route::get('/orders', 'Admin\OrderController@getOrders')->name('admin.order.index');


        Route::get('/order/{id}/products', 'Admin\OrderController@getOrderDetails')->name('admin.order.products');
    });
});


Route::prefix('/api')->middleware('api')->group(function () {


    Route::middleware(['auth:admin', 'throttle:80,1'])->group(function () {


        Route::get('/categories', 'Admin\ProductController@apiVueJsGetCategories');


        Route::post('/category/attributes', 'Admin\ProductController@apiVueJsGetCategoryAttributes');
    });
});
