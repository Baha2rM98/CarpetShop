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

Route::prefix('/administrator')->group(function () {
    Route::get('/categories', 'Backend\ProductController@apiVueJsGetCategories');
    Route::post('/categories/attributes', 'Backend\ProductController@apiVueJsGetCategoriesAttributes');
});

Route::get('/cities/{provinceId}', 'Frontend\UserController@getAllCities');
Route::get('/provinces', 'Frontend\UserController@getAllProvinces');
