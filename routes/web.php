<?php

use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

$isMainDomainRequest = static fn (): bool => request()->getHost() === 'kzcore-production.up.railway.app';

Route::get('/', function () use ($isMainDomainRequest) {
    if ($isMainDomainRequest()) {
        return redirect()->route('admin.login');
    }

    return app(ThemeController::class)->home();
})->name('theme.home');

Route::get('/about', function () use ($isMainDomainRequest) {
    if ($isMainDomainRequest()) {
        return redirect()->route('admin.login');
    }

    return app(ThemeController::class)->about();
})->name('theme.about');

Route::get('/services', function () use ($isMainDomainRequest) {
    if ($isMainDomainRequest()) {
        return redirect()->route('admin.login');
    }

    return app(ThemeController::class)->services();
})->name('theme.services');

Route::get('/contact', function () use ($isMainDomainRequest) {
    if ($isMainDomainRequest()) {
        return redirect()->route('admin.login');
    }

    return app(ThemeController::class)->contact();
})->name('theme.contact');

Route::get('/galeri', function () use ($isMainDomainRequest) {
    if ($isMainDomainRequest()) {
        return redirect()->route('admin.login');
    }

    return app(ThemeController::class)->gallery();
})->name('theme.gallery');

Route::get('/KzCore/admin', [SuperAdminController::class, 'dashboard'])->name('kzcore.dashboard')->middleware('auth');
Route::post('/KzCore/admin/tenants', [SuperAdminController::class, 'tenantStore'])->name('kzcore.tenants.store')->middleware('auth');
Route::get('/KzCore/admin/tenants/{tenant}/edit', [SuperAdminController::class, 'tenantEdit'])->name('kzcore.tenants.edit')->middleware('auth');
Route::put('/KzCore/admin/tenants/{tenant}', [SuperAdminController::class, 'tenantUpdate'])->name('kzcore.tenants.update')->middleware('auth');
Route::delete('/KzCore/admin/tenants/{tenant}', [SuperAdminController::class, 'tenantDestroy'])->name('kzcore.tenants.destroy')->middleware('auth');
Route::post('/KzCore/admin/tenant-users', [SuperAdminController::class, 'tenantUserStore'])->name('kzcore.tenant-users.store')->middleware('auth');
Route::post('/KzCore/admin/super-admins', [SuperAdminController::class, 'superAdminStore'])->name('kzcore.super-admins.store');

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

Route::get('/test-host', function () {
    return request()->getHost();
});
