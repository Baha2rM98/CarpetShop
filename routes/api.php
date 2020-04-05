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


Route::middleware(['auth:admin', 'throttle:80,1'])->prefix('/administrator')->group(function () {


    Route::get('/categories', 'Backend\ProductController@apiVueJsGetCategories');


    Route::post('/category/attributes', 'Backend\ProductController@apiVueJsGetCategoryAttributes');
});


Route::middleware('throttle:80,1')->group(function () {


    Route::get('/cities/{provinceId}', 'Auth\RegisterController@getAllCities');


    Route::get('/provinces', 'Auth\RegisterController@getAllProvinces');


    Route::get('/category/{id}/products', 'Frontend\ProductController@apiVueJsGetProductsByCategory');


    Route::get('/category/{id}/products-sorted/{sort}',
        'Frontend\ProductController@apiVueJsGetSortedProductsByCategory');
});
