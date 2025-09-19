<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;

// Trang chủ - redirect về customer home
Route::get('/', [CustomerHomeController::class, 'index'])->name('home');

// Routes xác thực
Route::middleware('guest')->group(function () {
    // Hiển thị form đăng ký và đăng nhập
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    
    // Xử lý đăng ký và đăng nhập
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Routes đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes xác thực email
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/resend', [AuthController::class, 'resendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// Routes admin (yêu cầu đăng nhập, verified và role admin)
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Có thể thêm các routes admin khác ở đây
});

// Routes customer (yêu cầu đăng nhập, verified và role user)
Route::middleware(['auth', 'verified', 'role:user'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    // Có thể thêm các routes customer khác ở đây
});
