@extends('layouts.home')

@section('title', 'Liên hệ - Aosomi')
@section('page-title', 'Liên hệ')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Liên hệ với chúng tôi</h1>
        <p class="lead">Chúng tôi luôn sẵn sàng hỗ trợ và tư vấn cho bạn</p>
    </div>
</div>

<!-- Thông tin liên hệ -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="card-title">Địa chỉ</h5>
                    <p class="card-text text-muted">
                        123 Đường ABC, Quận 1<br>
                        TP. Hồ Chí Minh, Việt Nam
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="card-title">Điện thoại</h5>
                    <p class="card-text text-muted">
                        Hotline: <strong>1900 1234</strong><br>
                        Mobile: <strong>0901 234 567</strong>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="feature-icon text-primary mb-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="card-title">Email</h5>
                    <p class="card-text text-muted">
                        info@aosomi.com<br>
                        support@aosomi.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form liên hệ -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn cho chúng tôi
                    </h4>
                </div>
                <div class="card-body">
                    <form id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="">Chọn chủ đề</option>
                                    <option value="general">Thông tin chung</option>
                                    <option value="product">Hỏi về sản phẩm</option>
                                    <option value="order">Hỏi về đơn hàng</option>
                                    <option value="support">Hỗ trợ kỹ thuật</option>
                                    <option value="complaint">Khiếu nại</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung tin nhắn <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      placeholder="Vui lòng mô tả chi tiết vấn đề hoặc câu hỏi của bạn..." required></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Giờ làm việc -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-clock me-2"></i>Giờ làm việc
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Cửa hàng</h6>
                            <p class="mb-2">
                                <strong>Thứ 2 - Thứ 6:</strong> 8:00 - 20:00<br>
                                <strong>Thứ 7:</strong> 8:00 - 18:00<br>
                                <strong>Chủ nhật:</strong> 9:00 - 17:00
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Hotline</h6>
                            <p class="mb-2">
                                <strong>Thứ 2 - Chủ nhật:</strong><br>
                                8:00 - 22:00
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ -->
<div class="container mb-5">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title text-center mb-5">
                <i class="fas fa-question-circle me-2"></i>Câu hỏi thường gặp
            </h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                            Làm thế nào để đặt hàng?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Bạn có thể đặt hàng trực tiếp tại cửa hàng hoặc gọi hotline 1900 1234. 
                            Chúng tôi sẽ tư vấn và hỗ trợ bạn chọn size phù hợp.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                            Chính sách đổi trả như thế nào?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Chúng tôi hỗ trợ đổi trả trong vòng 7 ngày kể từ ngày mua hàng. 
                            Sản phẩm phải còn nguyên vẹn, chưa sử dụng và có hóa đơn mua hàng.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                            Có giao hàng tận nơi không?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Có, chúng tôi giao hàng tận nơi trong TP.HCM với phí ship 30.000đ. 
                            Đơn hàng trên 500.000đ sẽ được miễn phí ship.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                            Làm sao để chọn size phù hợp?
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Chúng tôi có bảng size chi tiết cho từng sản phẩm. 
                            Bạn có thể đến cửa hàng để thử trực tiếp hoặc gọi hotline để được tư vấn.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Hiển thị thông báo thành công
    alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    
    // Reset form
    this.reset();
});
</script>
@endsection
