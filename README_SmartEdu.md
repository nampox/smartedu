# SmartEdu - Dự án Laravel

## Thông tin dự án

- **Framework**: Laravel 12.21.0 (phiên bản mới nhất)
- **PHP Version**: 8.2.29
- **Composer**: 2.8.10
- **Database**: MySQL (smartedu database)

## Yêu cầu hệ thống

- PHP >= 8.2
- Composer >= 2.0
- Node.js & NPM (cho Vite build)

## Cài đặt và chạy

### 1. Cài đặt dependencies
```bash
composer install
npm install
```

### 2. Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Chạy migration
```bash
php artisan migrate
```

### 4. Chạy development server
```bash
# Sử dụng PHP 8.2
php8.2 artisan serve --host=0.0.0.0 --port=8000

# Hoặc sử dụng Laravel Sail (Docker)
./vendor/bin/sail up
```

### 5. Build assets (development)
```bash
npm run dev
```

## Cấu trúc dự án

```
SmartEdu/
├── app/                    # Application logic
├── bootstrap/              # Framework bootstrap
├── config/                 # Configuration files
├── database/               # Database migrations, seeders
├── public/                 # Web server document root
├── resources/              # Views, assets, language files
├── routes/                 # Route definitions
├── storage/                # Logs, cache, uploads
├── tests/                  # Test files
└── vendor/                 # Composer dependencies
```

## Tính năng mới trong Laravel 12

- **Performance improvements**: Tối ưu hóa hiệu suất
- **New Artisan commands**: Các lệnh mới
- **Enhanced security**: Bảo mật được cải thiện
- **Better error handling**: Xử lý lỗi tốt hơn
- **Modern PHP features**: Sử dụng các tính năng PHP 8.2+

## Development Commands

```bash
# Tạo controller
php8.2 artisan make:controller UserController

# Tạo model với migration
php8.2 artisan make:model User -m

# Tạo seeder
php8.2 artisan make:seeder UserSeeder

# Chạy tests
php8.2 artisan test

# Clear cache
php8.2 artisan cache:clear
php8.2 artisan config:clear
php8.2 artisan route:clear
php8.2 artisan view:clear
```

## Log Viewer

Dự án có tích hợp Log Viewer với giao diện Bootstrap 5:

- **URL**: `http://localhost:8000/log`
- **Tính năng chính**: 
  - ✅ Xem log theo từng ngày (dropdown selector)
  - ✅ Phân loại log theo level (ERROR, WARNING, INFO, DEBUG)
  - ✅ Thống kê số lượng log theo từng loại
  - ✅ Tìm kiếm log theo từ khóa
  - ✅ Lọc log theo level
  - ✅ Hiển thị đầy đủ thông tin:
    - Timestamp và channel
    - Message và context
    - Stack trace (nếu có)
    - JSON context (exception details)
  - ✅ Giao diện responsive và thân thiện
  - ✅ Hỗ trợ Bootstrap Icons
  - ✅ Sắp xếp log theo thời gian (mới nhất trước)

### Cách sử dụng Log Viewer

1. **Truy cập**: `http://localhost:8000/log`
2. **Chọn ngày**: Dropdown để xem log của ngày khác
3. **Lọc theo level**: Chọn ERROR, WARNING, INFO, DEBUG
4. **Tìm kiếm**: Nhập từ khóa để tìm trong message và channel
5. **Xem chi tiết**: Mỗi log entry hiển thị:
   - **Context**: Exception details, file, line number
   - **Stack Trace**: Chi tiết lỗi (nếu có)
   - **Additional Info**: Thông tin bổ sung

### Cấu hình Logging

Dự án sử dụng daily logging để chia log theo ngày:
```env
LOG_CHANNEL=daily
```

Log files được lưu tại: `storage/logs/laravel-YYYY-MM-DD.log`

## Database

Dự án sử dụng MySQL làm database chính. Database `smartedu` đã được tạo với:
- **Host**: 127.0.0.1
- **Port**: 3306
- **Database**: smartedu
- **Username**: laravel
- **Password**: password

Cấu hình trong file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartedu
DB_USERNAME=laravel
DB_PASSWORD=password
```

Để thay đổi sang PostgreSQL, cập nhật file `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=smartedu
DB_USERNAME=postgres
DB_PASSWORD=
```

## Deployment

### Production build
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment variables
Đảm bảo cấu hình đúng các biến môi trường trong file `.env`:
- `APP_ENV=production`
- `APP_DEBUG=false`
- Database credentials
- Mail configuration
- Cache configuration

## User Interface

Dự án SmartEdu có giao diện user thân thiện với các trang chính:

### 🏠 Trang chủ (`/`)
- Hero section với call-to-action
- Features section giới thiệu tính năng
- Popular courses section
- Stats section với số liệu thống kê

### 📚 Khóa học (`/courses`)
- Grid hiển thị danh sách khóa học
- Filter theo danh mục và sắp xếp
- Search functionality
- Pagination

### 👨‍🏫 Giảng viên (`/teachers`)
- Grid hiển thị đội ngũ giảng viên
- Thông tin chi tiết từng giảng viên
- Stats về đội ngũ

### ℹ️ Giới thiệu (`/about`)
- Thông tin về sứ mệnh và tầm nhìn
- Giá trị cốt lõi của công ty
- Hình ảnh minh họa

### 📞 Liên hệ (`/contact`)
- Form liên hệ
- Thông tin địa chỉ, điện thoại, email
- Google Maps integration
- FAQ section

### 🎨 Design Features
- **Responsive Design**: Tương thích mọi thiết bị
- **Bootstrap 5**: Framework CSS hiện đại
- **Bootstrap Icons**: Icon library phong phú
- **Google Fonts**: Typography đẹp mắt
- **Modern UI/UX**: Giao diện thân thiện người dùng

## Support

Dự án được phát triển với Laravel 12.21.0 và PHP 8.2.29 trên Ubuntu Linux. 