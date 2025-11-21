<?php

use Illuminate\Support\Facades\Route;
// Import Controller yang diperlukan
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\CategoryTagController;

Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

// RUTE ADMINISTRATOR
Route::prefix('admin')->group(function() {

    // --- RUTE OTENTIKASI (AdminAuthController) ---
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('register', [AdminAuthController::class, 'register'])->name('admin.register');
    Route::get('check-session', [AdminAuthController::class, 'checkSession'])->name('admin.check-session');


    // --- RUTE APLIKASI (AdminController) ---
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // --- RUTE PENGGUNA (PenggunaController) ---
    Route::get('users', [PenggunaController::class, 'index'])->name('pengguna.index');
    // CREATE (Tampilkan form)
    Route::get('users/tbhData', [PenggunaController::class, 'create'])->name('users.tbhData');
    // CREATE (Proses simpan data dari form)
    Route::post('users', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('users/{user}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');

    // UPDATE (Proses data dari form edit)
    // Perhatikan: Menggunakan metode 'PUT' atau 'PATCH' sesuai konvensi HTTP, meskipun dikirim melalui form POST dengan @method('PUT')
    Route::put('users/{user}', [PenggunaController::class, 'update'])->name('pengguna.update');

    Route::delete('users/{user}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');


    // --- RUTE ARTIKEL (ArtikelController) ---
    Route::get('articles', [ArtikelController::class, 'index'])->name('artikel.index');
    // CREATE (Tampilkan form)
    Route::get('articles/tbhData', [ArtikelController::class, 'create'])->name('artikel.tbhData');
    // CREATE (Proses simpan data dari form)
    Route::post('articles', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('articles/{article}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');

    // UPDATE (Proses data dari form edit)
    // Perhatikan: Menggunakan metode 'PUT' atau 'PATCH' sesuai konvensi HTTP, meskipun dikirim melalui form POST dengan @method('PUT')
    Route::put('articles/{article}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('articles/{article}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    // --- RUTE KATEGORI DAN TAG (CategoryTagController) ---
    Route::get('categoriestag', [CategoryTagController::class, 'index'])->name('categoriestag.index');
    // CREATE (Tampilkan form)
    Route::get('categoriestag/tbhData', [CategoryTagController::class, 'create'])->name('categoriestag.create');
    // CREATE (Proses simpan data dari form)
    Route::post('categoriestag', [CategoryTagController::class, 'store'])->name('categoriestag.store');
Route::get('categoriestag/{category_id}/edit', [CategoryTagController::class, 'edit'])->name('categoriestag.edit');
    // UPDATE (Proses data dari form edit)
    // Perhatikan: Menggunakan metode 'PUT' atau 'PATCH' sesuai konvensi HTTP, meskipun dikirim melalui form POST dengan @method('PUT')
    Route::put('categoriestag/{category_id}', [CategoryTagController::class, 'update'])->name('categoriestag.update');
    Route::delete('categoriestag/{category_id}', [CategoryTagController::class, 'destroy'])->name('categoriestag.destroy');


    Route::get('settings', function() { return 'Pengaturan Situs'; })->name('admin.settings');
    Route::get('comments', function() { return 'Komentar'; })->name('admin.comments');
    Route::get('reports', function() { return 'Laporan & Log'; })->name('admin.reports');
});
