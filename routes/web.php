<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;

// Trang chủ - redirect về customer home
Route::get('/', [CustomerHomeController::class, 'index'])->name('home');

// Routes trang công khai
Route::get('/products', [CustomerHomeController::class, 'products'])->name('products');
Route::get('/about', [CustomerHomeController::class, 'about'])->name('about');
Route::get('/contact', [CustomerHomeController::class, 'contact'])->name('contact');

// Routes giỏ hàng và yêu thích (yêu cầu đăng nhập)
Route::middleware(['auth', 'verified'])->group(function () {
    // Wishlist routes
    Route::get('/wishlist', [\App\Http\Controllers\Customer\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\Customer\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [\App\Http\Controllers\Customer\WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/clear', [\App\Http\Controllers\Customer\WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::post('/wishlist/{product}/move-to-cart', [\App\Http\Controllers\Customer\WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
    
    // Cart routes
    Route::get('/cart', [\App\Http\Controllers\Customer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\Customer\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [\App\Http\Controllers\Customer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [\App\Http\Controllers\Customer\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\Customer\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/info', [\App\Http\Controllers\Customer\CartController::class, 'info'])->name('cart.info');
    
    // Address routes
    Route::resource('addresses', \App\Http\Controllers\Customer\AddressController::class);
    Route::post('addresses/{address}/set-default', [\App\Http\Controllers\Customer\AddressController::class, 'setDefault'])->name('addresses.set-default');
    
    // Order routes
    Route::get('/checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
});

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
    
    // Routes quản lý danh mục (bỏ show)
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    
    // Routes quản lý sản phẩm (bỏ show)
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    
    // Routes bổ sung cho sản phẩm
    Route::post('products/{product}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])
        ->name('products.toggle-status');
    Route::post('products/{product}/toggle-featured', [\App\Http\Controllers\Admin\ProductController::class, 'toggleFeatured'])
        ->name('products.toggle-featured');
    
    // Routes quản lý người dùng
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    
    // Routes quản lý đơn hàng
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->except(['create', 'store', 'edit']);
    Route::put('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/print', [\App\Http\Controllers\Admin\OrderController::class, 'print'])->name('orders.print');
    Route::post('orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
    
    // Routes báo cáo thống kê
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
});

// Routes customer (yêu cầu đăng nhập, verified và role user)
Route::middleware(['auth', 'verified', 'role:user'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    // Có thể thêm các routes customer khác ở đây
});
