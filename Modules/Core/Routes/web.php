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
    Route::get('/user/index', 'UserController@index');
    Route::get('/user/register', 'UserController@create');
    Route::get('/user/register/{id}', 'UserController@show');

    Route::get('/role/index', 'RoleController@index');
    Route::get('/role/register', 'RoleController@create');
    Route::get('/role/register/{id}', 'RoleController@show');
    Route::get('/role/user/{role} ', 'RoleController@user');
    Route::get('/role/userPagePermissions ', 'RoleController@userPagePermissions');

    Route::get('/parameter/index', 'ParameterController@index');

    Route::get('/page/index', 'PageController@index');
});
