@extends('layouts.home')

@section('title', 'Thanh toán - Aosomi')
@section('page-title', 'Thanh toán')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Thanh toán đơn hàng</h1>
        <p class="lead">Hoàn tất thông tin để đặt hàng</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Form thông tin khách hàng -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Thông tin khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf
                        
                        <!-- Thông tin sẽ được lấy tự động từ địa chỉ được chọn -->
                        
                        <!-- Chọn địa chỉ -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <a href="{{ route('addresses.create') }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-plus me-1"></i>Thêm địa chỉ mới
                                </a>
                            </div>
                            
                            <!-- Danh sách địa chỉ -->
                            <div id="address-list">
                                @php
                                    $userAddresses = auth()->user()->addresses()->orderBy('is_default', 'desc')->get();
                                @endphp
                                
                                @if($userAddresses->count() > 0)
                                    @foreach($userAddresses as $address)
                                        <div class="card mb-2 address-option" data-address-id="{{ $address->id }}">
                                            <div class="card-body p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="address_id" 
                                                           id="address_{{ $address->id }}" 
                                                           value="{{ $address->id }}" 
                                                           {{ old('address_id', $address->is_default ? $address->id : '') == $address->id ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="address_{{ $address->id }}">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <strong>{{ $address->name }}</strong>
                                                                    <span class="badge bg-{{ $address->type === 'home' ? 'primary' : ($address->type === 'office' ? 'info' : 'secondary') }} ms-2">
                                                                        {{ $address->type_name }}
                                                                    </span>
                                                                    @if($address->is_default)
                                                                        <span class="badge bg-success ms-2">
                                                                            <i class="fas fa-star me-1"></i>Mặc định
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-phone me-1"></i>{{ $address->phone }}
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $address->full_address }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Bạn chưa có địa chỉ nào. 
                                        <a href="{{ route('addresses.create') }}" target="_blank" class="alert-link">Thêm địa chỉ ngay</a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Form nhập địa chỉ thủ công (ẩn mặc định) -->
                            <div id="manual-address-form" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Nhập địa chỉ giao hàng thủ công
                                </div>
                                
                                <!-- Thông tin khách hàng khi nhập thủ công -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="manual_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                                   id="manual_name" name="customer_name" 
                                                   value="{{ old('customer_name', auth()->user()->name) }}">
                                            @error('customer_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="manual_email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                                   id="manual_email" name="customer_email" 
                                                   value="{{ old('customer_email', auth()->user()->email) }}">
                                            @error('customer_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="manual_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                           id="manual_phone" name="customer_phone" 
                                           value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="manual_address" class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                              id="manual_address" name="customer_address" rows="2">{{ old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="manual_city" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('customer_city') is-invalid @enderror" 
                                                   id="manual_city" name="customer_city" value="{{ old('customer_city') }}">
                                            @error('customer_city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="manual_district" class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('customer_district') is-invalid @enderror" 
                                                   id="manual_district" name="customer_district" value="{{ old('customer_district') }}">
                                            @error('customer_district')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="manual_ward" class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('customer_ward') is-invalid @enderror" 
                                                   id="manual_ward" name="customer_ward" value="{{ old('customer_ward') }}">
                                            @error('customer_ward')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Nút chuyển đổi -->
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggle-address-form">
                                    <i class="fas fa-edit me-1"></i>Nhập địa chỉ thủ công
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Ghi chú thêm cho đơn hàng...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Phương thức thanh toán <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" 
                                               value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" 
                                               value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bank_transfer">
                                            <i class="fas fa-university me-2 text-primary"></i>Chuyển khoản ngân hàng
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="momo" 
                                               value="momo" {{ old('payment_method') == 'momo' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="momo">
                                            <i class="fas fa-mobile-alt me-2" style="color: #d82d8b;"></i>Ví MoMo
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="zalopay" 
                                               value="zalopay" {{ old('payment_method') == 'zalopay' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="zalopay">
                                            <i class="fas fa-wallet me-2" style="color: #0068ff;"></i>ZaloPay
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            
                            <!-- Thông tin thanh toán -->
                            <div id="payment-info" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Thông tin thanh toán:</h6>
                                    <div id="cod-info" style="display: none;">
                                        <p class="mb-0">Bạn sẽ thanh toán bằng tiền mặt khi nhận hàng. Phí COD: <strong>Miễn phí</strong></p>
                                    </div>
                                    <div id="bank-info" style="display: none;">
                                        <p class="mb-0"><strong>Ngân hàng:</strong> Vietcombank<br>
                                        <strong>STK:</strong> 1234567890<br>
                                        <strong>Chủ TK:</strong> Công ty TNHH Aosomi<br>
                                        <strong>Nội dung:</strong> Thanh toán đơn hàng [Mã đơn hàng]</p>
                                    </div>
                                    <div id="momo-info" style="display: none;">
                                        <p class="mb-0"><strong>Số điện thoại:</strong> 0901234567<br>
                                        <strong>Tên:</strong> Công ty TNHH Aosomi<br>
                                        <strong>Nội dung:</strong> Thanh toán đơn hàng [Mã đơn hàng]</p>
                                    </div>
                                    <div id="zalopay-info" style="display: none;">
                                        <p class="mb-0">Quét mã QR ZaloPay để thanh toán hoặc chuyển khoản qua ứng dụng ZaloPay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check me-2"></i>Đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Tóm tắt đơn hàng -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Danh sách sản phẩm -->
                    <div class="mb-3">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $item->product->first_image }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="img-thumbnail me-2" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                    <small class="text-muted">Số lượng: {{ $item->quantity }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">{{ number_format($item->product->price * $item->quantity) }}đ</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($subtotal) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-primary">{{ number_format($totalAmount) }}đ</strong>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Đơn hàng sẽ được xử lý trong vòng 24 giờ. 
                        Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng.
                    </div>
                </div>
            </div>
            
            <!-- Thông tin hỗ trợ -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-headset me-2"></i>Hỗ trợ khách hàng
                    </h6>
                    <p class="card-text small text-muted">
                        Cần hỗ trợ? Liên hệ với chúng tôi qua hotline <strong>1900 1234</strong> 
                        hoặc email <strong>support@aosomi.com</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Xử lý hiển thị thông tin thanh toán
document.addEventListener('DOMContentLoaded', function() {
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const paymentInfo = document.getElementById('payment-info');
    const codInfo = document.getElementById('cod-info');
    const bankInfo = document.getElementById('bank-info');
    const momoInfo = document.getElementById('momo-info');
    const zalopayInfo = document.getElementById('zalopay-info');
    
    // Ẩn tất cả thông tin thanh toán
    function hideAllPaymentInfo() {
        codInfo.style.display = 'none';
        bankInfo.style.display = 'none';
        momoInfo.style.display = 'none';
        zalopayInfo.style.display = 'none';
    }
    
    // Hiển thị thông tin thanh toán tương ứng
    function showPaymentInfo(method) {
        hideAllPaymentInfo();
        paymentInfo.style.display = 'block';
        
        switch(method) {
            case 'cod':
                codInfo.style.display = 'block';
                break;
            case 'bank_transfer':
                bankInfo.style.display = 'block';
                break;
            case 'momo':
                momoInfo.style.display = 'block';
                break;
            case 'zalopay':
                zalopayInfo.style.display = 'block';
                break;
        }
    }
    
    // Lắng nghe sự kiện thay đổi phương thức thanh toán
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                showPaymentInfo(this.value);
            }
        });
    });
    
    // Hiển thị thông tin cho phương thức được chọn mặc định
    const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
    if (checkedRadio) {
        showPaymentInfo(checkedRadio.value);
    }
    
    // Xử lý chuyển đổi giữa chọn địa chỉ và nhập thủ công
    const toggleBtn = document.getElementById('toggle-address-form');
    const addressList = document.getElementById('address-list');
    const manualForm = document.getElementById('manual-address-form');
    let isManualMode = false;
    
    toggleBtn.addEventListener('click', function() {
        isManualMode = !isManualMode;
        
        if (isManualMode) {
            // Chuyển sang chế độ nhập thủ công
            addressList.style.display = 'none';
            manualForm.style.display = 'block';
            toggleBtn.innerHTML = '<i class="fas fa-list me-1"></i>Chọn từ danh sách';
            
            // Bỏ chọn tất cả radio address
            document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                radio.checked = false;
            });
        } else {
            // Chuyển sang chế độ chọn từ danh sách
            addressList.style.display = 'block';
            manualForm.style.display = 'none';
            toggleBtn.innerHTML = '<i class="fas fa-edit me-1"></i>Nhập địa chỉ thủ công';
            
            // Xóa giá trị các field nhập thủ công
            document.getElementById('manual_name').value = '';
            document.getElementById('manual_email').value = '';
            document.getElementById('manual_phone').value = '';
            document.getElementById('manual_address').value = '';
            document.getElementById('manual_city').value = '';
            document.getElementById('manual_district').value = '';
            document.getElementById('manual_ward').value = '';
        }
    });
    
    // Tự động điền thông tin khi chọn địa chỉ
    document.querySelectorAll('input[name="address_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                // Có thể thêm logic để điền thông tin từ địa chỉ được chọn
                console.log('Địa chỉ được chọn:', this.value);
            }
        });
    });
});
</script>
@endsection
