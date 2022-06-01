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
    Route::get('/', 'HomeController@index')->name('core');

    Route::get('/user/index', 'UserController@index')->name('core.user.index');
    Route::get('/user/register', 'UserController@create')->name('core.user.create');
    Route::post('/user/register', 'UserController@store')->name('core.user.store');
    Route::get('/user/register/{user}', 'UserController@edit')->name('core.user.edit');
    Route::put('/user/register/{user}', 'UserController@update')->name('core.user.update');

    Route::get('/role/index', 'RoleController@index')->name('core.role.index');
    Route::get('/role/register', 'RoleController@create')->name('core.role.create');
    Route::post('/role/register', 'RoleController@store')->name('core.role.store');
    Route::get('/role/register/{role}', 'RoleController@edit')->name('core.role.edit');
    Route::put('/role/register/{role}', 'RoleController@update')->name('core.role.update');

    Route::get('/role/user/{role} ', 'RoleController@user')->name('core.role.user');
    Route::get('/role/user-page-permissions/{role}', 'RoleController@show')->name('core.role.show');

    Route::get('/permission/index', 'PermissionController@index')->name('core.permission.index');
    Route::get('/permission/register', 'PermissionController@create')->name('core.permission.create');
    Route::post('/permission/register', 'PermissionController@store')->name('core.permission.store');
    Route::get('/permission/register/{permission}', 'PermissionController@edit')->name('core.permission.edit');
    Route::put('/permission/register/{permission}', 'PermissionController@update')->name('core.permission.update');

    Route::get('/app/index', 'AppController@index')->name('core.app.index');
    Route::get('/app/register', 'AppController@create')->name('core.app.create');
    Route::post('/app/register', 'AppController@store')->name('core.app.store');
    Route::get('/app/register/{app}', 'AppController@edit')->name('core.app.edit');
    Route::put('/app/register/{app}', 'AppController@update')->name('core.app.update');
    Route::get('/app/approve/{app}', 'AppController@approve')->name('core.app.approve');
    Route::get('/app/block/{app}', 'AppController@block')->name('core.app.block');

    Route::get('/page/index', 'PageController@index')->name('core.page.index');
    Route::get('/page/register', 'PageController@create')->name('core.page.create');
    Route::post('/page/register', 'PageController@store')->name('core.page.store');
    Route::get('/page/register/{page}', 'PageController@edit')->name('core.page.edit');
    Route::put('/page/register/{page}', 'PageController@update')->name('core.page.update');
    Route::get('/page/data/', 'PageController@data')->name('core.page.data');

    Route::get('/people/index', 'PeopleController@index')->name('core.people.index');
    Route::get('/people/register', 'PeopleController@create')->name('core.people.create');
    Route::post('/people/register', 'PeopleController@store')->name('core.people.store');
    Route::get('/people/register/{page}', 'PeopleController@edit')->name('core.people.edit');
    Route::put('/people/register/{page}', 'PeopleController@update')->name('core.people.update');
});
