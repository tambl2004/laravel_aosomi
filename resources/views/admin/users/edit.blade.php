@extends('layouts.admin')

@section('title', 'Chỉnh sửa người dùng - Admin')
@section('page-title', 'Chỉnh sửa người dùng')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>Chỉnh sửa người dùng: {{ $user->name }}
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên người dùng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Để trống nếu không muốn thay đổi mật khẩu</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                            <option value="">Chọn vai trò</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Thông tin:</strong> 
                        @if($user->email_verified_at)
                            Email đã được xác thực vào {{ $user->email_verified_at->format('d/m/Y H:i') }}
                        @else
                            Email chưa được xác thực
                        @endif
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Cập nhật người dùng
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
