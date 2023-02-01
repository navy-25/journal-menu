<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SpendController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return route('sales.index');
// });

Route::controller(StatsController::class)->name('stats.')->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(SalesController::class)->prefix('sales')->name('sales.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/destroy', 'destroy')->name('destroy');
});

Route::controller(SpendController::class)->prefix('spend')->name('spend.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/destroy', 'destroy')->name('destroy');
});

Route::controller(MenuController::class)->prefix('stock')->name('stock.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/update', 'update')->name('update');
});
