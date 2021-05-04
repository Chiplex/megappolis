<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\HomeController;

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

Route::middleware(['auth'])->get('/', [HomeController::class, 'index']);
Route::get('/passport', [HomeController::class, 'create'])->name('passport.create');
Route::post('/passport', [HomeController::class, 'store'])->name('passport.store');

Route::get('/view/{view}', [ViewController::class, 'show']);

require __DIR__.'/auth.php';
