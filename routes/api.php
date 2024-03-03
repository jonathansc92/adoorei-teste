<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'ProductController@index');
        Route::get('/{product}', 'ProductController@show');
        Route::post('/', 'ProductController@store');
        Route::put('/{product}', 'ProductController@update');
        Route::delete('/{product}', 'ProductController@destroy');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', 'OrderController@index');
        Route::get('/{order}', 'OrderController@show');
        Route::post('/', 'OrderController@store');
        Route::post('/cancel/{id}', 'OrderController@cancel');
        Route::post('/add/product', 'OrderController@addProduct');
    });
});
