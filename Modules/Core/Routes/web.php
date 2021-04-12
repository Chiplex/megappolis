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
    Route::get('/', 'HomeController@index')->name('core.index');
    
    Route::get('/user/index', 'UserController@index')->name('core.user.index')->middleware(['app.creator']);
    Route::get('/user/register', 'UserController@create')->name('core.user.create')->middleware(['app.creator']);
    Route::post('/user/register', 'UserController@store')->name('core.user.store')->middleware(['app.creator']);
    Route::get('/user/register/{user}', 'UserController@edit')->name('core.user.edit')->middleware(['app.creator']);
    Route::put('/user/register/{user}', 'UserController@update')->name('core.user.update')->middleware(['app.creator']);

    Route::get('/role/index', 'RoleController@index')->name('core.role.index')->middleware(['app.creator']);
    Route::get('/role/register', 'RoleController@create')->name('core.role.create')->middleware(['app.creator']);
    Route::post('/role/register', 'RoleController@store')->name('core.role.store')->middleware(['app.creator']);
    Route::get('/role/register/{role}', 'RoleController@edit')->name('core.role.edit')->middleware(['app.creator']);
    Route::put('/role/register/{role}', 'RoleController@update')->name('core.role.update')->middleware(['app.creator']);

    Route::get('/role/user/{role} ', 'RoleController@user')->name('core.role.user')->middleware(['app.creator']);
    Route::get('/role/user-page-permissions/{role}', 'RoleController@show')->name('core.role.show')->middleware(['app.creator']);

    Route::get('/permission/index', 'PermissionController@index')->name('core.permission.index')->middleware(['app.creator']);
    Route::get('/permission/register', 'PermissionController@create')->name('core.permission.create')->middleware(['app.creator']);
    Route::post('/permission/register', 'PermissionController@store')->name('core.permission.store')->middleware(['app.creator']);
    Route::get('/permission/register/{permission}', 'PermissionController@edit')->name('core.permission.edit')->middleware(['app.creator']);
    Route::put('/permission/register/{permission}', 'PermissionController@update')->name('core.permission.update')->middleware(['app.creator']);

    Route::get('/app/index', 'AppController@index')->name('core.app.index')->middleware(['app.creator']);
    Route::get('/app/register', 'AppController@create')->name('core.app.create')->middleware(['app.creator']);
    Route::post('/app/register', 'AppController@store')->name('core.app.store')->middleware(['app.creator']);
    Route::get('/app/register/{app}', 'AppController@edit')->name('core.app.edit')->middleware(['app.creator']);
    Route::put('/app/register/{app}', 'AppController@update')->name('core.app.update')->middleware(['app.creator']);
    Route::get('/app/approve/{app}', 'AppController@approve')->name('core.app.approve');
    Route::get('/app/block/{app}', 'AppController@block')->name('core.app.block');

    Route::get('/page/index', 'PageController@index')->name('core.page.index')->middleware(['app.creator']);
    Route::get('/page/register', 'PageController@create')->name('core.page.create')->middleware(['app.creator']);
    Route::post('/page/register', 'PageController@store')->name('core.page.store')->middleware(['app.creator']);
    Route::get('/page/register/{page}', 'PageController@edit')->name('core.page.edit')->middleware(['app.creator']);
    Route::put('/page/register/{page}', 'PageController@update')->name('core.page.update')->middleware(['app.creator']);

    Route::get('/people/index', 'PeopleController@index')->name('core.people.index')->middleware(['app.creator']);
    Route::get('/people/register', 'PeopleController@create')->name('core.people.create')->middleware(['app.creator']);
    Route::post('/people/register', 'PeopleController@store')->name('core.people.store')->middleware(['app.creator']);
    Route::get('/people/register/{page}', 'PeopleController@edit')->name('core.people.edit')->middleware(['app.creator']);
    Route::put('/people/register/{page}', 'PeopleController@update')->name('core.people.update')->middleware(['app.creator']);
});
