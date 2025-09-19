@extends('layouts.home')

@section('title', 'Giỏ hàng - Aosomi')
@section('page-title', 'Giỏ hàng')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Giỏ hàng của bạn</h1>
        <p class="lead">Kiểm tra và điều chỉnh sản phẩm trước khi thanh toán</p>
    </div>
</div>

<div class="container mb-5">
    @if($cartItems->count() > 0)
        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>Sản phẩm trong giỏ hàng
                            </h5>
                            <span class="badge bg-primary">{{ $totalItems }} sản phẩm</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr data-product-id="{{ $item->product->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->product->first_image }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="img-thumbnail me-3" 
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                                        @if(!$item->product->in_stock)
                                                            <br><span class="badge bg-danger">Hết hàng</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="price">{{ number_format($item->product->price) }}đ</div>
                                            </td>
                                            <td>
                                                <div class="input-group" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary btn-sm" 
                                                            onclick="updateQuantity({{ $item->product->id }}, {{ $item->quantity - 1 }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="form-control form-control-sm text-center" 
                                                           value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                           onchange="updateQuantity({{ $item->product->id }}, this.value)">
                                                    <button class="btn btn-outline-secondary btn-sm" 
                                                            onclick="updateQuantity({{ $item->product->id }}, {{ $item->quantity + 1 }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="price fw-bold">{{ number_format($item->product->price * $item->quantity) }}đ</div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-danger btn-sm" 
                                                            onclick="removeFromCart({{ $item->product->id }})"
                                                            title="Xóa khỏi giỏ hàng">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-outline-primary btn-sm" 
                                                            onclick="addToWishlist({{ $item->product->id }})"
                                                            title="Thêm vào yêu thích">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-danger" onclick="clearCart()">
                                <i class="fas fa-trash me-1"></i>Xóa tất cả
                            </button>
                            <a href="{{ route('products') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i>Tiếp tục mua sắm
                            </a>
                        </div>
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
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($totalAmount) }}đ</span>
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
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-lg" onclick="checkout()">
                                <i class="fas fa-credit-card me-2"></i>Thanh toán
                            </button>
                            <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-heart me-1"></i>Xem danh sách yêu thích
                            </a>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Thanh toán an toàn và bảo mật
                            </small>
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
    @else
        <!-- Giỏ hàng trống -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Giỏ hàng của bạn đang trống</h3>
                    <p class="text-muted mb-4">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Mua sắm ngay
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger btn-lg">
                            <i class="fas fa-heart me-2"></i>Xem yêu thích
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function updateQuantity(productId, quantity) {
    if (quantity < 0) return;
    
    fetch('{{ route("cart.update") }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
    });
}

function removeFromCart(productId) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        fetch(`{{ url('cart') }}/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                // Xóa row khỏi DOM
                const productRow = document.querySelector(`tr[data-product-id="${productId}"]`);
                if (productRow) {
                    productRow.remove();
                }
                
                // Cập nhật tổng tiền và số lượng
                updateCartTotals();
                
                // Hiển thị thông báo
                showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
                
                // Kiểm tra nếu không còn sản phẩm nào
                const remainingItems = document.querySelectorAll('tr[data-product-id]');
                if (remainingItems.length === 0) {
                    location.reload(); // Reload để hiển thị trang trống
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi xóa sản phẩm', 'error');
        });
    }
}

function clearCart() {
    if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
        fetch('{{ route("cart.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa giỏ hàng');
        });
    }
}

function addToWishlist(productId) {
    // TODO: Implement add to wishlist functionality
    alert('Đã thêm sản phẩm vào danh sách yêu thích!');
}

function checkout() {
    // Redirect to checkout page
    window.location.href = '{{ route("checkout") }}';
}

function updateCartTotals() {
    // Tính lại tổng tiền từ các sản phẩm còn lại
    let totalAmount = 0;
    let totalItems = 0;
    
    document.querySelectorAll('tr[data-product-id]').forEach(row => {
        const quantity = parseInt(row.querySelector('input[type="number"]').value) || 0;
        const priceText = row.querySelector('.price').textContent.replace(/[^\d]/g, '');
        const price = parseInt(priceText) || 0;
        
        totalAmount += price * quantity;
        totalItems += quantity;
    });
    
    // Cập nhật UI
    const totalElement = document.querySelector('.text-primary');
    if (totalElement) {
        totalElement.textContent = new Intl.NumberFormat('vi-VN').format(totalAmount) + 'đ';
    }
    
    const badgeElement = document.querySelector('.badge.bg-primary');
    if (badgeElement) {
        badgeElement.textContent = totalItems + ' sản phẩm';
    }
}

function showNotification(message, type) {
    // Tạo thông báo toast đơn giản
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Tự động ẩn sau 3 giây
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}
</script>
@endsection
