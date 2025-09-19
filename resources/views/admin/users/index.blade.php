@extends('layouts.admin')

@section('title', 'Quản lý người dùng - Admin')
@section('page-title', 'Quản lý người dùng')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Danh sách người dùng
                </h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Thêm người dùng
                </a>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->isAdmin())
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-crown me-1"></i>Admin
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-user me-1"></i>User
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Đã xác thực
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Chưa xác thực
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                          class="d-inline" 
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có người dùng nào</h5>
                        <p class="text-muted">Hãy thêm người dùng đầu tiên!</p>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Thêm người dùng
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
