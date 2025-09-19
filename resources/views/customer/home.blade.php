@extends('layouts.home')

@section('title', 'Trang chủ - Laravel Aosomi')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Hero Section -->
        <div class="card mb-4">
            <div class="card-body text-center py-5">
                <h1 class="display-4 mb-3">
                    <i class="fas fa-home me-3"></i>Chào mừng đến với Aosomi
                </h1>
                <p class="lead mb-4">
                    Hệ thống quản lý hiện đại với giao diện thân thiện và tính năng đầy đủ
                </p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box p-4">
                            <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                            <h4>Mua sắm dễ dàng</h4>
                            <p class="text-muted">Trải nghiệm mua sắm trực tuyến thuận tiện</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box p-4">
                            <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                            <h4>Bảo mật cao</h4>
                            <p class="text-muted">Thông tin cá nhân được bảo vệ an toàn</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box p-4">
                            <i class="fas fa-headset fa-3x text-success mb-3"></i>
                            <h4>Hỗ trợ 24/7</h4>
                            <p class="text-muted">Đội ngũ hỗ trợ luôn sẵn sàng giúp đỡ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-plus me-2"></i>Tạo tài khoản mới
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Đăng ký tài khoản để trải nghiệm đầy đủ các tính năng của hệ thống.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Truy cập dashboard cá nhân</li>
                            <li><i class="fas fa-check text-success me-2"></i>Quản lý đơn hàng</li>
                            <li><i class="fas fa-check text-success me-2"></i>Lưu danh sách yêu thích</li>
                            <li><i class="fas fa-check text-success me-2"></i>Nhận thông báo khuyến mãi</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký ngay
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Đã có tài khoản? Đăng nhập để truy cập vào hệ thống.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Truy cập nhanh dashboard</li>
                            <li><i class="fas fa-check text-success me-2"></i>Xem lịch sử đơn hàng</li>
                            <li><i class="fas fa-check text-success me-2"></i>Cập nhật thông tin cá nhân</li>
                            <li><i class="fas fa-check text-success me-2"></i>Quản lý tài khoản</li>
                        </ul>
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Accounts -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Tài khoản demo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="demo-account p-3 border rounded">
                                    <h6><i class="fas fa-crown me-2 text-warning"></i>Tài khoản Admin</h6>
                                    <p class="mb-2"><strong>Email:</strong> admin@aosomi.com</p>
                                    <p class="mb-2"><strong>Password:</strong> 12345678</p>
                                    <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập Admin
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="demo-account p-3 border rounded">
                                    <h6><i class="fas fa-user me-2 text-success"></i>Tài khoản Customer</h6>
                                    <p class="mb-2"><strong>Email:</strong> customer@aosomi.com</p>
                                    <p class="mb-2"><strong>Password:</strong> 12345678</p>
                                    <a href="{{ route('login') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập Customer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.feature-box {
    transition: transform 0.3s ease;
}

.feature-box:hover {
    transform: translateY(-5px);
}

.demo-account {
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.demo-account:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}
</style>
@endsection
