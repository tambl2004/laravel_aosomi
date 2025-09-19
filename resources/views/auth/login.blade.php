@extends('layouts.auth')

@section('title', 'Đăng nhập - Laravel Aosomi')
@section('header-title', 'Đăng nhập')
@section('header-subtitle', 'Chào mừng bạn quay trở lại')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    
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
               autofocus
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
               autocomplete="current-password"
               placeholder="Nhập mật khẩu">
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Nhớ đăng nhập -->
    <div class="mb-4 form-check">
        <input type="checkbox" 
               class="form-check-input" 
               id="remember" 
               name="remember" 
               {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
            Ghi nhớ đăng nhập
        </label>
    </div>
    
    <!-- Nút đăng nhập -->
    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
        </button>
    </div>
    
    <!-- Link đăng ký -->
    <div class="text-center mb-3">
        <p class="text-muted">
            Chưa có tài khoản? 
            <a href="{{ route('register') }}">Đăng ký ngay</a>
        </p>
    </div>
    
    <!-- Link quên mật khẩu -->
    <div class="text-center">
        <p class="text-muted">
            <a href="#" class="text-decoration-none">
                <i class="fas fa-key me-1"></i>Quên mật khẩu?
            </a>
        </p>
    </div>
</form>
@endsection
