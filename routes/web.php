<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/', [WebController::class, 'home'])->name('home');

Route::get('/galery/get/{categoryOrder}/{galeryOrder}', [WebController::class, 'getContent']);
Route::get('/carousel/open/{galeryOrder}/{photoOrder}', [WebController::class, 'openCarousel']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth'])->group(function() {

    Route::get('/admin', [WebController::class, 'admin'])->name('admin');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::post('/category/create', [CategoryController::class, 'create']);
    Route::post('/category/edit', [CategoryController::class, 'edit']);
    Route::post('/category/delete', [CategoryController::class, 'delete']);
    Route::post('/category/new/order', [CategoryController::class, 'newOrder']);

    Route::get('/galery/admin/show/{galeryName}', [GaleryController::class, 'show']);

    Route::post('/galery/create', [GaleryController::class, 'create']);
    Route::post('/galery/edit', [GaleryController::class, 'edit']);
    Route::post('/galery/delete', [GaleryController::class, 'delete']);
    Route::post('/galery/new/order', [GaleryController::class, 'newOrder']);

    Route::post('/photo/upload', [PhotoController::class, 'upload'])->name('upload');
    Route::post('/photo/highlight', [PhotoController::class, 'highlight']);
    Route::post('/photo/delete', [PhotoController::class, 'delete']);
    Route::post('/photo/new/order', [PhotoController::class, 'newOrder']);

});
