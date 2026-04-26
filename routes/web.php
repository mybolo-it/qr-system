<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// Halaman publik (item detail bisa diakses tanpa login)
Route::get('/item/{token}', [PublicController::class, 'show'])->name('item.show');

// Halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman home hanya bisa diakses jika login
Route::get('/', [PublicController::class, 'dashboard'])->name('home')->middleware('auth');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Area admin (perlu login)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/form', [AdminController::class, 'showForm'])->name('admin.form');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/items', [AdminController::class, 'index'])->name('admin.items');
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
   
});