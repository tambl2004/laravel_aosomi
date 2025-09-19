<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aosomi - Cửa hàng áo sơ mi cao cấp')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            min-height: 100vh;
            padding: 0;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50 !important;
        }
        
        .nav-link {
            color: #495057 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 10px 15px !important;
        }
        
        .nav-link:hover {
            color: #3498db !important;
        }
        
        .btn-outline-primary {
            border-color: #3498db;
            color: #3498db;
        }
        
        .btn-outline-primary:hover {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background: #2c3e50;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
            padding: 15px 20px;
        }
        
        .btn-primary {
            background: #3498db;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-success {
            background: #27ae60;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }
        
        .btn-warning {
            background: #f39c12;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }
        
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
        }
        
        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .product-image {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        
        .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e74c3c;
        }
        
        .old-price {
            text-decoration: line-through;
            color: #95a5a6;
            font-size: 1rem;
        }
        
        .category-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .category-card:hover {
            border-color: #3498db;
            transform: translateY(-5px);
        }
        
        .category-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 20px;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: #3498db;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-tshirt me-2"></i>Aosomi
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products') }}">
                            <i class="fas fa-tshirt me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i>Giới thiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>Liên hệ
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('wishlist.index') }}">
                                <i class="fas fa-heart me-1"></i>Yêu thích
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                            </a>
                        </li>
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-crown me-1"></i>Admin Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.dashboard') }}">
                                    <i class="fas fa-user me-1"></i>Customer Dashboard
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-container">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
