@extends('layouts.admin')

@section('title', 'Admin Dashboard - Laravel Aosomi')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="stats-card">
            <h3>{{ \App\Models\User::count() }}</h3>
            <p><i class="fas fa-users me-2"></i>Tổng người dùng</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <h3>{{ \App\Models\Category::count() }}</h3>
            <p><i class="fas fa-tags me-2"></i>Danh mục</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <h3>{{ \App\Models\Product::count() }}</h3>
            <p><i class="fas fa-box me-2"></i>Sản phẩm</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <h3>{{ \App\Models\Product::where('is_featured', true)->count() }}</h3>
            <p><i class="fas fa-star me-2"></i>Sản phẩm nổi bật</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Thống kê hoạt động
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Biểu đồ thống kê sẽ được hiển thị ở đây...</p>
                <div class="text-center py-5">
                    <i class="fas fa-chart-bar fa-3x text-muted"></i>
                    <p class="mt-3 text-muted">Chưa có dữ liệu để hiển thị</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bell me-2"></i>Thông báo gần đây
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-plus text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Người dùng mới</h6>
                                <small class="text-muted">5 phút trước</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shopping-cart text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Đơn hàng mới</h6>
                                <small class="text-muted">15 phút trước</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Cảnh báo hệ thống</h6>
                                <small class="text-muted">1 giờ trước</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>Hành động nhanh
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-tags me-2"></i>Quản lý danh mục
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-box me-2"></i>Quản lý sản phẩm
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-users me-2"></i>Quản lý người dùng
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-chart-line me-2"></i>Xem báo cáo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
