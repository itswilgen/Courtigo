<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CourtController as AdminCourtController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
        Route::patch('/users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('/courts', [AdminCourtController::class, 'index'])->name('courts.index');
        Route::get('/courts/{court}', [AdminCourtController::class, 'show'])->name('courts.show');
        Route::patch('/courts/{court}/approve', [AdminCourtController::class, 'approve'])->name('courts.approve');
        Route::patch('/courts/{court}/suspend', [AdminCourtController::class, 'suspend'])->name('courts.suspend');

        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');

        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
        Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.status');

        Route::view('/settings', 'admin.settings')->name('settings');
    });
