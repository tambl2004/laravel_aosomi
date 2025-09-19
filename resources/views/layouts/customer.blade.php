<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Customer Dashboard - Laravel Aosomi')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }
        
        .main-content {
            margin-top: 80px;
            padding: 30px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
            padding: 20px;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: white;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #17a2b8, #6f42c1);
            color: white;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .stats-card p {
            margin: 0;
            opacity: 0.9;
        }
        
        .sidebar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .sidebar h5 {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .sidebar .nav-link {
            color: #6c757d !important;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white !important;
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                <i class="fas fa-user me-2"></i>Customer Panel
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
                        <a class="nav-link" href="{{ route('customer.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products') }}">
                            <i class="fas fa-box me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Đơn hàng của tôi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('addresses.index') }}">
                            <i class="fas fa-map-marker-alt me-1"></i>Địa chỉ của tôi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist.index') }}">
                            <i class="fas fa-heart me-1"></i>Yêu thích
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-bag me-1"></i>Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>Liên hệ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i>Về chúng tôi
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user() ? Auth::user()->name : 'Khách' }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fas fa-home me-2"></i>Trang chủ</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('products') }}"><i class="fas fa-box me-2"></i>Sản phẩm</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-shopping-cart me-2"></i>Đơn hàng của tôi</a></li>
                            <li><a class="dropdown-item" href="{{ route('addresses.index') }}"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ của tôi</a></li>
                            <li><a class="dropdown-item" href="{{ route('wishlist.index') }}"><i class="fas fa-heart me-2"></i>Yêu thích</a></li>
                            <li><a class="dropdown-item" href="{{ route('cart.index') }}"><i class="fas fa-shopping-bag me-2"></i>Giỏ hàng</a></li>
                            <li><a class="dropdown-item" href="{{ route('contact') }}"><i class="fas fa-envelope me-2"></i>Liên hệ</a></li>
                            <li><a class="dropdown-item" href="{{ route('about') }}"><i class="fas fa-info-circle me-2"></i>Về chúng tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Thông tin cá nhân</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
