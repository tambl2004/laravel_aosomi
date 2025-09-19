@extends('layouts.home')

@section('title', 'Đơn hàng của tôi - Aosomi')
@section('page-title', 'Đơn hàng của tôi')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">Đơn hàng của tôi</h1>
        <p class="lead">Theo dõi và quản lý đơn hàng của bạn</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Bộ lọc -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Bộ lọc đơn hàng
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('orders.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Mã đơn hàng...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tất cả</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="date_from" class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="date_to" class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách đơn hàng -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Danh sách đơn hàng
            </h5>
        </div>
        <div class="card-body p-0">
            @forelse($orders as $order)
                <div class="border-bottom p-4">
                    <!-- Header đơn hàng -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-receipt fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $order->order_number }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <div class="fw-bold text-primary fs-5">{{ number_format($order->total_amount) }}đ</div>
                                <small class="text-muted">
                                    <i class="fas fa-credit-card me-1"></i>{{ $order->payment_method_name }}
                                </small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'processing' => 'secondary',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                    $statusIcons = [
                                        'pending' => 'clock',
                                        'confirmed' => 'check-circle',
                                        'processing' => 'cog',
                                        'shipped' => 'truck',
                                        'delivered' => 'check-double',
                                        'cancelled' => 'times-circle',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] }} fs-6">
                                    <i class="fas fa-{{ $statusIcons[$order->status] }} me-1"></i>{{ $order->status_name }}
                                </span>
                                <div class="mt-1">
                                    <small class="text-muted">{{ $order->orderItems->count() }} sản phẩm</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-grid gap-2">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Xem chi tiết
                                </a>
                                @if($order->status === 'delivered')
                                    <button class="btn btn-outline-success btn-sm" onclick="reorder({{ $order->id }})">
                                        <i class="fas fa-redo me-1"></i>Đặt lại
                                    </button>
                                @elseif($order->status === 'pending')
                                    <button class="btn btn-outline-danger btn-sm" onclick="cancelOrder({{ $order->id }})">
                                        <i class="fas fa-times me-1"></i>Hủy đơn
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Timeline trạng thái -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="timeline-mini">
                                <div class="timeline-item {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'completed' : ($order->status === 'pending' ? 'active' : '') }}">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Đơn hàng được tạo</div>
                                        <div class="timeline-text">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                                
                                @if(in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                                    <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($order->status === 'confirmed' ? 'active' : '') }}">
                                        <div class="timeline-marker bg-info"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Đã xác nhận</div>
                                            <div class="timeline-text">Đơn hàng đã được xác nhận</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                    <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status === 'processing' ? 'active' : '') }}">
                                        <div class="timeline-marker bg-secondary"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Đang xử lý</div>
                                            <div class="timeline-text">Đơn hàng đang được chuẩn bị</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(in_array($order->status, ['shipped', 'delivered']))
                                    <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : 'active' }}">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Đang giao hàng</div>
                                            <div class="timeline-text">Đơn hàng đang được vận chuyển</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($order->status === 'delivered')
                                    <div class="timeline-item completed">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Đã giao hàng</div>
                                            <div class="timeline-text">Đơn hàng đã được giao thành công</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($order->status === 'cancelled')
                                    <div class="timeline-item completed">
                                        <div class="timeline-marker bg-danger"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Đã hủy</div>
                                            <div class="timeline-text">Đơn hàng đã bị hủy</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Danh sách sản phẩm -->
                        <div class="col-md-4">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-box me-1"></i>Sản phẩm
                            </h6>
                            @foreach($order->orderItems->take(2) as $item)
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $item->product_image }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="img-thumbnail me-2" 
                                         style="width: 35px; height: 35px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small">{{ Str::limit($item->product_name, 20) }}</div>
                                        <small class="text-muted">SL: {{ $item->quantity }} | {{ number_format($item->total_price) }}đ</small>
                                    </div>
                                </div>
                            @endforeach
                            @if($order->orderItems->count() > 2)
                                <div class="text-center">
                                    <small class="text-muted">+{{ $order->orderItems->count() - 2 }} sản phẩm khác</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có đơn hàng nào</h5>
                    <p class="text-muted">Hãy bắt đầu mua sắm để tạo đơn hàng đầu tiên!</p>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                    </a>
                </div>
            @endforelse
        </div>
        
        @if($orders->hasPages())
            <div class="card-footer">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function reorder(orderId) {
    if (confirm('Bạn có muốn đặt lại đơn hàng này không?')) {
        // TODO: Implement reorder functionality
        alert('Chức năng đặt lại sẽ được phát triển trong tương lai!');
    }
}

function cancelOrder(orderId) {
    if (confirm('Bạn có chắc muốn hủy đơn hàng này? Đơn hàng đã hủy không thể khôi phục.')) {
        fetch(`/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi hủy đơn hàng');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi hủy đơn hàng');
        });
    }
}
</script>

<style>
.timeline-mini {
    position: relative;
    padding-left: 20px;
}

.timeline-mini .timeline-item {
    position: relative;
    margin-bottom: 15px;
}

.timeline-mini .timeline-marker {
    position: absolute;
    left: -20px;
    top: 3px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.timeline-mini .timeline-item.completed .timeline-marker {
    background-color: #28a745 !important;
}

.timeline-mini .timeline-item.active .timeline-marker {
    background-color: #007bff !important;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.timeline-mini .timeline-content {
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 4px;
    border-left: 2px solid #dee2e6;
}

.timeline-mini .timeline-item.completed .timeline-content {
    background: #d4edda;
    border-left-color: #28a745;
}

.timeline-mini .timeline-item.active .timeline-content {
    background: #cce7ff;
    border-left-color: #007bff;
}

.timeline-mini .timeline-title {
    margin: 0 0 2px 0;
    font-size: 12px;
    font-weight: bold;
}

.timeline-mini .timeline-text {
    margin: 0;
    font-size: 11px;
    color: #6c757d;
}
</style>
@endsection
