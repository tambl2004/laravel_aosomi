@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm - Admin')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <!-- Header với nút thêm mới -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-box me-2 text-primary"></i>Quản lý sản phẩm
                    </h2>
                    <p class="text-muted mb-0">Quản lý tất cả sản phẩm trong hệ thống</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                </a>
            </div>
        </div>
    </div>

    <!-- Bộ lọc và tìm kiếm -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Tìm kiếm sản phẩm</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nhập tên sản phẩm...">
                        </div>
                        <div class="col-md-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Sản phẩm nổi bật</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort_by" class="form-label">Sắp xếp</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên sản phẩm</option>
                                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Giá</option>
                                <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Tồn kho</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Tìm kiếm
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Danh sách sản phẩm
                            <span class="badge bg-primary ms-2">{{ $products->total() }} sản phẩm</span>
                        </h5>
                        <div class="d-flex gap-2">
                            <span class="text-muted">Hiển thị {{ $products->count() }} / {{ $products->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Tồn kho</th>
                                        <th>Trạng thái</th>
                                        <th>Nổi bật</th>
                                        <th width="200">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                @if($product->first_image)
                                                    <img src="{{ $product->first_image }}" alt="{{ $product->name }}" 
                                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                                    @if($product->description)
                                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $product->category->name }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong class="text-success">{{ number_format($product->price) }}đ</strong>
                                                    @if($product->is_on_sale)
                                                        <br><small class="text-danger">{{ number_format($product->sale_price) }}đ</small>
                                                        <br><small class="badge bg-danger">{{ $product->discount_percentage }}% OFF</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->in_stock ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                        <i class="fas {{ $product->is_active ? 'fa-check' : 'fa-times' }} me-1"></i>
                                                        {{ $product->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.products.toggle-featured', $product) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $product->is_featured ? 'btn-warning' : 'btn-outline-warning' }}">
                                                        <i class="fas fa-star me-1"></i>
                                                        {{ $product->is_featured ? 'Nổi bật' : 'Bình thường' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Form xóa ẩn -->
                                                <form id="delete-form-{{ $product->id }}" method="POST" 
                                                      action="{{ route('admin.products.destroy', $product) }}" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Phân trang -->
                        <div class="card-footer">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có sản phẩm nào</h5>
                            <p class="text-muted">Hãy thêm sản phẩm đầu tiên của bạn</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="product-name"></strong>?</p>
                <p class="text-danger">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa sản phẩm</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(productId, productName) {
    document.getElementById('product-name').textContent = productName;
    document.getElementById('confirm-delete').onclick = function() {
        document.getElementById('delete-form-' + productId).submit();
    };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
