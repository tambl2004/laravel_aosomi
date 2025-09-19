@extends('layouts.home')

@section('title', 'Thêm địa chỉ mới - Aosomi')
@section('page-title', 'Thêm địa chỉ mới')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Thêm địa chỉ mới</h1>
        <p class="lead">Thêm địa chỉ giao hàng mới cho bạn</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Thông tin địa chỉ
                        </h5>
                        <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('addresses.store') }}">
                        @csrf
                        
                        <!-- Thông tin người nhận -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên người nhận <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" 
                                           value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" 
                                           value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Loại địa chỉ -->
                        <div class="mb-3">
                            <label class="form-label">Loại địa chỉ <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="home" 
                                               value="home" {{ old('type', 'home') == 'home' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="home">
                                            <i class="fas fa-home me-2 text-primary"></i>Nhà riêng
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="office" 
                                               value="office" {{ old('type') == 'office' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="office">
                                            <i class="fas fa-building me-2 text-info"></i>Văn phòng
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="other" 
                                               value="other" {{ old('type') == 'other' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="other">
                                            <i class="fas fa-map-marker-alt me-2 text-secondary"></i>Khác
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('type')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Địa chỉ chi tiết -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required 
                                      placeholder="Số nhà, tên đường, tên khu phố...">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thông tin địa phương -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" 
                                           value="{{ old('city') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="district" class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                           id="district" name="district" 
                                           value="{{ old('district') }}" required>
                                    @error('district')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ward" class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ward') is-invalid @enderror" 
                                           id="ward" name="ward" 
                                           value="{{ old('ward') }}" required>
                                    @error('ward')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Đặt làm địa chỉ mặc định -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" id="is_default" 
                                       value="1" {{ old('is_default') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_default">
                                    <i class="fas fa-star me-2 text-warning"></i>Đặt làm địa chỉ mặc định
                                </label>
                            </div>
                            <small class="text-muted">Địa chỉ mặc định sẽ được chọn tự động khi thanh toán</small>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Hủy
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Lưu địa chỉ
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gợi ý -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-lightbulb me-2"></i>Gợi ý
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Nhập địa chỉ chính xác để đảm bảo giao hàng thành công
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Số điện thoại phải đúng để shipper có thể liên hệ
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Đặt địa chỉ thường dùng làm mặc định để tiết kiệm thời gian
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
