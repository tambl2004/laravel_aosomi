@extends('layouts.admin')

@section('title', 'Báo cáo thống kê - Admin')
@section('page-title', 'Báo cáo thống kê')

@section('content')
<!-- Bộ lọc thời gian -->
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2"></i>Bộ lọc thời gian
            </h5>
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>Ngày hiện tại: {{ now()->format('d/m/Y H:i') }}
            </small>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="period" class="form-label">Khoảng thời gian</label>
                        <select class="form-select" id="period" name="period" onchange="updateDateRange()">
                            <option value="7" {{ $period == '7' ? 'selected' : '' }}>7 ngày qua</option>
                            <option value="30" {{ $period == '30' ? 'selected' : '' }}>30 ngày qua</option>
                            <option value="90" {{ $period == '90' ? 'selected' : '' }}>90 ngày qua</option>
                            <option value="365" {{ $period == '365' ? 'selected' : '' }}>1 năm qua</option>
                            <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $startDate }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $endDate }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Xem báo cáo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $stats['total_orders'] }}</h4>
                <small>Tổng đơn hàng</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                <h4 class="mb-1">{{ number_format($stats['total_revenue']) }}đ</h4>
                <small>Doanh thu</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $stats['total_customers'] }}</h4>
                <small>Khách hàng mới</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-box fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $stats['total_products'] }}</h4>
                <small>Sản phẩm</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $stats['pending_orders'] }}</h4>
                <small>Chờ xử lý</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $stats['delivered_orders'] }}</h4>
                <small>Đã giao</small>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ chính -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Biểu đồ đơn hàng và doanh thu
                </h5>
            </div>
            <div class="card-body">
                <canvas id="ordersChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Phương thức thanh toán
                </h5>
            </div>
            <div class="card-body">
                <canvas id="paymentChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ sản phẩm và danh mục -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Sản phẩm bán chạy
                </h5>
            </div>
            <div class="card-body">
                <canvas id="productsChart" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Doanh thu theo danh mục
                </h5>
            </div>
            <div class="card-body">
                <canvas id="categoriesChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Bảng chi tiết -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Top sản phẩm bán chạy
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->total_quantity }}</td>
                                    <td>{{ number_format($product->total_revenue) }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Thống kê khách hàng
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="border-end">
                            <h4 class="text-primary">{{ $customerStats['new_customers'] }}</h4>
                            <small class="text-muted">Khách hàng mới</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-end">
                            <h4 class="text-success">{{ $customerStats['active_customers'] }}</h4>
                            <small class="text-muted">Khách hàng hoạt động</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="text-info">{{ $customerStats['total_customers'] }}</h4>
                        <small class="text-muted">Tổng khách hàng</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Nút xuất báo cáo -->
<div class="text-center mt-4">
    <button class="btn btn-success" onclick="exportReport()">
        <i class="fas fa-download me-2"></i>Xuất báo cáo Excel
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Biểu đồ đơn hàng và doanh thu
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
    type: 'line',
    data: {
        labels: @json($orderStats['labels']),
        datasets: [{
            label: 'Số đơn hàng',
            data: @json($orderStats['orders']),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            yAxisID: 'y',
        }, {
            label: 'Doanh thu (đ)',
            data: @json($orderStats['revenue']),
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            yAxisID: 'y1',
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Ngày'
                }
            },
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Số đơn hàng'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Doanh thu (đ)'
                },
                grid: {
                    drawOnChartArea: false,
                },
            }
        }
    }
});

// Biểu đồ phương thức thanh toán
const paymentCtx = document.getElementById('paymentChart').getContext('2d');
new Chart(paymentCtx, {
    type: 'doughnut',
    data: {
        labels: @json($paymentStats->pluck('method_name')),
        datasets: [{
            data: @json($paymentStats->pluck('count')),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Biểu đồ sản phẩm bán chạy
const productsCtx = document.getElementById('productsChart').getContext('2d');
new Chart(productsCtx, {
    type: 'bar',
    data: {
        labels: @json($topProducts->take(5)->pluck('name')),
        datasets: [{
            label: 'Số lượng bán',
            data: @json($topProducts->take(5)->pluck('total_quantity')),
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Biểu đồ doanh thu theo danh mục
const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
new Chart(categoriesCtx, {
    type: 'pie',
    data: {
        labels: @json($categoryStats->pluck('name')),
        datasets: [{
            data: @json($categoryStats->pluck('total_revenue')),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Cập nhật khoảng thời gian
function updateDateRange() {
    const period = document.getElementById('period').value;
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (period !== 'custom') {
        const days = parseInt(period);
        // Sử dụng timezone Việt Nam
        const today = new Date();
        const vietnamTime = new Date(today.toLocaleString("en-US", {timeZone: "Asia/Ho_Chi_Minh"}));
        const pastDate = new Date(vietnamTime.getTime() - (days * 24 * 60 * 60 * 1000));
        
        startDate.value = pastDate.toISOString().split('T')[0];
        endDate.value = vietnamTime.toISOString().split('T')[0];
    }
}

// Xuất báo cáo
function exportReport() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    window.open(`{{ route('admin.reports.export') }}?start_date=${startDate}&end_date=${endDate}`, '_blank');
}

// Tự động cập nhật ngày khi trang load
document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật ngày hiện tại nếu không có giá trị
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (!startDate.value || !endDate.value) {
        updateDateRange();
    }
});
</script>
@endsection
