# 📚 Perpustakaan Digital

Sistem manajemen perpustakaan digital yang dibangun dengan Laravel 12 untuk mempermudah pengelolaan buku, anggota, dan transaksi peminjaman.

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat&logo=php)
![SQLite](https://img.shields.io/badge/Database-SQLite-green?style=flat&logo=sqlite)
![License](https://img.shields.io/badge/License-MIT-yellow?style=flat)

## 🚀 Fitur Utama

### 👨‍💼 Admin Features
- ✅ **Manajemen Buku**: CRUD lengkap untuk data buku
- ✅ **Manajemen Anggota**: Kelola data anggota perpustakaan  
- ✅ **Monitoring Peminjaman**: Track semua aktivitas peminjaman
- ✅ **Dashboard Analytics**: Overview statistik perpustakaan
- ✅ **Laporan**: Generate laporan aktivitas

### 👤 Member Features
- ✅ **Katalog Buku**: Browse dan search buku yang tersedia
- ✅ **Peminjaman Online**: Request peminjaman buku
- ✅ **History Peminjaman**: Lihat riwayat peminjaman
- ✅ **Profile Management**: Kelola informasi profil
- ✅ **Dashboard Personal**: Overview peminjaman aktif

### 🔐 Security Features
- ✅ **Authentication**: Login/Register dengan Laravel Breeze
- ✅ **Role-based Access**: Admin dan Member roles
- ✅ **CSRF Protection**: Keamanan form submission
- ✅ **Data Validation**: Input sanitization dan validation

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade Templates + Bootstrap
- **Database**: SQLite (Development) / MySQL (Production)
- **Authentication**: Laravel Breeze
- **Styling**: Bootstrap 5 + Custom CSS
- **Icons**: Font Awesome / Lucide Icons

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite extension (untuk development)

## ⚡ Quick Start

### 1. Clone Repository
```bash
git clone https://github.com/username/perpustakaan-digital.git
cd perpustakaan-digital
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Build assets
npm run build
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database (if not exists)
touch database/database.sqlite
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed database with sample data (optional)
php artisan db:seed
```

### 5. Start Development Server
```bash
# Start Laravel development server
php artisan serve

# In another terminal, watch for asset changes
npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🗄️ Database Structure

### Tables Overview
```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│    users    │    │   members   │    │ borrowings  │
├─────────────┤    ├─────────────┤    ├─────────────┤
│ id          │◄──►│ id          │◄──►│ id          │
│ name        │    │ user_id     │    │ member_id   │
│ email       │    │ member_code │    │ book_id     │
│ password    │    │ phone       │    │ borrow_date │
│ role        │    │ address     │    │ due_date    │
│ timestamps  │    │ timestamps  │    │ return_date │
└─────────────┘    └─────────────┘    │ status      │
                                      │ timestamps  │
┌─────────────┐                       └─────────────┘
│    books    │                              ▲
├─────────────┤                              │
│ id          │◄─────────────────────────────┘
│ title       │
│ author      │
│ isbn        │
│ publisher   │
│ year        │
│ category    │
│ stock       │
│ available   │
│ timestamps  │
└─────────────┘
```

## 🎯 Usage Guide

### Default Login Credentials
```
Admin Account:
Email: admin@perpustakaan.com
Password: password

Member Account:
Email: member@perpustakaan.com  
Password: password
```

### Admin Workflow
1. **Login** sebagai admin
2. **Tambah Buku** via menu Books → Create
3. **Kelola Anggota** via menu Members
4. **Monitor Peminjaman** via menu Borrowings
5. **Lihat Statistics** di Dashboard

### Member Workflow
1. **Register** atau **Login** sebagai member
2. **Browse Katalog** untuk cari buku
3. **Request Peminjaman** buku yang tersedia
4. **Track Status** di dashboard personal
5. **Update Profile** di menu Profile

## 🔧 Configuration

### Environment Variables (.env)
```env
APP_NAME="Perpustakaan Digital"
APP_ENV=local
APP_KEY=base64:generated_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

# For MySQL (Production)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=perpustakaan_digital
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

### Custom Configuration
Edit file `config/app.php` untuk customization:
```php
// Loan duration (days)
'loan_duration' => 14,

// Maximum books per member
'max_books_per_member' => 3,

// Fine per day (in currency)
'fine_per_day' => 1000,
```

## 🚀 Deployment

### Production Setup
1. **Server Requirements**: Apache/Nginx, PHP 8.2+, MySQL
2. **Upload Files** ke server
3. **Install Dependencies**: `composer install --no-dev`
4. **Build Assets**: `npm run build`
5. **Configure Environment**: Update `.env` untuk production
6. **Database Setup**: Run migrations di production database
7. **Set Permissions**: 
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

### Docker Deployment (Optional)
```dockerfile
# Dockerfile example
FROM php:8.2-fpm
# ... (akan dilengkapi jika diperlukan)
```

## 🧪 Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Categories
- **Unit Tests**: Model logic testing
- **Feature Tests**: HTTP request testing  
- **Browser Tests**: E2E testing with Laravel Dusk

## 📱 API Documentation

### Authentication Endpoints
```
POST /api/login          # User login
POST /api/register       # User registration
POST /api/logout         # User logout
```

### Books Endpoints
```
GET    /api/books        # Get all books
GET    /api/books/{id}   # Get specific book
POST   /api/books        # Create new book (Admin)
PUT    /api/books/{id}   # Update book (Admin)
DELETE /api/books/{id}   # Delete book (Admin)
```

### Borrowings Endpoints
```
GET  /api/borrowings     # Get user borrowings
POST /api/borrowings     # Create new borrowing
PUT  /api/borrowings/{id}/return  # Return book
```

## 🤝 Contributing

1. **Fork** repository ini
2. **Create** feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to branch (`git push origin feature/AmazingFeature`)
5. **Open** Pull Request

### Development Guidelines
- Follow **PSR-12** coding standards
- Write **comprehensive tests** untuk new features
- Update **documentation** jika diperlukan
- Use **meaningful commit messages**

## 🐛 Bug Reports

Jika menemukan bug, silakan buat **issue** dengan informasi:
- **Environment**: OS, PHP version, Laravel version
- **Steps to reproduce**: Langkah-langkah untuk reproduce bug  
- **Expected behavior**: Behavior yang diharapkan
- **Actual behavior**: Behavior yang terjadi
- **Screenshots**: Jika memungkinkan

## 📋 Roadmap

### Version 2.0 (Planned)
- [ ] **Mobile App**: React Native application
- [ ] **Advanced Reports**: PDF/Excel export functionality
- [ ] **Email Notifications**: Due date reminders
- [ ] **Barcode Integration**: Barcode scanner support
- [ ] **Payment Gateway**: Fine payment system
- [ ] **Multi-library**: Support multiple library branches

### Version 1.5 (Next Release)
- [ ] **Book Reservation**: Reserve books yang sedang dipinjam
- [ ] **Review System**: Member dapat review dan rating buku
- [ ] **Advanced Search**: Search dengan multiple filters
- [ ] **Dashboard Improvements**: More detailed analytics

## 📞 Support

Butuh bantuan? Silakan hubungi:
- **Email**: support@perpustakaan-digital.com
- **GitHub Issues**: [Create new issue](https://github.com/username/perpustakaan-digital/issues)
- **Documentation**: [Wiki pages](https://github.com/username/perpustakaan-digital/wiki)

## 📄 License

Project ini menggunakan **MIT License**. Lihat file [LICENSE](LICENSE) untuk detail lengkap.

## 👥 Credits

Dikembangkan dengan ❤️ oleh:
- **[Your Name]** - Lead Developer
- **[Team Members]** - Contributors

### Acknowledgments
- Laravel Framework team
- Bootstrap team  
- Open source community

---

⭐ **Star this repository** jika project ini membantu Anda!

**Made with Laravel 12 🚀**