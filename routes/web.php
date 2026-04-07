<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.app');
// });
// Route untuk halaman statis (tanpa controller)
Route::get('/', function () {
    return redirect('/landing');
});

// Landing Page
Route::get('/landing', function () {
    return view('landing.index');
})->name('landing');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

// Motor Routes
Route::get('/motor', function () {
    return view('motor.index');
})->name('motor.index');

Route::get('/motor/create', function () {
    return view('motor.create');
})->name('motor.create');

// Simulasi Routes
Route::get('/simulasi', function () {
    return view('simulasi.index');
})->name('simulasi.index');

Route::get('/simulasi/history', function () {
    return view('simulasi.history');
})->name('simulasi.history');

// Rekomendasi Routes
Route::get('/rekomendasi', function () {
    return view('rekomendasi.index');
})->name('rekomendasi.index');

// Admin Routes
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('/admin/create', function () {
    return view('admin.create');
})->name('admin.create');

// Profile & Settings
Route::get('/profile', function () {
    return view('profile.index');
})->name('profile');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings');

// FAQ
Route::get('/laporan', function () {
    return view('laporan.index');
})->name('laporan');

// Logout (nanti diisi dengan logic logout)
Route::get('/logout', function () {
    // Tambahkan logic logout nanti
    return redirect('/');
})->name('logout');

use Illuminate\Support\Facades\DB;

Route::get('/test-db', function () {
    try {
        DB::connection()->getMongoClient();
        return "Koneksi MongoDB BERHASIL 🔥";
    } catch (\Exception $e) {
        return "GAGAL: " . $e->getMessage();
    }
});