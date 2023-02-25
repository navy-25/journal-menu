<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SpendController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::controller(StatsController::class)->name('stats.')->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(SalesController::class)->prefix('sales')->name('sales.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/destroy', 'destroy')->name('destroy');
    Route::get('/show', 'show')->name('show');
    Route::get('/migrate', 'migrate')->name('migrate');
});

// Route::controller(SpendController::class)->prefix('spend')->name('spend.')->group(function () {
//     Route::get('/', 'index')->name('index');
//     Route::post('/store', 'store')->name('store');
//     Route::post('/update', 'update')->name('update');
//     Route::get('/destroy', 'destroy')->name('destroy');
// });

Route::controller(TransactionController::class)->prefix('transaction')->name('transaction.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/show', 'show')->name('show');
    Route::post('/update', 'update')->name('update');
    Route::get('/destroy', 'destroy')->name('destroy');
});

Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/update', 'update')->name('update');
});

Route::controller(NoteController::class)->prefix('note')->name('note.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/destroy', 'destroy')->name('destroy');
});

Route::controller(StockController::class)->prefix('stock')->name('stock.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/destroy', 'destroy')->name('destroy');
});

Route::controller(SettingsController::class)->prefix('settings')->name('settings.')->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(ReportController::class)->prefix('report')->name('report.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/download', 'download')->name('download');
});
