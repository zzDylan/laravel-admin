<?php

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

Route::get('/', function () {
    dd(config('admin'));
    return view('welcome');
});
Route::get('/test3', 'Admin\MenuController@test3');
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('logout', 'AuthController@getLogout');

    Route::group(['middleware' => 'login'], function () {
        Route::get('/', function() {
            return view('admin.index');
        });
        //菜单管理
        Route::group(['prefix' => 'menu'], function () {
            Route::post('nestable', 'MenuController@nestable');
            Route::resource('/', 'MenuController', ['except' => ['create', 'show']]);
        });
    });
});
