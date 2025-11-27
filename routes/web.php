<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\CategoryTagController;

// ==================
// ROUTE HALAMAN UTAMA
// ==================
Route::get('/', function () {
    return redirect()->route('admin.login');
});



// ==================
// ROUTE AUTH ADMIN
// (TIDAK memakai middleware role admin)
// ==================
Route::prefix('admin')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])
        ->name('admin.register.form');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('admin.register');
});


// ==================
// ROUTE ADMIN TERLINDUNGI MIDDLEWARE role:admin
// ==================
Route::prefix('admin')
    ->middleware(['role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // PENGGUNA
        Route::get('users', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('users/tbhData', [PenggunaController::class, 'create'])->name('users.tbhData');
        Route::post('users', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('users/{user}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
        Route::put('users/{user}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('users/{user}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

        // ARTIKEL
        Route::get('articles', [ArtikelController::class, 'index'])->name('artikel.index');
        Route::get('articles/tbhData', [ArtikelController::class, 'create'])->name('artikel.tbhData');
        Route::post('articles', [ArtikelController::class, 'store'])->name('artikel.store');
        Route::get('articles/{article}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
        Route::put('articles/{article}', [ArtikelController::class, 'update'])->name('artikel.update');
        Route::delete('articles/{article}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

        // KATEGORI & TAG
        Route::get('categoriestag', [CategoryTagController::class, 'index'])->name('categoriestag.index');
        Route::get('categoriestag/tbhData', [CategoryTagController::class, 'create'])->name('categoriestag.create');
        Route::post('categoriestag', [CategoryTagController::class, 'store'])->name('categoriestag.store');
        Route::get('categoriestag/{category_id}/edit', [CategoryTagController::class, 'edit'])->name('categoriestag.edit');
        Route::put('categoriestag/{category_id}', [CategoryTagController::class, 'update'])->name('categoriestag.update');
        Route::delete('categoriestag/{category_id}', [CategoryTagController::class, 'destroy'])->name('categoriestag.destroy');

        // Menu Lain
        Route::get('settings', fn() => 'Pengaturan Situs')->name('admin.settings');
        Route::get('comments', fn() => 'Komentar')->name('admin.comments');
        Route::get('reports', fn() => 'Laporan & Log')->name('admin.reports');
    });
