<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;



// login
Route::post('/login', [UserController::class, 'login']);

// user management
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
