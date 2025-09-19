# Dự án Laravel 12 - Aosomi

## Mô tả
Dự án Laravel 12 được khởi tạo thành công với cấu hình cơ bản.

## Thông tin dự án
- **Framework**: Laravel 12.30.1
- **PHP Version**: 8.3.1
- **Database**: SQLite (mặc định)
- **Server**: Chạy trên http://localhost:8000

## Cấu trúc dự án
```
laravel_aosomi/
├── app/                    # Thư mục ứng dụng chính
│   ├── Http/Controllers/   # Controllers
│   ├── Models/            # Models
│   └── Providers/         # Service Providers
├── config/                 # File cấu hình
├── database/              # Database migrations, seeders
├── public/                # Thư mục public (web root)
├── resources/             # Views, CSS, JS
├── routes/                # Định nghĩa routes
├── storage/               # File storage, logs
└── tests/                 # Unit tests, Feature tests
```

## Cách chạy dự án

### 1. Khởi động server development
```bash
php artisan serve
```
Server sẽ chạy tại: http://localhost:8000

### 2. Chạy migrations (nếu cần)
```bash
php artisan migrate
```

### 3. Tạo storage link (nếu cần)
```bash
php artisan storage:link
```

## Các lệnh hữu ích

### Tạo Controller
```bash
php artisan make:controller TênController
```

### Tạo Model
```bash
php artisan make:model TênModel
```

### Tạo Migration
```bash
php artisan make:migration tên_migration
```

### Tạo Seeder
```bash
php artisan make:seeder TênSeeder
```

### Chạy tests
```bash
php artisan test
```

## Cấu hình môi trường
File `.env` đã được cấu hình sẵn với:
- Database: SQLite
- Debug mode: Bật
- App URL: http://localhost
- App Key: Đã được generate tự động

## Ghi chú
- Dự án sử dụng SQLite database mặc định
- Tất cả dependencies đã được cài đặt qua Composer
- Server development đã được khởi động và sẵn sàng sử dụng

## Liên hệ
Dự án được tạo bởi AI Assistant với Laravel 12.