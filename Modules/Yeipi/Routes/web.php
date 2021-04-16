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

    Route::get('/entregar/index', 'EntregarController@index')->name('yeipi.entregar.index')->middleware('access:YEIPI-DELIVERY');
    Route::get('/entregar/register', 'EntregarController@create')->name('yeipi.entregar.create')->middleware('access:YEIPI-DELIVERY');
    Route::post('/entregar/register', 'EntregarController@store')->name('yeipi.entregar.store')->middleware('access:YEIPI-DELIVERY');
    Route::get('/entregar/register/{order}', 'EntregarController@edit')->name('yeipi.entregar.edit')->middleware('access:YEIPI-DELIVERY');
    Route::put('/entregar/register/{order}', 'EntregarController@update')->name('yeipi.entregar.update')->middleware('access:YEIPI-DELIVERY');

    Route::get('/proveer/index', 'ProveerController@index')->name('yeipi.proveer.index')->middleware('access:YEIPI-PROVIDER');
    Route::get('/proveer/register', 'ProveerController@create')->name('yeipi.proveer.create')->middleware('access:YEIPI-PROVIDER');
    Route::post('/proveer/register', 'ProveerController@store')->name('yeipi.proveer.store')->middleware('access:YEIPI-PROVIDER');
    Route::get('/proveer/register/{order}', 'ProveerController@edit')->name('yeipi.proveer.edit')->middleware('access:YEIPI-PROVIDER');
    Route::put('/proveer/register/{order}', 'ProveerController@update')->name('yeipi.proveer.update')->middleware('access:YEIPI-PROVIDER');

    Route::get('/detail/index', 'DetailController@index')->name('yeipi.detail.index')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/detail/register', 'DetailController@create')->name('yeipi.detail.create')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/detail/register', 'DetailController@store')->name('yeipi.detail.store')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/detail/register/{detail}', 'DetailController@edit')->name('yeipi.detail.edit')->middleware('access:YEIPI-CUSTOMER');
    Route::put('/detail/register/{detail}', 'DetailController@update')->name('yeipi.detail.update')->middleware('access:YEIPI-CUSTOMER');

    Route::get('/shop/index', 'ShopController@index')->name('yeipi.shop.index');
    Route::get('/shop/register', 'ShopController@create')->name('yeipi.shop.create');
    Route::post('/shop/register', 'ShopController@store')->name('yeipi.shop.store');
    Route::get('/shop/register/{shop}', 'ShopController@edit')->name('yeipi.shop.edit');
    Route::put('/shop/register/{shop}', 'ShopController@update')->name('yeipi.shop.update');

    Route::get('/delivery/index', 'DeliveryController@index')->name('yeipi.delivery.index');
    Route::get('/delivery/register', 'DeliveryController@create')->name('yeipi.delivery.create');
    Route::post('/delivery/register', 'DeliveryController@store')->name('yeipi.delivery.store');
    Route::get('/delivery/register/{delivery}', 'DeliveryController@edit')->name('yeipi.delivery.edit');
    Route::put('/delivery/register/{delivery}', 'DeliveryController@update')->name('yeipi.delivery.update');

    Route::get('/contract/index', 'ContractController@index')->name('yeipi.contract.index');
    Route::get('/contract/register', 'ContractController@create')->name('yeipi.contract.create');
    Route::post('/contract/register', 'ContractController@store')->name('yeipi.contract.store');
    Route::get('/contract/register/{contract}', 'ContractController@edit')->name('yeipi.contract.edit');
    Route::put('/contract/register/{contract}', 'ContractController@update')->name('yeipi.contract.update');

    Route::post('/customer/store', 'CustomerController@store')->name('yeipi.customer.store');
    Route::post('/delivery/store', 'DeliveryController@store')->name('yeipi.delivery.store');
    //Route::post('/shop/store', 'ProveerController@create')->name('yeipi.shop.store');
});