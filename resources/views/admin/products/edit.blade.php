@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm - Admin')
@section('page-title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Quản lý sản phẩm</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2 text-primary"></i>Chỉnh sửa sản phẩm: {{ $product->name }}
                        </h5>
                        <div class="d-flex gap-2">
                            @if($product->is_featured)
                                <span class="badge bg-warning">Nổi bật</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.products.update', $product) }}" id="product-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Thông tin cơ bản -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Thông tin cơ bản
                                </h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả ngắn</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Mô tả ngắn về sản phẩm...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung chi tiết</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="5" 
                                      placeholder="Mô tả chi tiết về sản phẩm...">{{ old('content', $product->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Giá và tồn kho -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-dollar-sign me-2"></i>Giá và tồn kho
                                </h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                                        <span class="input-group-text">đ</span>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hình ảnh -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-image me-2"></i>Hình ảnh
                                </h6>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                            <input type="url" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" value="{{ old('image', $product->image) }}" 
                                   placeholder="https://example.com/image.jpg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nhập link hình ảnh từ internet</div>
                            
                            <!-- Hiển thị hình ảnh hiện tại -->
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                        
                        <!-- Trạng thái -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-cog me-2"></i>Trạng thái
                                </h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star me-1 text-warning"></i>Sản phẩm nổi bật
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thông tin bổ sung -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-info me-2"></i>Thông tin bổ sung
                                </h6>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày tạo</label>
                                    <input type="text" class="form-control" value="{{ $product->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cập nhật lần cuối</label>
                                    <input type="text" class="form-control" value="{{ $product->updated_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nút hành động -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>Cập nhật sản phẩm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Format số tiền
document.getElementById('price').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endsection