# Dự án Laravel 12 - Aosomi

## Mô tả
Dự án Laravel 12 với hệ thống đăng ký, đăng nhập và phân quyền hoàn chỉnh. Hệ thống hỗ trợ xác thực email và phân quyền admin/customer.

## Thông tin dự án
- **Framework**: Laravel 12.30.1
- **PHP Version**: 8.3.1
- **Database**: MySQL
- **Server**: Chạy trên http://localhost:8000

## Tính năng chính

### 🔐 Hệ thống xác thực
- ✅ Đăng ký tài khoản với xác thực email
- ✅ Đăng nhập với phân quyền
- ✅ Đăng xuất an toàn
- ✅ Xác thực email bắt buộc

### 👥 Phân quyền người dùng
- ✅ **Admin**: Quyền quản trị hệ thống
- ✅ **Customer**: Quyền người dùng thường
- ✅ Middleware kiểm tra phân quyền
- ✅ Chuyển hướng tự động theo role

### 🎨 Giao diện
- ✅ Giao diện đăng ký/đăng nhập đẹp mắt
- ✅ Dashboard riêng cho Admin và Customer
- ✅ Responsive design
- ✅ Bootstrap 5 + Font Awesome

## Cấu trúc dự án
```
laravel_aosomi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Xử lý đăng ký/đăng nhập
│   │   │   ├── admin/
│   │   │   │   └── DashboardController.php # Dashboard admin
│   │   │   └── customer/
│   │   │       └── DashboardController.php # Dashboard customer
│   │   └── Middleware/
│   │       └── CheckRole.php              # Middleware phân quyền
│   └── Models/
│       └── User.php                       # Model User với phân quyền
├── database/
│   ├── migrations/                        # Migrations database
│   └── seeders/
│       └── AdminUserSeeder.php           # Tạo user mẫu
├── resources/
│   └── views/
│       ├── auth/                         # Views đăng ký/đăng nhập
│       ├── admin/                        # Views admin
│       ├── customer/                     # Views customer
│       └── layouts/                      # Layout chung
└── routes/
    └── web.php                           # Định nghĩa routes
```

## Cách sử dụng

### 1. Khởi động server development
```bash
php artisan serve
```
Server sẽ chạy tại: http://localhost:8000

### 2. Trang chủ
Khi truy cập http://localhost:8000, bạn sẽ thấy trang chủ customer với:
- Giới thiệu về hệ thống
- Link đăng ký và đăng nhập
- Tài khoản demo để test

### 3. Tài khoản mẫu
Hệ thống đã tạo sẵn 2 tài khoản mẫu:

**Admin:**
- Email: `admin@aosomi.com`
- Password: `12345678`
- Truy cập: http://localhost:8000/admin/dashboard

**Customer:**
- Email: `customer@aosomi.com`
- Password: `12345678`
- Truy cập: http://localhost:8000/customer/dashboard

### 4. Đăng ký tài khoản mới
1. Truy cập http://localhost:8000/register
2. Điền thông tin (tài khoản mới mặc định là user)
3. Kiểm tra email để xác thực
4. Đăng nhập và truy cập dashboard customer

### 5. Đăng nhập
1. Truy cập http://localhost:8000/login
2. Nhập email và mật khẩu
3. Hệ thống sẽ tự động chuyển hướng theo role

## Cấu hình

### Database
File `.env` đã được cấu hình với MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_aosomi
DB_USERNAME=root
DB_PASSWORD=root
```

### Mail (Gmail SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=zzztamdzzz@gmail.com
MAIL_PASSWORD=clicuvvdabmpxswu
MAIL_ENCRYPTION=tls
```

## Routes chính

### Xác thực
- `GET /register` - Form đăng ký
- `POST /register` - Xử lý đăng ký
- `GET /login` - Form đăng nhập
- `POST /login` - Xử lý đăng nhập
- `POST /logout` - Đăng xuất

### Admin
- `GET /admin/dashboard` - Dashboard admin (yêu cầu role: admin)

### Customer
- `GET /customer/dashboard` - Dashboard customer (yêu cầu role: user)

### Xác thực email
- `GET /email/verify/{id}/{hash}` - Xác thực email
- `POST /email/resend` - Gửi lại email xác thực

## Middleware

### CheckRole
Kiểm tra quyền truy cập theo role:
```php
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Routes chỉ admin mới truy cập được
});
```

## Model User

### Các phương thức helper
```php
$user->isAdmin();     // Kiểm tra có phải admin không
$user->isUser();      // Kiểm tra có phải user thường không
$user->hasRole('admin'); // Kiểm tra role cụ thể
```

## Bảo mật

- ✅ Mật khẩu được hash bằng bcrypt
- ✅ CSRF protection
- ✅ Email verification bắt buộc
- ✅ Session security
- ✅ Role-based access control

## Phát triển thêm

### Thêm tính năng mới cho Admin
1. Tạo controller trong `app/Http/Controllers/Admin/`
2. Thêm routes với middleware `role:admin`
3. Tạo views trong `resources/views/admin/`

### Thêm tính năng mới cho Customer
1. Tạo controller trong `app/Http/Controllers/Customer/`
2. Thêm routes với middleware `role:user`
3. Tạo views trong `resources/views/customer/`

## Lưu ý
- Hệ thống yêu cầu xác thực email trước khi đăng nhập
- Admin và Customer có dashboard riêng biệt
- Middleware tự động chuyển hướng theo role
- Giao diện responsive và thân thiện với người dùng

## Liên hệ
Dự án được tạo bởi AI Assistant với Laravel 12 và hệ thống phân quyền hoàn chỉnh.