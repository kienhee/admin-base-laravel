<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EcommerceController;
use App\Http\Controllers\Admin\HashTagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group( function () {
        Route::get('/', [DashboardController::class, 'analytics'])->name('analytics');
    });

    Route::prefix('blogs')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'list'])->name('list');
        Route::get('/ajax-get-data', [BlogController::class, 'ajaxGetData'])->name('ajaxGetData');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/store', [BlogController::class, 'store'])->name('store');
        Route::get('/edit/{slug}', [BlogController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [BlogController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [BlogController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('ajax-get-list', [HashTagController::class, 'ajaxGetList'])->name('ajaxGetList');
    });
    Route::prefix('ecommerce')->name('ecommerce.')->group(function () {
        Route::get('/', [EcommerceController::class, 'list'])->name('list');
        Route::get('/ajax-get-data', [EcommerceController::class, 'ajaxGetData'])->name('ajaxGetData');
        Route::get('/create', [EcommerceController::class, 'create'])->name('create');
        Route::post('/store', [EcommerceController::class, 'store'])->name('store');
        Route::get('/edit/{slug}', [EcommerceController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [EcommerceController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EcommerceController::class, 'destroy'])->name('destroy');
    });
    Route::get('media', function () {
        return view('admin.modules.media.index');
    })->name('media');
});

// Authentication routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/loginHandle', [AuthController::class, 'loginHandle'])->name('loginHandle');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});
 Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
});
