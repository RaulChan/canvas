<?php

use Canvas\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::namespace('Canvas\Http\Controllers')->group(function () {
    Route::prefix(config('canvas.path'))->middleware(config('canvas.middleware'))->group(function () {
        Route::prefix('api')->group(function () {
            Route::prefix('locale')->group(function () {
                Route::get('{code}', 'LocaleController');
            });

            Route::prefix('uploads')->group(function () {
                Route::post('/', 'UploadsController@store');
                Route::delete('/', 'UploadsController@destroy');
            });

            Route::prefix('posts')->group(function () {
                Route::get('/', 'PostController@index');
                Route::get('{id?}', 'PostController@show');
                Route::post('{id}', 'PostController@store');
                Route::delete('{id}', 'PostController@destroy');
            });

            Route::prefix('stats')->group(function () {
                Route::get('/', 'StatsController@index');
                Route::get('{id}', 'StatsController@show');
            });

            Route::prefix('tags')->middleware([Admin::class])->group(function () {
                Route::get('/', 'TagController@index');
                Route::get('{id?}', 'TagController@show');
                Route::post('{id}', 'TagController@store');
                Route::delete('{id}', 'TagController@destroy');
            });

            Route::prefix('topics')->middleware([Admin::class])->group(function () {
                Route::get('/', 'TopicController@index');
                Route::get('{id?}', 'TopicController@show');
                Route::post('{id}', 'TopicController@store');
                Route::delete('{id}', 'TopicController@destroy');
            });

            Route::prefix('users')->group(function () {
                Route::get('/', 'UserController@index')->middleware([Admin::class]);
                Route::get('{id}', 'UserController@show');
                Route::post('{id}', 'UserController@update');
            });
        });

        Route::get('/{view?}', 'ViewController')->where('view', '(.*)')->name('canvas');
    });
});
