<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\System\PhotoController;
use App\Http\Controllers\System\SaleController;
use App\Http\Controllers\System\AlbumController;
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\SuscriptionController;
use App\Http\Controllers\Web\PhotoController as WebPhotoController;

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

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard'); 
    })->name('dashboard');

    //Profile
    Route::get('/dashboard/profiles/get-total-size', [ProfileController::class, 'getSize'])->name('profiles.getSize');
    Route::put('/dashboard/profiles/edit/{id}', [ProfileController::class, 'update'])->name('profiles.update');

    //Albums
    Route::get('/dashboard/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/dashboard/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::post('/dashboard/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/dashboard/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');
    Route::get('/dashboard/albums/edit/{id}', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/dashboard/albums/edit/{id}', [AlbumController::class, 'update'])->name('albums.update');
        Route::post('/dashboard/albums/upload/{id}', [AlbumController::class, 'upload'])->name('albums.upload');

    //Photos
    Route::get('/dashboard/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::get('/dashboard/photos/show/{id}', [PhotoController::class, 'show'])->name('photos.show');
    Route::get('/dashboard/photos/edit/{id}', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::put('/dashboard/photos/edit/{id}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/dashboard/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::delete('/dashboard/photos/sale/{id}/{idSale}', [PhotoController::class, 'destroySale'])->name('photos.destroySale');
        Route::post('/dashboard/photos/upload', [PhotoController::class, 'upload'])->name('photos.upload');
        Route::post('/dashboard/photos/search', [PhotoController::class, 'search'])->name('photos.search');

    //Sales
    Route::get('/dashboard/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/dashboard/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/dashboard/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/dashboard/sales/{id}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/dashboard/sales/edit/{id}', [SaleController::class, 'edit'])->name('sales.edit');
    Route::put('/dashboard/sales/edit/{id}', [SaleController::class, 'update'])->name('sales.update');
    Route::delete('/dashboard/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::put('/dashboard/sales/change-password/{id}', [SaleController::class, 'changePassword'])->name('albums.changePassword');
        Route::post('/dashboard/sales/upload/{id}', [SaleController::class, 'upload'])->name('sales.upload');
        Route::post('/dashboard/sales/select-photos', [SaleController::class, 'selectPhotos'])->name('sales.selectPhotos');

    Route::get('/dashboard/suscription', [SuscriptionController::class, 'index'])->name('suscription.index');
    Route::post('/dashboard/user/subscribe', [SuscriptionController::class, 'subscribe'])->name('suscription.subscribe');
    Route::get('/dashboard/suscription/cancel/{suscription}', [SuscriptionController::class, 'destroy'])->name('suscription.destroy');
});

Route::get('/', [IndexController::class, 'index'])->name('web.index');
Route::get('/photos/{slug}', [WebPhotoController::class, 'photo'])->name('web.photos.show');
    //Fedd
    Route::get('/feed/publications', [WebPhotoController::class, 'photos']);