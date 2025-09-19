@extends('layouts.home')

@section('title', 'Sản phẩm - Aosomi')
@section('page-title', 'Sản phẩm')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Sản phẩm áo sơ mi cao cấp</h1>
        <p class="lead">Khám phá bộ sưu tập áo sơ mi đa dạng với chất liệu cao cấp và thiết kế tinh tế</p>
    </div>
</div>

<!-- Filter và Search -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('products') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nhập tên sản phẩm...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Danh mục</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Sắp xếp</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách sản phẩm -->
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="section-title text-center">
                <i class="fas fa-tshirt me-2"></i>Sản phẩm
                @if(request('search') || request('category'))
                    <small class="text-muted">({{ $products->total() }} kết quả)</small>
                @endif
            </h2>
        </div>
    </div>
    
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="{{ $product->first_image }}" alt="{{ $product->name }}" class="product-image">
                            @if($product->is_featured)
                                <span class="position-absolute top-0 start-0 badge bg-warning m-2">
                                    <i class="fas fa-star me-1"></i>Nổi bật
                                </span>
                            @endif
                            @if(!$product->in_stock)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                                    Hết hàng
                                </span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            <div class="mt-auto">
                                <div class="price mb-2">
                                    {{ number_format($product->price) }}đ
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-box me-1"></i>{{ $product->stock }} sản phẩm
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-danger" onclick="toggleWishlist({{ $product->id }})" id="wishlist-btn-{{ $product->id }}">
                                    <i class="fas fa-heart me-1"></i>Yêu thích
                                </button>
                                @if($product->in_stock)
                                    <button class="btn btn-success" onclick="addToCart({{ $product->id }})">
                                        <i class="fas fa-shopping-cart me-1"></i>Thêm vào giỏ
                                    </button>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-times me-1"></i>Hết hàng
                                    </button>
                                @endif
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
                    {{ $products->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                    <p class="text-muted">Hãy thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-1"></i>Xem tất cả sản phẩm
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function toggleWishlist(productId) {
    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('wishlist-btn-' + productId);
            const icon = btn.querySelector('i');
            
            if (data.action === 'added') {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
            }
            
            // Hiển thị thông báo
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi cập nhật danh sách yêu thích', 'error');
    });
}

function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Có thể cập nhật số lượng giỏ hàng ở navbar nếu cần
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
    });
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
