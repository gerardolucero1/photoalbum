<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\System\AlbumController;
use App\Http\Controllers\System\PhotoController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard'); 
    })->name('dashboard');

    //Albums
    Route::get('/dashboard/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/dashboard/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::post('/dashboard/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/dashboard/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');
    Route::get('/dashboard/albums/edit/{id}', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/dashboard/albums/edit/{id}', [AlbumController::class, 'update'])->name('albums.update');
        Route::post('/dashboard/albums/upload/{id}', [AlbumController::class, 'upload'])->name('albums.upload');

    //Photos
    Route::get('/dashboard/photos/show/{id}', [PhotoController::class, 'show'])->name('photos.show');
    Route::get('/dashboard/photos/edit/{id}', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::put('/dashboard/photos/edit/{id}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/dashboard/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');
});
