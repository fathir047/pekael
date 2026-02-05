<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Auth\LoginController;



// auth
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);


// user management
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
