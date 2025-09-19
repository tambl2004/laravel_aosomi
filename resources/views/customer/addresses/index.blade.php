@extends('layouts.home')

@section('title', 'Địa chỉ của tôi - Aosomi')
@section('page-title', 'Địa chỉ của tôi')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Địa chỉ của tôi</h1>
        <p class="lead">Quản lý địa chỉ giao hàng của bạn</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Header với nút thêm địa chỉ -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-map-marker-alt me-2 text-primary"></i>Danh sách địa chỉ
        </h4>
        <a href="{{ route('addresses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm địa chỉ mới
        </a>
    </div>

    <!-- Danh sách địa chỉ -->
    @forelse($addresses as $address)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                @if($address->type === 'home')
                                    <i class="fas fa-home fa-2x text-primary"></i>
                                @elseif($address->type === 'office')
                                    <i class="fas fa-building fa-2x text-info"></i>
                                @else
                                    <i class="fas fa-map-marker-alt fa-2x text-secondary"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="mb-0 me-3">{{ $address->name }}</h5>
                                    <span class="badge bg-{{ $address->type === 'home' ? 'primary' : ($address->type === 'office' ? 'info' : 'secondary') }}">
                                        {{ $address->type_name }}
                                    </span>
                                    @if($address->is_default)
                                        <span class="badge bg-success ms-2">
                                            <i class="fas fa-star me-1"></i>Mặc định
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    <strong>{{ $address->phone }}</strong>
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    {{ $address->full_address }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2">
                            @if(!$address->is_default)
                                <form method="POST" action="{{ route('addresses.set-default', $address) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                        <i class="fas fa-star me-1"></i>Đặt mặc định
                                    </button>
                                </form>
                            @endif
                            <div class="btn-group w-100">
                                <a href="{{ route('addresses.edit', $address) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('addresses.destroy', $address) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fas fa-map-marker-alt fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Chưa có địa chỉ nào</h5>
            <p class="text-muted">Hãy thêm địa chỉ đầu tiên để thuận tiện khi đặt hàng!</p>
            <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Thêm địa chỉ đầu tiên
            </a>
        </div>
    @endforelse

    <!-- Thông tin bổ sung -->
    @if($addresses->count() > 0)
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-info-circle me-2"></i>Thông tin về địa chỉ
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Địa chỉ mặc định sẽ được chọn tự động khi thanh toán
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Bạn có thể có nhiều địa chỉ để linh hoạt giao hàng
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Địa chỉ được phân loại theo: Nhà riêng, Văn phòng, Khác
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Có thể chỉnh sửa hoặc xóa địa chỉ bất kỳ lúc nào
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
