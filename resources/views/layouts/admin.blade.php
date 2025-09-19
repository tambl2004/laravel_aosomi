<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Laravel Aosomi')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        
        .sidebar-brand:hover {
            color: white;
            text-decoration: none;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white !important;
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white !important;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .content-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: between;
            align-items: center;
        }
        
        .content-title {
            margin: 0;
            color: #333;
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .btn-customer-view {
            background: #27ae60;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-customer-view:hover {
            background: #229954;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: #34495e;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
            padding: 15px 20px;
        }
        
        .btn-primary {
            background: #3498db;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }
        
        .btn-success {
            background: #27ae60;
            border: none;
        }
        
        .btn-success:hover {
            background: #229954;
        }
        
        .btn-danger {
            background: #e74c3c;
            border: none;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .btn-warning {
            background: #f39c12;
            border: none;
        }
        
        .btn-warning:hover {
            background: #e67e22;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #27ae60;
            color: white;
        }
        
        .alert-danger {
            background: #e74c3c;
            color: white;
        }
        
        .alert-info {
            background: #3498db;
            color: white;
        }
        
        .stats-card {
            background: #34495e;
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
        }
        
        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .stats-card p {
            margin: 0;
            opacity: 0.9;
        }
        
        /* Table */
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background: #34495e;
            color: white;
            border: none;
            font-weight: 600;
        }
        
        .table tbody tr:hover {
            background-color: rgba(52, 73, 94, 0.05);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block;
            }
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-crown me-2"></i>Admin Panel
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags"></i>
                            Quản lý danh mục
                        </a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box"></i>
                                Quản lý sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i>
                                Quản lý người dùng
                            </a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-cart"></i>
                            Quản lý đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar"></i>
                            Báo cáo thống kê
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i>
                            Cài đặt hệ thống
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="fas fa-home me-1"></i>
                            Về trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Đăng xuất
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Content Header -->
            <div class="content-header">
                <div>
                    <button class="mobile-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="content-title">@yield('page-title', 'Dashboard')</h1>
                </div>
              
            </div>
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
        
        // Đóng sidebar khi click bên ngoài trên mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !mobileToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
        
        // Tự động ẩn thông báo sau 5 giây
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>
