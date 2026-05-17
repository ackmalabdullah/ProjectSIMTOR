<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MotorApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SimulasiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/motor', [MotorApiController::class, 'index']);
Route::get('/motor/{id}', [MotorApiController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/social-login', [AuthController::class, 'socialLogin']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/simulasi/simpan', [SimulasiController::class, 'simpan']);
    Route::get('/simulasi/riwayat', [SimulasiController::class, 'riwayat']);
});
