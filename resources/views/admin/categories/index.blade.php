@extends('layouts.admin')

@section('title', 'Quản lý danh mục - Admin')
@section('page-title', 'Quản lý danh mục')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-tags me-2"></i>Danh sách danh mục
            </h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Thêm danh mục mới
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Hình ảnh</th>
                            <th>Trạng thái</th>
                            <th>Thứ tự</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->description)
                                        <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <code>{{ $category->slug }}</code>
                                </td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">Chưa có hình</span>
                                    @endif
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Tạm dừng</span>
                                    @endif
                                </td>
                                <td>{{ $category->sort_order }}</td>
                                <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                              class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có danh mục nào</h5>
                <p class="text-muted">Hãy thêm danh mục đầu tiên để bắt đầu quản lý.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Thêm danh mục đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
