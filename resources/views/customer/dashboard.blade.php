@extends('layouts.customer')

@section('title', 'Customer Dashboard - Laravel Aosomi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>Chào mừng, {{ Auth::user()->name }}!
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h3>5</h3>
                            <p><i class="fas fa-shopping-cart me-2"></i>Đơn hàng của tôi</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h3>12</h3>
                            <p><i class="fas fa-heart me-2"></i>Sản phẩm yêu thích</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h3>3</h3>
                            <p><i class="fas fa-star me-2"></i>Đánh giá đã viết</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h3>2</h3>
                            <p><i class="fas fa-gift me-2"></i>Phiếu giảm giá</p>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-shopping-cart me-2"></i>Đơn hàng gần đây
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#DH001</td>
                                                <td>19/09/2025</td>
                                                <td>1,500,000đ</td>
                                                <td><span class="badge bg-success">Đã giao</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#DH002</td>
                                                <td>18/09/2025</td>
                                                <td>2,300,000đ</td>
                                                <td><span class="badge bg-warning">Đang giao</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#DH003</td>
                                                <td>17/09/2025</td>
                                                <td>850,000đ</td>
                                                <td><span class="badge bg-info">Đang xử lý</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-heart me-2"></i>Sản phẩm yêu thích
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="https://via.placeholder.com/50x50" class="rounded" alt="Product">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">iPhone 15 Pro</h6>
                                                <small class="text-muted">25,000,000đ</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="https://via.placeholder.com/50x50" class="rounded" alt="Product">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">MacBook Air M2</h6>
                                                <small class="text-muted">28,000,000đ</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="https://via.placeholder.com/50x50" class="rounded" alt="Product">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">AirPods Pro</h6>
                                                <small class="text-muted">5,500,000đ</small>
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
                                    <i class="fas fa-bolt me-2"></i>Hành động nhanh
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <button class="btn btn-success w-100 mb-3">
                                            <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success w-100 mb-3">
                                            <i class="fas fa-list me-2"></i>Xem đơn hàng
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success w-100 mb-3">
                                            <i class="fas fa-heart me-2"></i>Danh sách yêu thích
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success w-100 mb-3">
                                            <i class="fas fa-user me-2"></i>Thông tin cá nhân
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
