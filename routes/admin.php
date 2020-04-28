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


    Route::get('/login', 'AuthAdmin\AdminLoginController@showLoginForm')->name('admin.login.form');


    Route::post('/login', 'AuthAdmin\AdminLoginController@login')->name('admin.login');


    Route::post('/logout', 'AuthAdmin\AdminLoginController@logout')->name('admin.logout');


    Route::get('/recovery', 'AuthAdmin\ResetPasswordController@recoverPasswordView')->name('admin.recover.pass');


    Route::post('/recovery/send/code', 'AuthAdmin\ResetPasswordController@sendVerificationCode')->name('admin.send.Vcode');


    Route::get('/recovery/code/verification/{id}', 'AuthAdmin\ResetPasswordController@codeVerificationView')->name('admin.verify.code');


    Route::post('/recovery/code/verification/{id}', 'AuthAdmin\ResetPasswordController@codeVerification')->name('admin.verify.code.back');


    Route::get('/reset/password/{token}', 'AuthAdmin\ResetPasswordController@resetPasswordView')->name('admin.reset.pass');


    Route::post('/reset/password/{token}', 'AuthAdmin\ResetPasswordController@resetPassword')->name('admin.reset.pass.post');


    Route::middleware('auth:admin')->group(function () {


        Route::get('/', 'Admin\AdminController@dashboard')->name('admin.dashboard');


        Route::get('/latest/orders', 'Admin\AdminController@latestOrders')->name('admin.latest.orders.index');


        Route::get('/latest/comments', 'Admin\AdminController@latestComments')->name('admin.latest.comments.index');


        Route::get('/registered/users', 'Admin\AdminController@registeredUsers')->name('registered.users');


        Route::patch('/user/{id}/change', 'Admin\AdminController@changeUserStatus')->name('change.user.status');


        Route::get('/admins', 'Admin\AdminController@adminsIndex')->name('admins.index');


        Route::patch('/admin/{id}/change', 'Admin\AdminController@changeAdminStatus')->name('change.admin.status');


        Route::get('/admins/register', 'AuthAdmin\AdminRegisterController@showRegistrationForm')->name('admin.register.form');


        Route::post('/admins/register', 'AuthAdmin\AdminRegisterController@register')->name('admin.register');


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


        Route::get('/profile', 'Admin\AdminController@profileView')->name('admin.profile.view');


        Route::post('/edit/profile', 'Admin\AdminController@profileUpdate')->name('admin.profile.update');


        Route::get('/profile/reset/password', 'AuthAdmin\ResetPasswordController@profileUpdatePasswordView')->name('profile.update.pass.view');


        Route::post('/profile/reset/password', 'AuthAdmin\ResetPasswordController@profileUpdatePassword')->name('admin.profile.update.pass.real');
    });
});


Route::prefix('/api')->middleware('api')->group(function () {


    Route::middleware(['auth:admin', 'throttle:80,1'])->group(function () {


        Route::get('/categories', 'Admin\ProductController@apiVueJsGetCategories');


        Route::post('/category/attributes', 'Admin\ProductController@apiVueJsGetCategoryAttributes');
    });
});
