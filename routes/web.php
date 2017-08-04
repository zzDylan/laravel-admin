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
    for($i=0;$i<50;$i++){
        App\Models\Admin::create([
            'username'=>'zz'.$i,
            'name'=>'zz'.$i,
            'password'=> bcrypt('123456'),
        ]);
    }
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
        Route::post('menu/nestable', 'MenuController@nestable');
        Route::resource('menu', 'MenuController', ['except' => ['create', 'show']]);
        Route::post('user/batch_destroy', 'UserController@batchDestroy');
        Route::resource('user', 'UserController');
    });
});
