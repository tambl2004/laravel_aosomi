@extends('layouts.home')

@section('title', 'Danh sách yêu thích - Aosomi')
@section('page-title', 'Danh sách yêu thích')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Danh sách yêu thích</h1>
        <p class="lead">Những sản phẩm bạn đã lưu để mua sau</p>
    </div>
</div>

<div class="container mb-5">
    @if($wishlistItems->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>
                        <i class="fas fa-heart me-2 text-danger"></i>
                        {{ $wishlistItems->total() }} sản phẩm yêu thích
                    </h5>
                    <div class="btn-group">
                        <button class="btn btn-outline-danger" onclick="clearWishlist()">
                            <i class="fas fa-trash me-1"></i>Xóa tất cả
                        </button>
                        <a href="{{ route('products') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>Thêm sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            @foreach($wishlistItems as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-product-id="{{ $item->product->id }}">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="{{ $item->product->first_image }}" alt="{{ $item->product->name }}" class="product-image">
                            <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" 
                                    onclick="removeFromWishlist({{ $item->product->id }})"
                                    title="Xóa khỏi yêu thích">
                                <i class="fas fa-times"></i>
                            </button>
                            @if($item->product->is_featured)
                                <span class="position-absolute top-0 start-0 badge bg-warning m-2">
                                    <i class="fas fa-star me-1"></i>Nổi bật
                                </span>
                            @endif
                            @if(!$item->product->in_stock)
                                <span class="position-absolute bottom-0 start-0 badge bg-danger m-2">
                                    Hết hàng
                                </span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item->product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($item->product->description, 80) }}</p>
                            <div class="mt-auto">
                                <div class="price mb-2">{{ number_format($item->product->price) }}đ</div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>{{ $item->product->category->name }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-box me-1"></i>{{ $item->product->stock }} sản phẩm
                                    </small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>Thêm vào {{ $item->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-grid gap-2">
                                @if($item->product->in_stock)
                                    <button class="btn btn-success" onclick="moveToCart({{ $item->product->id }})">
                                        <i class="fas fa-shopping-cart me-1"></i>Thêm vào giỏ
                                    </button>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-times me-1"></i>Hết hàng
                                    </button>
                                @endif
                                <button class="btn btn-outline-danger" onclick="removeFromWishlist({{ $item->product->id }})">
                                    <i class="fas fa-heart-broken me-1"></i>Xóa khỏi yêu thích
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    {{ $wishlistItems->links() }}
                </nav>
            </div>
        </div>
    @else
        <!-- Danh sách yêu thích trống -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-heart fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Danh sách yêu thích của bạn đang trống</h3>
                    <p class="text-muted mb-4">Hãy thêm một số sản phẩm vào danh sách yêu thích để lưu lại cho lần sau</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Khám phá sản phẩm
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Xem giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function removeFromWishlist(productId) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi danh sách yêu thích?')) {
        fetch(`{{ url('wishlist') }}/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                // Xóa element khỏi DOM
                const productCard = document.querySelector(`[data-product-id="${productId}"]`);
                if (productCard) {
                    productCard.remove();
                }
                
                // Cập nhật số lượng sản phẩm
                updateWishlistCount();
                
                // Hiển thị thông báo
                showNotification('Đã xóa sản phẩm khỏi danh sách yêu thích!', 'success');
                
                // Kiểm tra nếu không còn sản phẩm nào
                const remainingProducts = document.querySelectorAll('[data-product-id]');
                if (remainingProducts.length === 0) {
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

function clearWishlist() {
    if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi danh sách yêu thích?')) {
        fetch('{{ route("wishlist.clear") }}', {
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
            alert('Có lỗi xảy ra khi xóa danh sách yêu thích');
        });
    }
}

function moveToCart(productId) {
    fetch(`{{ url('wishlist') }}/${productId}/move-to-cart`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            // Xóa element khỏi DOM
            const productCard = document.querySelector(`[data-product-id="${productId}"]`);
            if (productCard) {
                productCard.remove();
            }
            
            // Cập nhật số lượng
            updateWishlistCount();
            updateCartCount();
            
            // Hiển thị thông báo
            showNotification('Đã chuyển sản phẩm vào giỏ hàng!', 'success');
            
            // Kiểm tra nếu không còn sản phẩm nào
            const remainingProducts = document.querySelectorAll('[data-product-id]');
            if (remainingProducts.length === 0) {
                location.reload(); // Reload để hiển thị trang trống
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi chuyển sản phẩm vào giỏ hàng', 'error');
    });
}

function updateWishlistCount() {
    // Cập nhật số lượng trong header nếu có
    const countElement = document.querySelector('.wishlist-count');
    if (countElement) {
        const currentCount = parseInt(countElement.textContent) || 0;
        countElement.textContent = Math.max(0, currentCount - 1);
    }
}

function updateCartCount() {
    // Cập nhật số lượng giỏ hàng trong header nếu có
    const countElement = document.querySelector('.cart-count');
    if (countElement) {
        const currentCount = parseInt(countElement.textContent) || 0;
        countElement.textContent = currentCount + 1;
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
