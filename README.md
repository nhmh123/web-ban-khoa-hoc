# CourseWeb – Online Learning Marketplace

## 📖 Description
CourseWeb is an online marketplace where learners can purchase and access diverse learning resources.  
It helps users improve their skills for academic success and career growth.

## 🛠️ Technologies
- **Frontend**: HTML, CSS (Bootstrap), JavaScript (jQuery)
- **Backend**: PHP (Laravel)
- **Database**: MySQL
- **Web Server**: Apache (via XAMPP)

---

## ⚙️ Environment Requirements
- [Composer](https://getcomposer.org/download/) **2.8.3+**
- [Node.js](https://nodejs.org/en/download) **v20.17.0+**
- npm **11.3.0+** (`npm install -g npm`)
- **PHP 8.2+**
- **Apache 2.4+**
- **MySQL 5.2.1+**

👉 You can use [XAMPP](https://www.apachefriends.org/download.html) for a convenient setup of Apache & MySQL.

---

## 🚀 Installation & Setup
```bash
# Clone the repository
git clone https://github.com/nhmh123/web-ban-khoa-hoc.git

# Enter the project folder
cd web-ban-khoa-hoc

# Copy environment file
cp .env.example .env

# Install dependencies
composer install
npm install

# Generate application key
php artisan key:generate

# Start Apache & MySQL using XAMPP

# Run migrations
php artisan migrate

# Start the development server
php artisan serve
```

## 🔑 Demo Credentials

| Role        | Email                             | Password  |
|-------------|-----------------------------------|-----------|
| Super Admin | dh52105753@student.stu.edu.vn     | 12345678  |
| Accounting  | dh52105753@gmail.com              | password  |
| Editor      | l.m@example.net                   | password  |
| Instructor  | tuyen.kha@example.org             | Password  |
| User        | dmau@example.com                  | password  |

⚠️*These credentials are for demonstration only.*

## 📂 Features

### 🔧 Management Features (Admin)

- User management: Create, view, update users

- Course management: CRUD courses, sections, and lectures (video/article)

- Course categories management: CRUD categories

- Order management: View users’ orders

- Course reviews: View feedback submitted by learners

- Static pages: CRUD About Us, Policies, etc.

- Web settings:

    - Metadata (app name, meta title, description)

    - Email configuration (sending emails to users)

    - Homepage sliders (CRUD)

    - Social media links

    - Contact information (email, phone, address)

    - Payment settings: Manage bank accounts for QR payment (manual entry only)

### 👤 User Features

- Browse, search, filter, and sort courses

- View course details and lectures (video/article)

- Take notes on lectures (CRUD)

- Review completed courses

- Manage wishlist (add/remove courses)

- Shopping cart & checkout

- Payment integration with MoMo

### 🛡️ Authorization Matrix

| Module        | User | Course Category | Course | Order | Static Page | Setting | Authorization |
|---------------|------|-----------------|--------|-------|-------------|---------|---------------|
| **Role**      |      |                 |        |       |             |         |               |
| Super Admin   |  x   |        x        |   x    |   x   |      x      |    x    |       x       |
| Accounting    |      |                 |        |   x   |             |         |               |
| Editor        |      |                 |        |       |      x      |         |               |
| Instructor    |      |        x        |        |       |             |         |               |

📌 Notes: *This project is built for educational and demonstration purposes.*

