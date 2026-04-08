<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/galeri', function () {
    $images = \App\Models\GalleryItem::latest()->get();
    return view('gallery', compact('images'));
});

Route::get('/admin', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');
Route::get('/admin/gallery', [AdminController::class, 'gallery'])->name('admin.gallery')->middleware('auth');
Route::post('/admin/gallery', [AdminController::class, 'galleryStore'])->name('admin.gallery.store')->middleware('auth');
Route::delete('/admin/gallery/{id}', [AdminController::class, 'galleryDestroy'])->name('admin.gallery.destroy')->middleware('auth');
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports')->middleware('auth');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings')->middleware('auth');
Route::post('/admin/settings', [AdminController::class, 'settingsUpdate'])->name('admin.settings.update')->middleware('auth');
Route::post('/admin/users', [AdminController::class, 'userStore'])->name('admin.users.store')->middleware('auth');
Route::delete('/admin/users/{id}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy')->middleware('auth');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout')->middleware('auth');


