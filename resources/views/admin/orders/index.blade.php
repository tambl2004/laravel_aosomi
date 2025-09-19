@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng - Admin')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<!-- Thống kê -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $stats['total'] }}</h4>
                <small>Tổng đơn hàng</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $stats['pending'] }}</h4>
                <small>Chờ xác nhận</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $stats['confirmed'] }}</h4>
                <small>Đã xác nhận</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $stats['processing'] }}</h4>
                <small>Đang xử lý</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $stats['delivered'] }}</h4>
                <small>Đã giao</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h4 class="mb-1">{{ $stats['cancelled'] }}</h4>
                <small>Đã hủy</small>
            </div>
        </div>
    </div>
</div>

<!-- Bộ lọc -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>Bộ lọc và tìm kiếm
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="search" class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Mã đơn hàng, tên khách hàng...">
                    </div>
                </div>
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Thanh toán</label>
                        <select class="form-select" id="payment_method" name="payment_method">
                            <option value="">Tất cả</option>
                            <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                            <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                            <option value="momo" {{ request('payment_method') == 'momo' ? 'selected' : '' }}>MoMo</option>
                            <option value="zalopay" {{ request('payment_method') == 'zalopay' ? 'selected' : '' }}>ZaloPay</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
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
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Danh sách đơn hàng
            </h5>
            <div class="btn-group">
                <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i>Xuất file
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="exportOrders('excel')">
                        <i class="fas fa-file-excel me-2 text-success"></i>Excel (.xlsx)
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportOrders('pdf')">
                        <i class="fas fa-file-pdf me-2 text-danger"></i>PDF (.pdf)
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportOrders('csv')">
                        <i class="fas fa-file-csv me-2 text-info"></i>CSV (.csv)
                    </a></li>
                </ul>
                <button class="btn btn-outline-primary" onclick="refreshOrders()">
                    <i class="fas fa-sync-alt me-1"></i>Làm mới
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-bold">{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </div>
                            </td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>
                                <div class="fw-bold text-primary">{{ number_format($order->total_amount) }}đ</div>
                                @if($order->shipping_fee > 0)
                                    <small class="text-muted">(Phí ship: {{ number_format($order->shipping_fee) }}đ)</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $order->payment_method_name }}</span>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-outline-primary btn-sm" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->canBeUpdated())
                                        <button class="btn btn-outline-success btn-sm" 
                                                onclick="updateStatus({{ $order->id }})" title="Cập nhật trạng thái">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                    @if($order->status !== 'delivered')
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="deleteOrder({{ $order->id }})" title="Xóa đơn hàng">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Không có đơn hàng nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
        <div class="card-footer">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Modal cập nhật trạng thái -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái mới</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="shipped">Đang giao hàng</option>
                            <option value="delivered">Đã giao hàng</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Ghi chú admin</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(orderId) {
    const form = document.getElementById('statusForm');
    form.action = `/admin/orders/${orderId}/status`;
    
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

function deleteOrder(orderId) {
    if (confirm('Bạn có chắc muốn xóa đơn hàng này?')) {
        fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
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
            alert('Có lỗi xảy ra khi xóa đơn hàng');
        });
    }
}

function exportOrders(format) {
    // Tạo URL với các tham số hiện tại
    const currentParams = new URLSearchParams(window.location.search);
    currentParams.set('export', format);
    
    // Hiển thị loading
    const btn = event.target.closest('.dropdown-item');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xuất...';
    btn.style.pointerEvents = 'none';
    
    // Tạo link tải xuống
    const link = document.createElement('a');
    link.href = `{{ route('admin.orders.export') }}?${currentParams.toString()}`;
    link.download = `orders_${new Date().toISOString().split('T')[0]}.${format}`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Khôi phục button sau 2 giây
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.pointerEvents = 'auto';
    }, 2000);
}

function refreshOrders() {
    // Hiển thị loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang tải...';
    btn.disabled = true;
    
    // Reload trang
    window.location.reload();
}

// Tự động refresh mỗi 30 giây
setInterval(() => {
    // Chỉ refresh nếu không có modal nào đang mở
    if (!document.querySelector('.modal.show')) {
        const refreshBtn = document.querySelector('button[onclick="refreshOrders()"]');
        if (refreshBtn && !refreshBtn.disabled) {
            refreshBtn.click();
        }
    }
}, 30000);
</script>
@endsection
