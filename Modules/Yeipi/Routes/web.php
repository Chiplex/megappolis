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

Route::prefix('yeipi')->middleware(['auth'])->group(function() {
    Route::get('/', 'HomeController@index');

    Route::get('/pedir/index', 'PedirController@index')->name('yeipi.pedir.index')->middleware(['app.creator']);
    Route::post('/customer/store', 'CustomerController@store')->name('yeipi.customer.store');
});
