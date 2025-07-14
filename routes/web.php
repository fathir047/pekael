<?php

use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\RuanganController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\Backend\JadwalController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\User\UserBookingController;    
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/', [FrontendController::class, 'index']);
Auth::routes();

Route::get('/booking', [FrontendController::class, 'booking']);
Route::resource('/bookings', BookingController::class);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index']);
    Route::resource('/user', UserController::class);
    Route::resource('/ruangan', RuanganController::class);
    Route::resource('/jadwal', JadwalController::class);
    Route::resource('/bookings', BookingController::class);
    Route::get('bookings-export', [BookingController::class, 'export'])->name('bookings.export');
    
});



Route::middleware(['auth'])->group(function () {
    Route::get('/booking/create', [UserBookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking/riwayat', [UserBookingController::class, 'riwayat'])->name('bookings.riwayat');
    Route::get('/ruangan', [UserBookingController::class, 'show'])->name('ruangan.show');
    Route::get('/ruangan/{id}', [UserBookingController::class, 'tampil'])->name('ruangan.show');
});

Route::get('/ruangan/{id}', [FrontendController::class, 'ruanganShow'])->name('ruangan.detail');
