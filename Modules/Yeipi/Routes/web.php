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

    // Rutas Pedir
    Route::prefix('pedir')->middleware(['access:YEIPI-CUSTOMER'])->group(function () {
        Route::get('/iniciar', 'PedirController@preparar')->name('yeipi.pedir.preparar');
        Route::post('/iniciar', 'PedirController@iniciar')->name('yeipi.pedir.iniciar');

        Route::get('/index', 'PedirController@index')->name('yeipi.pedir.index');

        Route::get('/history', 'PedirController@history')->name('yeipi.pedir.history');
        Route::get('/data/history', 'PedirController@dataHistory')->name('yeipi.pedir.data.history');

        Route::get('/register/{order}', 'PedirController@edit')->name('yeipi.pedir.edit');
        Route::post('/register', 'PedirController@store')->name('yeipi.pedir.store');
        Route::get('/data/detail/{order}', 'PedirController@dataDetail')->name('yeipi.pedir.data.detail');

        Route::post('/solicitar', 'PedirController@solicitar')->name('yeipi.pedir.solicitar');
        Route::post('/cancelar', 'PedirController@cancelar')->name('yeipi.pedir.cancelar');

        Route::get('/current/{order}', 'PedirController@current')->name('yeipi.pedir.current');
        
        Route::get('/count', 'PedirController@count')->name('yeipi.pedir.count')->middleware('access:YEIPI-CUSTOMER');
    });

    Route::get('/pedir/entregas', 'PedirController@entregas')->name('yeipi.pedir.entregas')->middleware('access:YEIPI-CUSTOMER');
    Route::post('/pedir/producto', 'PedirController@producto')->name('yeipi.pedir.producto')->middleware('access:YEIPI-CUSTOMER');
    Route::get('/pedir/shop/{product}', 'PedirController@shop')->name('yeipi.pedir.shop')->middleware('access:YEIPI-CUSTOMER');

    // Rutas Entregar
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
    });

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

    Route::prefix('/product')->middleware('access:YEIPI-PROVIDER')->group(function () {
        Route::get('/data/', 'ProductController@data')->name('yeipi.product.data');
        Route::get('/index', 'ProductController@index')->name('yeipi.product.index');
        Route::get('/register', 'ProductController@create')->name('yeipi.product.create');
        Route::post('/register', 'ProductController@store')->name('yeipi.product.store');
        Route::get('/register/{product}', 'ProductController@edit')->name('yeipi.product.edit');
        Route::put('/register/{product}', 'ProductController@update')->name('yeipi.product.update');
        Route::delete('/register/{product}', 'ProductController@destroy')->name('yeipi.product.delete');
    });
    

    Route::post('/customer/store', 'CustomerController@store')->name('yeipi.customer.store');
    //Route::post('/shop/store', 'ProveerController@create')->name('yeipi.shop.store');
});


//Crear una ruta para controlar los pedidos actuales
