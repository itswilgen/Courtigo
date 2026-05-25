<?php

use App\Http\Controllers\CourtigoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CourtigoController::class, 'index'])->name('home');
Route::get('/courts/{court}', [CourtigoController::class, 'show'])->name('courts.show');
Route::get('/vendor/apply', [CourtigoController::class, 'vendorApply'])->name('vendor.apply');

Route::get('/dashboard/player', [DashboardController::class, 'player'])->name('dashboard.player');
Route::get('/dashboard/vendor', [DashboardController::class, 'vendor'])->name('dashboard.vendor');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
