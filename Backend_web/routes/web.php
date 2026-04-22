<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\SimulasiController;
use App\Http\Controllers\Web\MotorController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Web\PelangganController;

/*
|--------------------------------------------------------------------------
| 1. Public Routes (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

// Halaman Utama / Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| 2. Guest Routes (Hanya untuk yang BELUM login)
|--------------------------------------------------------------------------
| Jika user sudah login mencoba akses ini, mereka akan diredirect otomatis
*/
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| 3. Authenticated Routes (Hanya untuk yang SUDAH login)
|--------------------------------------------------------------------------
| Di sini tempat fitur utama ProjectSIMTOR kamu berada
*/
Route::middleware('auth:admin')->group(function () {

    Route::get('/pelanggan', [\App\Http\Controllers\Web\PelangganController::class, 'index'])
        ->name('pelanggan.index');

    // Proses Keluar (POST lebih aman daripada GET)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::prefix('motor')->group(function () {
        Route::get('/', [MotorController::class, 'index'])->name('motor.index');
        Route::get('/create', [MotorController::class, 'create'])->name('motor.create');
        Route::post('/', [MotorController::class, 'store'])->name('motor.store');
        Route::get('/{id}', [MotorController::class, 'show'])->name('motor.show');
        Route::get('/{id}/edit', [MotorController::class, 'edit'])->name('motor.edit');
        Route::put('/{id}', [MotorController::class, 'update'])->name('motor.update');
        Route::delete('/{id}', [MotorController::class, 'destroy'])->name('motor.destroy');
    });

    // Fitur Simulasi Kredit & Riwayat
    Route::prefix('simulasi')->group(function () {
        // Menampilkan halaman utama simulasi (lewat Controller)
        Route::get('/', [SimulasiController::class, 'index'])->name('simulasi.index');
        Route::get('/history', [SimulasiController::class, 'index'])->name('simulasi.history');
    });

    // Fitur Rekomendasi Motor
    Route::get('/rekomendasi', function () {
        return view('rekomendasi.index');
    })->name('rekomendasi.index');

    // Fitur Admin & User Management
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update');
    });

    // Pengaturan Akun & Laporan
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
    Route::get('/laporan', function () {
        return view('laporan.index');
    })->name('laporan');
});