@extends('layouts.auth')

@section('title', 'Đăng ký - Laravel Aosomi')
@section('header-title', 'Đăng ký tài khoản')
@section('header-subtitle', 'Tạo tài khoản mới để sử dụng hệ thống')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <!-- Tên -->
    <div class="mb-4">
        <label for="name" class="form-label">
            <i class="fas fa-user me-2"></i>Tên đầy đủ
        </label>
        <input type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               id="name" 
               name="name" 
               value="{{ old('name') }}" 
               required 
               autocomplete="name" 
               autofocus
               placeholder="Nhập tên đầy đủ của bạn">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="form-label">
            <i class="fas fa-envelope me-2"></i>Email
        </label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autocomplete="email"
               placeholder="Nhập địa chỉ email">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Mật khẩu -->
    <div class="mb-4">
        <label for="password" class="form-label">
            <i class="fas fa-lock me-2"></i>Mật khẩu
        </label>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               required 
               autocomplete="new-password"
               placeholder="Nhập mật khẩu (ít nhất 8 ký tự)">
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Xác nhận mật khẩu -->
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">
            <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu
        </label>
        <input type="password" 
               class="form-control" 
               id="password_confirmation" 
               name="password_confirmation" 
               required 
               autocomplete="new-password"
               placeholder="Nhập lại mật khẩu">
    </div>
    
    <!-- Nút đăng ký -->
    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-user-plus me-2"></i>Đăng ký
        </button>
    </div>
    
    <!-- Link đăng nhập -->
    <div class="text-center">
        <p class="text-muted">
            Đã có tài khoản? 
            <a href="{{ route('login') }}">Đăng nhập ngay</a>
        </p>
    </div>
</form>
@endsection
