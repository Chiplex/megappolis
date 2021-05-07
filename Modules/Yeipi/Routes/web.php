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
    Route::get('/', 'HomeController@index')->name('yeipi');
    Route::get('/home/register/{yeipi}', 'HomeController@create')->name('yeipi.home.create');
    Route::post('/home/register', 'HomeController@store')->name('yeipi.home.store');

    Route::get('/pedir/iniciar', 'PedirController@preparar')->name('yeipi.pedir.preparar')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/pedir/iniciar', 'PedirController@iniciar')->name('yeipi.pedir.iniciar')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/index', 'PedirController@index')->name('yeipi.pedir.index')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/data/index/{order}', 'PedirController@data')->name('yeipi.pedir.data')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/register', 'PedirController@create')->name('yeipi.pedir.create')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/pedir/register', 'PedirController@store')->name('yeipi.pedir.store')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/register/{order}', 'PedirController@edit')->name('yeipi.pedir.edit')->middleware('access:YEIPI-CUSTOMER');
    Route::put('/pedir/register/{order}', 'PedirController@update')->name('yeipi.pedir.update')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/entregas', 'PedirController@entregas')->name('yeipi.pedir.entregas')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/pedir/producto', 'PedirController@producto')->name('yeipi.pedir.producto')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/shop/{product}', 'PedirController@shop')->name('yeipi.pedir.shop')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/count', 'PedirController@count')->name('yeipi.pedir.count')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/history', 'PedirController@history')->name('yeipi.pedir.history')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/data/history', 'PedirController@dataHistory')->name('yeipi.pedir.data.history')->middleware('access:YEIPI-CUSTOMER');

    Route::get('/entregar/iniciar', 'EntregarController@preparar')->name('yeipi.entregar.preparar')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/entregar/iniciar', 'EntregarController@iniciar')->name('yeipi.entregar.iniciar')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/entregar/index', 'EntregarController@index')->name('yeipi.entregar.index')->middleware('access:YEIPI-DELIVERY');
    Route::get('/entregar/register', 'EntregarController@create')->name('yeipi.entregar.create')->middleware('access:YEIPI-DELIVERY');
    Route::post('/entregar/register', 'EntregarController@store')->name('yeipi.entregar.store')->middleware('access:YEIPI-DELIVERY');
    Route::get('/entregar/register/{order}', 'EntregarController@edit')->name('yeipi.entregar.edit')->middleware('access:YEIPI-DELIVERY');
    Route::put('/entregar/register/{order}', 'EntregarController@update')->name('yeipi.entregar.update')->middleware('access:YEIPI-DELIVERY');
    Route::put('/entregar/conseguido/{detail}', 'EntregarController@conseguido')->name('yeipi.entregar.conseguido')->middleware('access:YEIPI-DELIVERY');
    Route::put('/entregar/no-conseguido/{detail}', 'EntregarController@noConseguido')->name('yeipi.entregar.no-conseguido')->middleware('access:YEIPI-DELIVERY');
    Route::put('/entregar/ahora/{order}', 'EntregarController@ahora')->name('yeipi.entregar.ahora')->middleware('access:YEIPI-DELIVERY');

    Route::get('/proveer/iniciar', 'ProveerController@preparar')->name('yeipi.proveer.preparar')->middleware('access:YEIPI-PROVIDER');
    Route::post('/proveer/iniciar', 'ProveerController@iniciar')->name('yeipi.proveer.iniciar')->middleware('access:YEIPI-PROVIDER');
    Route::get('/proveer/index', 'ProveerController@index')->name('yeipi.proveer.index')->middleware('access:YEIPI-PROVIDER');
    Route::get('/proveer/register', 'ProveerController@create')->name('yeipi.proveer.create')->middleware('access:YEIPI-PROVIDER');
    Route::post('/proveer/register', 'ProveerController@store')->name('yeipi.proveer.store')->middleware('access:YEIPI-PROVIDER');
    Route::get('/proveer/register/{shop}', 'ProveerController@edit')->name('yeipi.proveer.edit')->middleware('access:YEIPI-PROVIDER');
    Route::put('/proveer/register/{stock}', 'ProveerController@update')->name('yeipi.proveer.update')->middleware('access:YEIPI-PROVIDER');
    Route::get('/proveer/data/{shop}', 'ProveerController@data')->name('yeipi.proveer.data');
    Route::get('/proveer/data/stock', 'ProveerController@dataStock')->name('yeipi.proveer.data.stock');
    Route::get('/proveer/data/customer', 'ProveerController@datacustomer')->name('yeipi.proveer.data.customer');

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

    Route::get('/product/index', 'ProductController@index')->name('yeipi.product.index');
    Route::get('/product/register', 'ProductController@create')->name('yeipi.product.create');
    Route::post('/product/register', 'ProductController@store')->name('yeipi.product.store');
    Route::get('/product/register/{product}', 'ProductController@edit')->name('yeipi.product.edit');
    Route::put('/product/register/{product}', 'ProductController@update')->name('yeipi.product.update');
    Route::delete('/product/register/{product}', 'ProductController@destroy')->name('yeipi.product.delete');
    Route::get('/product/data/', 'ProductController@data')->name('yeipi.product.data');

    Route::post('/customer/store', 'CustomerController@store')->name('yeipi.customer.store');
    //Route::post('/shop/store', 'ProveerController@create')->name('yeipi.shop.store');
});
