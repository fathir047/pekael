<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RuanganApiController;
use App\Http\Controllers\Api\JadwalApiController;
use App\Http\Controllers\Api\BookingApiController;

// auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route::middleware('auth:sanctum')->group(function () {
// });

// user management
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// ruang management
Route::get('/ruangans', [RuanganApiController::class, 'index']);
Route::get('/ruangans/{id}', [RuanganApiController::class, 'show']);
Route::post('/ruangans', [RuanganApiController::class, 'store']);
Route::put('/ruangans/{id}', [RuanganApiController::class, 'update']);
Route::delete('/ruangans/{id}', [RuanganApiController::class, 'destroy']);

// jadwal management
Route::get('/jadwals', [JadwalApiController::class, 'index']);
Route::get('/jadwals/{id}', [JadwalApiController::class, 'show']);
Route::post('/jadwals', [JadwalApiController::class, 'store']);
Route::put('/jadwals/{id}', [JadwalApiController::class, 'update']);
Route::delete('/jadwals/{id}', [JadwalApiController::class, 'destroy']);

// booking management
Route::get('/bookings', [BookingApiController::class, 'index']);
Route::get('/bookings/{id}', [BookingApiController::class, 'show']);
Route::post('/bookings', [BookingApiController::class, 'store']);
Route::put('/bookings/{id}', [BookingApiController::class, 'update']);
Route::delete('/bookings/{id}', [BookingApiController::class, 'destroy']);

// route khusus update status
Route::patch('/bookings/{id}/status', [BookingApiController::class, 'update']);

Route::get('/profile', function () {
    $users = Auth::user()->first();

    return response()->json([
        'status' => true,
        'data' => $users
    ]);
});
