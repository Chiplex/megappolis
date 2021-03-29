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

Route::prefix('core/')->middleware(['auth', 'access:CORE-MEGAPPOLIS'])->group(function() {
    Route::get('/user/index/{hola}', 'UserController@index');
    Route::get('/user/register', 'UserController@register');

    Route::get('/role/index', 'RoleController@index');
    Route::get('/role/userPagePermissions ', 'RoleController@userPagePermissions');

    Route::get('/parameter/index', 'ParameterController@index');

    Route::get('/page/index', 'PageController@index');
});
