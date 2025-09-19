@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng - Admin')
@section('page-title', 'Chi tiết đơn hàng')

@section('content')
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
                        <a href="{{ route('admin.orders.print', $order) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-print me-1"></i>In đơn hàng
                        </a>
                        @if($order->canBeUpdated())
                            <button class="btn btn-outline-success btn-sm" onclick="editOrder()">
                                <i class="fas fa-edit me-1"></i>Chỉnh sửa
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
                @if($order->notes || $order->admin_notes)
                    <div class="row mt-4">
                        @if($order->notes)
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-sticky-note me-2"></i>Ghi chú khách hàng
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $order->notes }}
                                </div>
                            </div>
                        @endif
                        @if($order->admin_notes)
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user-shield me-2"></i>Ghi chú admin
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $order->admin_notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cập nhật trạng thái -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Cập nhật trạng thái
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái mới</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Ghi chú admin</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                  placeholder="Ghi chú về việc cập nhật trạng thái...">{{ old('admin_notes') }}</textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Cập nhật trạng thái
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Thông tin người dùng -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>Thông tin tài khoản
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Tên đăng nhập:</strong> {{ $order->user->name }}
                </div>
                <div class="mb-2">
                    <strong>Email:</strong> {{ $order->user->email }}
                </div>
                <div class="mb-2">
                    <strong>Ngày đăng ký:</strong> {{ $order->user->created_at->format('d/m/Y') }}
                </div>
                <div class="mb-2">
                    <strong>Vai trò:</strong> 
                    <span class="badge bg-{{ $order->user->isAdmin() ? 'danger' : 'primary' }}">
                        {{ $order->user->isAdmin() ? 'Admin' : 'Khách hàng' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Lịch sử cập nhật -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Lịch sử cập nhật
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Đơn hàng được tạo</h6>
                            <p class="timeline-text">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if($order->updated_at != $order->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Cập nhật lần cuối</h6>
                                <p class="timeline-text">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal chỉnh sửa đơn hàng -->
<div class="modal fade" id="editOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                       value="{{ $order->customer_name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                       value="{{ $order->customer_email }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                               value="{{ $order->customer_phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_address" class="form-label">Địa chỉ</label>
                        <textarea class="form-control" id="customer_address" name="customer_address" rows="2" required>{{ $order->customer_address }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_city" class="form-label">Tỉnh/Thành phố</label>
                                <input type="text" class="form-control" id="customer_city" name="customer_city" 
                                       value="{{ $order->customer_city }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_district" class="form-label">Quận/Huyện</label>
                                <input type="text" class="form-control" id="customer_district" name="customer_district" 
                                       value="{{ $order->customer_district }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_ward" class="form-label">Phường/Xã</label>
                                <input type="text" class="form-control" id="customer_ward" name="customer_ward" 
                                       value="{{ $order->customer_ward }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="shipping_fee" class="form-label">Phí vận chuyển</label>
                        <input type="number" class="form-control" id="shipping_fee" name="shipping_fee" 
                               value="{{ $order->shipping_fee }}" min="0" step="1000">
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Ghi chú admin</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ $order->admin_notes }}</textarea>
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
function editOrder() {
    const modal = new bootstrap.Modal(document.getElementById('editOrderModal'));
    modal.show();
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
