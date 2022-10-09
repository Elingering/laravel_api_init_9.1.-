<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('App\Http\Controllers\Api')->prefix('v1')->middleware('cors')->group(function () {
    Route::middleware('api.guard')->group(function () {
        //用户注册
        Route::post('/users', 'UserController@store')->name('users.store');
        //用户登录
        Route::post('/login', 'UserController@login')->name('users.login');
        Route::middleware('api.refresh')->group(function () {
            //当前用户信息
            Route::get('/users/info', 'UserController@info')->name('users.info');
            //用户列表
            Route::get('/users', 'UserController@index')->name('users.index');
            //用户信息
            Route::get('/users/{user}', 'UserController@show')->name('users.show');
            //用户退出
            Route::get('/logout', 'UserController@logout')->name('users.logout');
        });
    });

    Route::middleware('auser.guard')->group(function () {
        //auser 注册
        Route::post('/ausers', 'AuserController@store')->name('ausers.store');
        //auser 登录
        Route::post('/ausers/login', 'AuserController@login')->name('ausers.login');
        Route::middleware('auser.refresh')->group(function () {
            //当前auser 信息
            Route::get('/ausers/info', 'AuserController@info')->name('ausers.info');
            //auser 列表
            Route::get('/ausers', 'AuserController@index')->name('ausers.index');
            //auser 信息
            Route::get('/ausers/{user}', 'AuserController@show')->name('ausers.show');
            //auser 退出
            Route::get('/ausers/logout', 'AuserController@logout')->name('ausers.logout');
        });
    });

});
