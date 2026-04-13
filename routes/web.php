<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\DB;

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

    // Proses Keluar (POST lebih aman daripada GET)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Manajemen Data Motor
    Route::prefix('motor')->group(function () {
        Route::get('/', function () {
            return view('motor.index');
        })->name('motor.index');
        Route::get('/create', function () {
            return view('motor.create');
        })->name('motor.create');
    });

    // Fitur Simulasi Kredit & Riwayat
    Route::prefix('simulasi')->group(function () {
        Route::get('/', function () {
            return view('simulasi.index');
        })->name('simulasi.index');
        Route::get('/history', function () {
            return view('simulasi.history');
        })->name('simulasi.history');
    });

    // Fitur Rekomendasi Motor
    Route::get('/rekomendasi', function () {
        return view('rekomendasi.index');
    })->name('rekomendasi.index');

    // Fitur Admin & User Management
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        })->name('admin.index');
        Route::get('/create', function () {
            return view('admin.create');
        })->name('admin.create');
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
