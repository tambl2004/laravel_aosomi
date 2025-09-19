@extends('layouts.home')

@section('title', 'Chi tiết đơn hàng - Aosomi')
@section('page-title', 'Chi tiết đơn hàng')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Chi tiết đơn hàng</h1>
        <p class="lead">Thông tin chi tiết về đơn hàng của bạn</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Đơn hàng #{{ $order->order_number }}
                        </h5>
                        <div class="btn-group">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại
                            </a>
                            @if($order->status === 'delivered')
                                <button class="btn btn-outline-success btn-sm" onclick="reorder({{ $order->id }})">
                                    <i class="fas fa-redo me-1"></i>Đặt lại
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Thông tin khách hàng -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>Thông tin khách hàng
                            </h6>
                            <div class="mb-2">
                                <strong>Họ tên:</strong> {{ $order->customer_name }}
                            </div>
                            <div class="mb-2">
                                <strong>Email:</strong> {{ $order->customer_email }}
                            </div>
                            <div class="mb-2">
                                <strong>Số điện thoại:</strong> {{ $order->customer_phone }}
                            </div>
                            <div class="mb-2">
                                <strong>Địa chỉ:</strong> {{ $order->full_address }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-shopping-cart me-2"></i>Thông tin đơn hàng
                            </h6>
                            <div class="mb-2">
                                <strong>Mã đơn hàng:</strong> {{ $order->order_number }}
                            </div>
                            <div class="mb-2">
                                <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="mb-2">
                                <strong>Phương thức thanh toán:</strong> {{ $order->payment_method_name }}
                            </div>
                            <div class="mb-2">
                                <strong>Trạng thái:</strong> 
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'processing' => 'secondary',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] }}">
                                    {{ $order->status_name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách sản phẩm -->
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-box me-2"></i>Danh sách sản phẩm
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product_image }}" 
                                                     alt="{{ $item->product_name }}" 
                                                     class="img-thumbnail me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold">{{ $item->product_name }}</div>
                                                    @if($item->product)
                                                        <small class="text-muted">SKU: {{ $item->product->id }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->product_price) }}đ</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-bold">{{ number_format($item->total_price) }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                                    <td><strong>{{ number_format($order->subtotal) }}đ</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                    <td><strong>{{ number_format($order->shipping_fee) }}đ</strong></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td><strong class="text-primary">{{ number_format($order->total_amount) }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Ghi chú -->
                    @if($order->notes)
                        <div class="mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-sticky-note me-2"></i>Ghi chú của bạn
                            </h6>
                            <div class="bg-light p-3 rounded">
                                {{ $order->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Thông tin bổ sung -->
        <div class="col-lg-4">
            <!-- Trạng thái đơn hàng -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-truck me-2"></i>Trạng thái giao hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $order->status !== 'pending' ? 'completed' : '' }}">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Đơn hàng được tạo</h6>
                                <p class="timeline-text">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if(in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                            <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Đã xác nhận</h6>
                                    <p class="timeline-text">Đơn hàng đã được xác nhận</p>
                                </div>
                            </div>
                        @endif
                        
                        @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                            <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Đang xử lý</h6>
                                    <p class="timeline-text">Đơn hàng đang được chuẩn bị</p>
                                </div>
                            </div>
                        @endif
                        
                        @if(in_array($order->status, ['shipped', 'delivered']))
                            <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : '' }}">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Đang giao hàng</h6>
                                    <p class="timeline-text">Đơn hàng đang được vận chuyển</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->status === 'delivered')
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Đã giao hàng</h6>
                                    <p class="timeline-text">Đơn hàng đã được giao thành công</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->status === 'cancelled')
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Đã hủy</h6>
                                    <p class="timeline-text">Đơn hàng đã bị hủy</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Thông tin hỗ trợ -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-headset me-2"></i>Hỗ trợ khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text small">
                        Cần hỗ trợ về đơn hàng này? Liên hệ với chúng tôi:
                    </p>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2 text-primary"></i>
                        <strong>Hotline:</strong> 1900 1234
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <strong>Email:</strong> support@aosomi.com
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        <strong>Giờ làm việc:</strong> 8:00 - 22:00 (T2-CN)
                    </div>
                </div>
            </div>

            <!-- Thông tin thanh toán -->
            @if($order->payment_method !== 'cod')
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>Thông tin thanh toán
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($order->payment_method === 'bank_transfer')
                            <div class="alert alert-info">
                                <h6>Thông tin chuyển khoản:</h6>
                                <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                <p class="mb-1"><strong>STK:</strong> 1234567890</p>
                                <p class="mb-1"><strong>Chủ TK:</strong> Công ty TNHH Aosomi</p>
                                <p class="mb-0"><strong>Nội dung:</strong> {{ $order->order_number }}</p>
                            </div>
                        @elseif($order->payment_method === 'momo')
                            <div class="alert alert-info">
                                <h6>Thông tin MoMo:</h6>
                                <p class="mb-1"><strong>Số điện thoại:</strong> 0901234567</p>
                                <p class="mb-1"><strong>Tên:</strong> Công ty TNHH Aosomi</p>
                                <p class="mb-0"><strong>Nội dung:</strong> {{ $order->order_number }}</p>
                            </div>
                        @elseif($order->payment_method === 'zalopay')
                            <div class="alert alert-info">
                                <h6>Thông tin ZaloPay:</h6>
                                <p class="mb-0">Quét mã QR ZaloPay để thanh toán hoặc chuyển khoản qua ứng dụng ZaloPay</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function reorder(orderId) {
    if (confirm('Bạn có muốn đặt lại đơn hàng này không?')) {
        // TODO: Implement reorder functionality
        alert('Chức năng đặt lại sẽ được phát triển trong tương lai!');
    }
}
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745 !important;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.timeline-item.completed .timeline-content {
    background: #d4edda;
    border-left-color: #28a745;
}

.timeline-title {
    margin: 0 0 5px 0;
    font-size: 14px;
    font-weight: bold;
}

.timeline-text {
    margin: 0;
    font-size: 12px;
    color: #6c757d;
}
</style>
@endsection
