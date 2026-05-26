<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourtigoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CourtigoController::class, 'index'])->name('home');
Route::get('/courts/{court}', [CourtigoController::class, 'show'])->name('courts.show');
Route::get('/vendor/apply', [CourtigoController::class, 'vendorApply'])->name('vendor.apply');
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegistration'])->name('register.store');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/player', [DashboardController::class, 'player'])->middleware('role:player,admin')->name('dashboard.player');
    Route::get('/dashboard/vendor', [DashboardController::class, 'vendor'])->middleware('role:vendor,admin')->name('dashboard.vendor');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->middleware('role:admin')->name('dashboard.admin');
});
