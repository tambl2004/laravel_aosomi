@extends('layouts.home')

@section('title', 'Giới thiệu - Aosomi')
@section('page-title', 'Giới thiệu')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Về chúng tôi</h1>
        <p class="lead">Aosomi - Thương hiệu áo sơ mi cao cấp với hơn 10 năm kinh nghiệm</p>
    </div>
</div>

<!-- Giới thiệu chính -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <i class="fas fa-tshirt feature-icon"></i>
                        <h2 class="section-title">Câu chuyện của Aosomi</h2>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h4 class="text-primary mb-3">
                                <i class="fas fa-star me-2"></i>Sứ mệnh
                            </h4>
                            <p class="text-muted">
                                Chúng tôi cam kết mang đến những sản phẩm áo sơ mi chất lượng cao nhất, 
                                với thiết kế tinh tế và chất liệu bền đẹp, giúp khách hàng tự tin trong mọi hoàn cảnh.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-primary mb-3">
                                <i class="fas fa-eye me-2"></i>Tầm nhìn
                            </h4>
                            <p class="text-muted">
                                Trở thành thương hiệu áo sơ mi hàng đầu Việt Nam, được tin tưởng và yêu mến 
                                bởi khách hàng trong nước và quốc tế.
                            </p>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-heart me-2"></i>Giá trị cốt lõi
                        </h4>
                        <p class="text-muted lead">
                            Chất lượng - Uy tín - Sáng tạo - Phục vụ tận tâm
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lịch sử phát triển -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title text-center mb-5">
                <i class="fas fa-history me-2"></i>Hành trình phát triển
            </h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h5 class="card-title">2010</h5>
                    <h6 class="text-primary">Khởi đầu</h6>
                    <p class="card-text text-muted small">
                        Thành lập với tầm nhìn mang đến những sản phẩm áo sơ mi chất lượng cao
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5 class="card-title">2015</h5>
                    <h6 class="text-primary">Phát triển</h6>
                    <p class="card-text text-muted small">
                        Mở rộng quy mô sản xuất và phát triển thị trường trong nước
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h5 class="card-title">2018</h5>
                    <h6 class="text-primary">Mở rộng</h6>
                    <p class="card-text text-muted small">
                        Xuất khẩu sản phẩm ra thị trường quốc tế và nhận được nhiều đánh giá tích cực
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h5 class="card-title">2024</h5>
                    <h6 class="text-primary">Thành công</h6>
                    <p class="card-text text-muted small">
                        Trở thành thương hiệu áo sơ mi được tin tưởng hàng đầu tại Việt Nam
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đội ngũ -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title text-center mb-5">
                <i class="fas fa-users me-2"></i>Đội ngũ của chúng tôi
            </h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-user-tie fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Nguyễn Văn A</h5>
                    <h6 class="text-primary">Giám đốc điều hành</h6>
                    <p class="card-text text-muted small">
                        Với hơn 15 năm kinh nghiệm trong ngành thời trang, 
                        anh đã dẫn dắt Aosomi phát triển thành công.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-palette fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Trần Thị B</h5>
                    <h6 class="text-primary">Giám đốc thiết kế</h6>
                    <p class="card-text text-muted small">
                        Chuyên gia thiết kế với tầm nhìn sáng tạo, 
                        tạo ra những sản phẩm độc đáo và thời trang.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-cogs fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Lê Văn C</h5>
                    <h6 class="text-primary">Giám đốc sản xuất</h6>
                    <p class="card-text text-muted small">
                        Đảm bảo chất lượng sản phẩm với quy trình sản xuất 
                        hiện đại và nghiêm ngặt.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cam kết -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center p-5">
                    <h2 class="mb-4">
                        <i class="fas fa-handshake me-2"></i>Cam kết của chúng tôi
                    </h2>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-gem fa-2x mb-2"></i>
                            <h5>Chất lượng cao</h5>
                            <p class="small">Sử dụng chất liệu cao cấp nhất</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-shipping-fast fa-2x mb-2"></i>
                            <h5>Giao hàng nhanh</h5>
                            <p class="small">Giao hàng trong 24h tại TP.HCM</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-undo fa-2x mb-2"></i>
                            <h5>Đổi trả dễ dàng</h5>
                            <p class="small">Đổi trả trong 7 ngày</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-headset fa-2x mb-2"></i>
                            <h5>Hỗ trợ 24/7</h5>
                            <p class="small">Hotline hỗ trợ khách hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
