# CourseWeb – Web cung cấp khóa học trực tuyến

## 📖 Mô tả
CourseWeb là một web bán hàng trực tuyến, nơi người học có thể mua và truy cập vào nhiều tài nguyên học tập đa dạng.
Dự án hỗ trợ người dùng nâng cao kỹ năng, phục vụ cho việc học tập cũng như phát triển nghề nghiệp.

## 📂 Tài liệu
Ảnh chụp màn hình, ERD, dữ liệu mẫu: [Xem trên Google Drive](https://drive.google.com/drive/folders/1iB3lNwzdB7nMUdFw0M_MDxaL4pFXCew5?usp=drive_link)

## 🛠️ Công nghệ sử dụng
- **Frontend**: HTML, CSS (Bootstrap), JavaScript (jQuery)
- **Backend**: PHP (Laravel)
- **Database**: MySQL
- **Web Server**: Apache (qua XAMPP)

---

## ⚙️ Yêu cầu môi trường
- [Composer](https://getcomposer.org/download/) **2.8.3+**
- [Node.js](https://nodejs.org/en/download) **v20.17.0+**
- npm **11.3.0+** (`npm install -g npm`)
- **PHP 8.2+**
- **Apache 2.4+**
- **MySQL 5.2.1+**

👉 Có thể sử dụng [XAMPP](https://www.apachefriends.org/download.html) để cài đặt Apache & MySQL nhanh chóng.

---

## 🚀 Cài đặt & Chạy dự án
```bash
# Clone source code
git clone https://github.com/nhmh123/web-ban-khoa-hoc.git

# Vào thư mục dự án
cd web-ban-khoa-hoc

# Sao chép file môi trường
cp .env.example .env

# Cài đặt dependencies
composer install
npm install

# Tạo application key
php artisan key:generate

# Khởi động Apache & MySQL bằng XAMPP

# Chạy migration
php artisan migrate

# Chạy server phát triển
php artisan serve
```

## 🔑 Tài khoản demo

| Vai trò     | Email                             | Mật khẩu  |
|-------------|-----------------------------------|-----------|
| Super Admin | dh52105753@student.stu.edu.vn     | 12345678  |
| Accounting  | dh52105753@gmail.com              | password  |
| Editor      | l.m@example.net                   | password  |
| Instructor  | tuyen.kha@example.org             | Password  |
| User        | dmau@example.com                  | password  |

⚠️*Các tài khoản trên chỉ dùng cho mục đích demo.*

## 📂 Tính năng

### 🔧 Quản trị viên (Admin)

- Quản lý người dùng: Tạo, xem, cập nhật thông tin

- Quản lý khóa học: CRUD khóa học, chương, bài giảng (video / bài viết)

- Quản lý danh mục khóa học

- Quản lý đơn hàng: Xem danh sách đơn mua

- Quản lý đánh giá khóa học từ người học

- Quản lý trang tĩnh (About Us, Chính sách, …)

- Cấu hình website:

    - Thông tin meta (tên ứng dụng, tiêu đề, mô tả)

    - Cấu hình email gửi cho người dùng
    
    - Slider trang chủ (CRUD)
    
    - Liên kết mạng xã hội
    
    - Thông tin liên hệ (email, số điện thoại, địa chỉ)
    
    - Cấu hình thanh toán: Quản lý tài khoản ngân hàng để tạo mã QR thanh toán (nhập thủ công, chưa tích hợp API)

### 👤 Người dùng

- Xem, tìm kiếm, lọc và sắp xếp khóa học

- Xem chi tiết và học bài giảng (video / bài viết)

- Ghi chú trong bài giảng (CRUD)

- Đánh giá sau khi hoàn thành khóa học

- Quản lý danh sách yêu thích (thêm / xóa)

- Giỏ hàng & thanh toán

- Thanh toán qua ví MoMo

### 🛡️ Phân quyền

| Module        | User | Danh mục   | Khóa học | Đơn hàng | Trang tĩnh | Cài đặt | Phân quyền |
|---------------|------|------------|----------|----------|------------|---------|------------|
| **Vai trò**   |      |            |          |          |            |         |            |
| Super Admin   |  x   |        x   |   x      |   x      |      x     |    x    |       x    |
| Accounting    |      |            |          |   x      |            |         |            |
| Editor        |      |            |          |          |      x     |         |            |
| Instructor    |      |        x   |          |          |            |         |            |

📌 *Dự án được xây dựng phục vụ mục đích học tập và demo.*



