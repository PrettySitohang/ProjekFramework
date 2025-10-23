<?php

use Illuminate\Support\Facades\Route;
// Import Controller yang diperlukan
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

// RUTE UTAMA DAN PUBLIK
Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
});

Route::get('/about', function () {
    return view('halaman-about');
});

// Rute Controller Lama
Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);
Route::get('pegawai', [PegawaiController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::post('/signup', [HomeController::class, 'signup'])->name('home.signup');


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
    Route::get('users', function() { return 'Halaman Manajemen Pengguna'; })->name('admin.users.index');
    Route::get('articles', function() { return 'Halaman Manajemen Artikel'; })->name('admin.articles.index');
    Route::get('categories', function() { return 'Kategori & Tag'; })->name('admin.categories.index');
    Route::get('settings', function() { return 'Pengaturan Situs'; })->name('admin.settings');
    Route::get('comments', function() { return 'Komentar'; })->name('admin.comments');
    Route::get('reports', function() { return 'Laporan & Log'; })->name('admin.reports');
});
