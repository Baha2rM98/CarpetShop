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


Route::middleware('throttle:80,1')->group(function () {


    Route::get('/cities/{provinceId}', 'Auth\RegisterController@getAllCities');


    Route::get('/provinces', 'Auth\RegisterController@getAllProvinces');


    Route::get('/category/{id}/products', 'Shop\ProductController@apiVueJsGetProductsByCategory');


    Route::get('/category/{id}/products-sorted/{sort}', 'Shop\ProductController@apiVueJsGetSortedProductsByCategory');


    Route::get('/category/{id}/attributes', 'Shop\ProductController@apiVueJsGetCategoryAttribute');


    Route::get('/category/{id}/filtered-products/{attributes}/{sort}', 'Shop\ProductController@apiVueJsGetFilteredProducts');
});
