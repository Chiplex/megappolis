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

Route::prefix('core/')->group(function() {
    Route::get('/User/Index', 'UserController@index');
    Route::get('/User/Register', 'UserController@register');

    Route::get('/Role/Index', 'RoleController@index');
    Route::get('/Role/UserPagePermissions ', 'RoleController@userPagePermissions');

    Route::get('/Parameter/Index', 'ParameterController@index');

    Route::get('/Page/Index', 'PageController@index');
});
