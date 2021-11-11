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

    // Rutas para el controlador de Pedir
    Route::prefix('pedir')->middleware(['access:YEIPI-CUSTOMER'])->group(function () {
        Route::get('/iniciar', 'PedirController@preparar')->name('yeipi.pedir.preparar');
        Route::post('/iniciar', 'PedirController@iniciar')->name('yeipi.pedir.iniciar');

        Route::get('/index', 'PedirController@index')->name('yeipi.pedir.index');
        Route::get('/cart', 'PedirController@cart')->name('yeipi.pedir.cart');
        Route::get('/search/{search}', 'PedirController@search')->name('yeipi.pedir.search');
        Route::get('/shop/{product}', 'PedirController@shop')->name('yeipi.pedir.shop');
        Route::post('/product', 'PedirController@store')->name('yeipi.pedir.store');
        Route::get('/count', 'PedirController@count')->name('yeipi.pedir.count');
        
        Route::get('/history', 'PedirController@history')->name('yeipi.pedir.history');
        Route::get('/data/history', 'PedirController@dataHistory')->name('yeipi.pedir.data.history');
        
        Route::get('/current', 'PedirController@current')->name('yeipi.pedir.current');
        Route::get('/data/current', 'PedirController@dataCurrent')->name('yeipi.pedir.data.current');

        Route::post('/solicitar', 'PedirController@solicitar')->name('yeipi.pedir.solicitar');
        Route::delete('/cancelar', 'PedirController@cancelar')->name('yeipi.pedir.cancelar');

        Route::put('/product', 'PedirController@update')->name('yeipi.pedir.update');
        Route::delete('/product', 'PedirController@delete')->name('yeipi.pedir.delete');

        Route::get('/qualify', 'PedirController@qualify')->name('yeipi.pedir.qualify');
    });

    // Rutas para el controlador de entregar
    Route::prefix('entregar')->middleware(['access:YEIPI-DELIVERY'])->group(function () {
        Route::get('/index', 'EntregarController@index')->name('yeipi.entregar.index');
        Route::get('/data/index', 'EntregarController@dataIndex')->name('yeipi.entregar.data.index');

        Route::get('/register/{order}', 'EntregarController@edit')->name('yeipi.entregar.edit');
        Route::post('/register', 'EntregarController@store')->name('yeipi.entregar.store');
        Route::get('/data/detail/{order}', 'EntregarController@dataDetail')->name('yeipi.entregar.data.detail');

        Route::post('/entregar', 'EntregarController@entregar')->name('yeipi.entregar.entregar');
        Route::post('/cancelar', 'EntregarController@cancelar')->name('yeipi.entregar.cancelar');

        Route::get('/count', 'EntregarController@count')->name('yeipi.entregar.count')->middleware('access:YEIPI-CUSTOMER');
    });
    
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

    // Rutas Proveer
    Route::prefix('proveer')->middleware(['access:YEIPI-PROVIDER'])->group(function () {
        Route::get('/iniciar', 'ProveerController@preparar')->name('yeipi.proveer.preparar');
        Route::post('/iniciar', 'ProveerController@iniciar')->name('yeipi.proveer.iniciar');

        Route::get('/index', 'ProveerController@index')->name('yeipi.proveer.index');
        Route::get('/product', 'ProveerController@product')->name('yeipi.proveer.product');
        Route::get('/data/customer', 'ProveerController@datacustomer')->name('yeipi.proveer.data.customer');
        
        Route::get('/stock', 'ProveerController@stock')->name('yeipi.proveer.stock');
        Route::get('/data/stock', 'ProveerController@dataStock')->name('yeipi.proveer.data.stock');
        Route::post('/stock', 'ProveerController@stockStore')->name('yeipi.proveer.stock.store');
        Route::put('/stock/{stock}', 'ProveerController@stockUpdate')->name('yeipi.proveer.stock.update');
        Route::delete('/stock/{stock}', 'ProveerController@stockDelete')->name('yeipi.proveer.stock.delete');

        Route::get('/customer', 'ProveerController@order')->name('yeipi.proveer.order');
    });

    // Rutas de las ordenes
    Route::prefix('/order')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/index', 'OrderController@index')->name('yeipi.order.index');
        Route::get('/data', 'OrderController@data')->name('yeipi.order.data');
        Route::get('/register', 'OrderController@create')->name('yeipi.order.create');
        Route::post('/register', 'OrderController@store')->name('yeipi.order.store');
        Route::get('/register/{order}', 'OrderController@edit')->name('yeipi.order.edit');
        Route::put('/register/{order}', 'OrderController@update')->name('yeipi.order.update');
        Route::delete('/register/{order}', 'OrderController@destroy')->name('yeipi.order.delete');
    });

    // Rutas de los detalles
    Route::prefix('/detail')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/index', 'DetailController@index')->name('yeipi.detail.index');
        Route::get('/data', 'DetailController@data')->name('yeipi.detail.data');
        Route::get('/register', 'DetailController@create')->name('yeipi.detail.create');
        Route::post('/register', 'DetailController@store')->name('yeipi.detail.store');
        Route::get('/register/{detail}', 'DetailController@edit')->name('yeipi.detail.edit');
        Route::put('/register/{detail}', 'DetailController@update')->name('yeipi.detail.update');
        Route::delete('/register/{detail}', 'DetailController@destroy')->name('yeipi.detail.delete');
    });
    
    // Rutas de los productos
    Route::prefix('/product')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/data', 'ProductController@data')->name('yeipi.product.data');
        Route::get('/index', 'ProductController@index')->name('yeipi.product.index');
        Route::get('/register', 'ProductController@create')->name('yeipi.product.create');
        Route::post('/register', 'ProductController@store')->name('yeipi.product.store');
        Route::get('/register/{product}', 'ProductController@edit')->name('yeipi.product.edit');
        Route::put('/register/{product}', 'ProductController@update')->name('yeipi.product.update');
        Route::delete('/register/{product}', 'ProductController@destroy')->name('yeipi.product.delete');
    });

    // Rutas de los Consumidores
    Route::prefix('/customer')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/data', 'CustomerController@data')->name('yeipi.customer.data');
        Route::get('/index', 'CustomerController@index')->name('yeipi.customer.index');
        Route::get('/register', 'CustomerController@create')->name('yeipi.customer.create');
        Route::post('/register', 'CustomerController@store')->name('yeipi.customer.store');
        Route::get('/register/{customer}', 'CustomerController@edit')->name('yeipi.customer.edit');
        Route::put('/register/{customer}', 'CustomerController@update')->name('yeipi.customer.update');
        Route::delete('/register/{customer}', 'CustomerController@destroy')->name('yeipi.customer.delete');
    });

    // Rutas de los Proveedores
    Route::prefix('/provider')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/data/', 'ProviderController@data')->name('yeipi.provider.data');
        Route::get('/index', 'ProviderController@index')->name('yeipi.provider.index');
        Route::get('/register', 'ProviderController@create')->name('yeipi.provider.create');
        Route::post('/register', 'ProviderController@store')->name('yeipi.provider.store');
        Route::get('/register/{provider}', 'ProviderController@edit')->name('yeipi.provider.edit');
        Route::put('/register/{provider}', 'ProviderController@update')->name('yeipi.provider.update');
        Route::delete('/register/{provider}', 'ProviderController@destroy')->name('yeipi.provider.delete');
    });

    // Rutas de los Delivery
    Route::prefix('/delivery')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/data/', 'DeliveryController@data')->name('yeipi.delivery.data');
        Route::get('/index', 'DeliveryController@index')->name('yeipi.delivery.index');
        Route::get('/register', 'DeliveryController@create')->name('yeipi.delivery.create');
        Route::post('/register', 'DeliveryController@store')->name('yeipi.delivery.store');
        Route::get('/register/{delivery}', 'DeliveryController@edit')->name('yeipi.delivery.edit');
        Route::put('/register/{delivery}', 'DeliveryController@update')->name('yeipi.delivery.update');
        Route::delete('/register/{delivery}', 'DeliveryController@destroy')->name('yeipi.delivery.delete');
    });

    // Rutas de los Shops
    Route::prefix('/shop')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/data/', 'ShopController@data')->name('yeipi.shop.data');
        Route::get('/index', 'ShopController@index')->name('yeipi.shop.index');
        Route::get('/register', 'ShopController@create')->name('yeipi.shop.create');
        Route::post('/register', 'ShopController@store')->name('yeipi.shop.store');
        Route::get('/register/{shop}', 'ShopController@edit')->name('yeipi.shop.edit');
        Route::put('/register/{shop}', 'ShopController@update')->name('yeipi.shop.update');
        Route::delete('/register/{shop}', 'ShopController@destroy')->name('yeipi.shop.delete');
    });
    
    // Rutas de los Stock
    Route::prefix('/stock')->middleware('access:CORE-MEGAPPOLIS')->group(function () {
        Route::get('/data/', 'StockController@data')->name('yeipi.stock.data');
        Route::get('/index', 'StockController@index')->name('yeipi.stock.index');
        Route::get('/register', 'StockController@create')->name('yeipi.stock.create');
        Route::post('/register', 'StockController@store')->name('yeipi.stock.store');
        Route::get('/register/{stock}', 'StockController@edit')->name('yeipi.stock.edit');
        Route::put('/register/{stock}', 'StockController@update')->name('yeipi.stock.update');
        Route::delete('/register/{stock}', 'StockController@destroy')->name('yeipi.stock.delete');
    });
});