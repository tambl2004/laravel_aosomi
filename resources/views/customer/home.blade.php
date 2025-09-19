@extends('layouts.home')

@section('title', 'Aosomi - Cửa hàng áo sơ mi cao cấp')

@section('content')
        <!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Áo sơ mi cao cấp</h1>
                <p class="lead mb-4">Khám phá bộ sưu tập áo sơ mi đa dạng với chất liệu cao cấp và thiết kế hiện đại. Từ công sở đến dạo phố, chúng tôi có tất cả những gì bạn cần.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Mua ngay
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-eye me-2"></i>Về chúng tôi
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1594938298605-c04c5d57d3e8?w=600" 
                     alt="Áo sơ mi cao cấp" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<section id="categories" class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Danh mục sản phẩm</h2>
                <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="category-image">
                        <h5 class="fw-bold">{{ $category->name }}</h5>
                        <p class="text-muted">{{ Str::limit($category->description, 60) }}</p>
                        <a href="{{ route('products') }}" class="btn btn-outline-primary">Xem sản phẩm</a>
                    </div>
                </div>
            @endforeach
                        </div>
                    </div>
</section>

<!-- Featured Products Section -->
<section id="products" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card">
                        <img src="{{ $product->first_image }}" alt="{{ $product->name }}" class="product-image">
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                                @if($product->is_featured)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star me-1"></i>Nổi bật
                                    </span>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                            <p class="text-muted small mb-3">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="price">{{ number_format($product->price) }}đ</div>
                                </div>
                                <button class="btn btn-primary btn-sm" onclick="viewProduct({{ $product->id }})">
                                    <i class="fas fa-eye me-1"></i>Xem chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        <div class="text-center mt-4">
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-eye me-2"></i>Xem tất cả sản phẩm
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Tại sao chọn Aosomi?</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-award feature-icon"></i>
                    <h4 class="fw-bold">Chất lượng cao</h4>
                    <p class="text-muted">Sử dụng chất liệu cotton cao cấp, đảm bảo độ bền và thoải mái khi mặc.</p>
                    </div>
                    </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-shipping-fast feature-icon"></i>
                    <h4 class="fw-bold">Giao hàng nhanh</h4>
                    <p class="text-muted">Miễn phí vận chuyển cho đơn hàng từ 500k, giao hàng trong 24h tại TP.HCM.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-undo feature-icon"></i>
                    <h4 class="fw-bold">Đổi trả dễ dàng</h4>
                    <p class="text-muted">Chính sách đổi trả linh hoạt trong 30 ngày, đảm bảo quyền lợi khách hàng.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title text-start">Về Aosomi</h2>
                <p class="lead">Chúng tôi tự hào là thương hiệu áo sơ mi hàng đầu Việt Nam với hơn 10 năm kinh nghiệm trong ngành thời trang.</p>
                <p>Với đội ngũ thiết kế chuyên nghiệp và quy trình sản xuất hiện đại, Aosomi cam kết mang đến những sản phẩm chất lượng cao nhất cho khách hàng.</p>
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="fw-bold text-primary">10+</h3>
                            <p class="text-muted">Năm kinh nghiệm</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="fw-bold text-primary">50K+</h3>
                            <p class="text-muted">Khách hàng tin tưởng</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600" 
                     alt="Cửa hàng Aosomi" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white;">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Sẵn sàng tìm kiếm áo sơ mi hoàn hảo?</h2>
        <p class="lead mb-4">Khám phá bộ sưu tập đa dạng của chúng tôi và tìm ra phong cách phù hợp với bạn.</p>
        <div class="d-flex justify-content-center gap-3">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-crown me-2"></i>Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-user me-2"></i>Dashboard cá nhân
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Đăng ký ngay
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                </a>
            @endauth
        </div>
    </div>
</section>

<script>
function viewProduct(productId) {
    // TODO: Implement product detail view
    alert('Xem chi tiết sản phẩm ID: ' + productId);
}
</script>
@endsection
