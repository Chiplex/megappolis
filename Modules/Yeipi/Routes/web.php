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

    Route::get('/pedir/index', 'PedirController@index')->name('yeipi.pedir.index')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/register', 'PedirController@create')->name('yeipi.pedir.create')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/pedir/register', 'PedirController@store')->name('yeipi.pedir.store')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/register/{order}', 'PedirController@edit')->name('yeipi.pedir.edit')->middleware('access:YEIPI-CUSTOMER');
    Route::put('/pedir/register/{order}', 'PedirController@update')->name('yeipi.pedir.update')->middleware('access:YEIPI-CUSTOMER');

    Route::get('/entregar/index', 'PedirController@index')->name('yeipi.entregar.index')->middleware('access:YEIPI-DELIVERY');
    Route::get('/proveer/index', 'PedirController@index')->name('yeipi.proveer.index')->middleware('access:YEIPI-PROVIDER');

    Route::post('/customer/store', 'CustomerController@store')->name('yeipi.customer.store');
    Route::post('/delivery/store', 'DeliveryController@store')->name('yeipi.delivery.store');
    Route::post('/yeipi/store', 'ShopController@store')->name('yeipi.shop.store');
});
