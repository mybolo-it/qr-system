<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// Halaman publik (item detail bisa diakses tanpa login)
Route::get('/item/{token}', [PublicController::class, 'show'])->name('item.show');
Route::get('/dokumen/file/{id}', [DocumentController::class, 'viewFile'])->name('document.file');

// Halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman home hanya bisa diakses jika login
Route::get('/', [PublicController::class, 'dashboard'])
    ->name('home')
    ->middleware('auth');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Area admin (perlu login)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/form', [AdminController::class, 'showForm'])->name('admin.form');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/items', [AdminController::class, 'index'])->name('admin.items');
    Route::get('/admin/arsip/{id}/download-qr', [AdminController::class, 'downloadQr'])->name('admin.arsip.download-qr');
    Route::delete('/admin/arsip/bulk-destroy', [AdminController::class, 'bulkDestroy'])->name('admin.arsip.bulk-destroy');
    Route::put('/admin/arsip/{id}', [AdminController::class, 'update'])->name('admin.arsip.update');
    Route::get('/admin/arsip', [AdminController::class, 'arsip'])->name('admin.arsip');
    Route::delete('/admin/arsip/{id}', [AdminController::class, 'destroy'])->name('admin.arsip.destroy');

    // Modul Kategori Dokumen
    Route::get('/admin/kategori', [\App\Http\Controllers\CategoryController::class, 'index'])->name('admin.kategori.index');
    Route::post('/admin/kategori', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.kategori.destroy');

    // Modul Manajemen Perusahaan
    Route::get('/admin/perusahaan', [\App\Http\Controllers\CompanyController::class, 'index'])->name('admin.perusahaan.index');
    Route::post('/admin/perusahaan', [\App\Http\Controllers\CompanyController::class, 'store'])->name('admin.perusahaan.store');
    Route::put('/admin/perusahaan/{id}', [\App\Http\Controllers\CompanyController::class, 'update'])->name('admin.perusahaan.update');
    Route::delete('/admin/perusahaan/{id}', [\App\Http\Controllers\CompanyController::class, 'destroy'])->name('admin.perusahaan.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
