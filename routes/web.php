<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dev\AccountController as DevAccountController;
use App\Http\Controllers\Dev\HomeController;
use App\Http\Controllers\Dev\SettingsController as DevSettingsController;
use App\Http\Controllers\Dev\UsersController;
use App\Http\Controllers\HomeController as PartnerHomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $page = 'Welcome Screen';
    return view('auth.splass_screen', compact('page'));
});

Route::controller(LoginController::class)->prefix('login')->name('login.')->group(function () {
    Route::get('/', 'index')->name('form');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/store', 'store')->name('store');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:isRoot'])->prefix('dev')->name('dev.')->group(function () {
        Route::controller(HomeController::class)->prefix('home')->name('home.')->group(function () {
            Route::get('/', 'index')->name('index');
        });
        Route::controller(UsersController::class)->prefix('user')->name('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/show', 'show')->name('show');
            Route::post('/update', 'update')->name('update');
            Route::get('/destroy', 'destroy')->name('destroy');
        });
        Route::controller(DevSettingsController::class)->prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/show', 'show')->name('show');
            Route::post('/update', 'update')->name('update');
            Route::get('/destroy', 'destroy')->name('destroy');
        });
        Route::controller(DevAccountController::class)->prefix('account')->name('account.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update', 'update')->name('update');
            Route::get('/password', 'password')->name('password');
            Route::post('/update-password', 'updatePassword')->name('updatePassword');
        });
    });

    Route::middleware(['can:isOwnerPartner'])->group(function () {
        Route::controller(PartnerHomeController::class)->prefix('home')->name('home.')->group(function () {
            Route::get('/', 'index')->name('index');
        });
        Route::controller(StatsController::class)->prefix('stats')->name('stats.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::controller(SalesController::class)->prefix('sales')->name('sales.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/destroy', 'destroy')->name('destroy');
            Route::get('/show', 'show')->name('show');
            Route::get('/migrate', 'migrate')->name('migrate');
        });

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
            Route::post('/store', 'store')->name('store');
            Route::get('/destroy', 'destroy')->name('destroy');
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

        Route::controller(AccountController::class)->prefix('account')->name('account.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update', 'update')->name('update');
            Route::get('/password', 'password')->name('password');
            Route::post('/update-password', 'updatePassword')->name('updatePassword');
        });

        Route::controller(SettingsController::class)->prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::controller(ReportController::class)->prefix('report')->name('report.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/download', 'download')->name('download');
        });

        Route::controller(ProfitController::class)->prefix('profit')->name('profit.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::controller(MaterialController::class)->prefix('material')->name('material.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::get('/destroy', 'destroy')->name('destroy');
        });

        Route::controller(RestockController::class)->prefix('restock')->name('restock.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/calculate', 'calculate')->name('calculate');
        });
    });
});
