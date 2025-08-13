# API Manajemen User

API sederhana untuk mengelola data user dengan Laravel 12. Mendukung operasi CRUD lengkap dengan validasi dan error handling yang baik.

## 🚀 Cara Install

1. **Clone dan setup**
   ```bash
   git clone https://github.com/WiMProject/test-backend.git
   cd test-backend
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

2. **Setup database**
   ```bash
   # Edit .env sesuaikan database
   DB_DATABASE=backend_test
   DB_USERNAME=root
   DB_PASSWORD=your_password
   
   # Buat database dan jalankan migration
   php artisan migrate
   php artisan db:seed --class=UserManagementSeeder
   ```

3. **Jalankan server**
   ```bash
   php artisan serve
   ```
   ```bash
   # Jika Menggunakan Valet
   valet park
   ```

4. **Akses dokumentasi Swagger**
   ```
   http://localhost:8000/api/documentation
   
   # Untuk Valet bisa mengguanakan url dibawah ini
   http://test-backend.test/api/documentation
   ```

   **Atau langsung test API:**
   ```bash
   curl http://localhost:8000/api/users
   
   # Untuk Valet bisa mengguanakan url dibawah ini
   http://test-backend.test/api/documentation
   ```

## 📋 API Endpoints

| Method | URL | Fungsi |
|--------|-----|--------|
| GET | `/api/users` | Ambil semua user |
| GET | `/api/users/{id}` | Ambil user by ID |
| POST | `/api/users` | Buat user baru |
| PUT | `/api/users/{id}` | Update user |
| DELETE | `/api/users/{id}` | Hapus user |

## 💡 Contoh Penggunaan

### Ambil semua user
```bash
curl http://localhost:8000/api/users
```

### Buat user baru
```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Budi Santoso",
    "email": "budi@perusahaan.com",
    "phone_number": "08123456789",
    "department": "IT"
  }'
```

### Update user
```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Budi Santoso Updated",
    "department": "Marketing"
  }'
```

## ✅ Validasi Data

- **Nama**: Wajib diisi, maksimal 255 karakter
- **Email**: Wajib diisi, format email valid, harus unik
- **Nomor Telepon**: Wajib diisi, hanya angka, minimal 10 digit
- **Departemen**: Wajib diisi, maksimal 255 karakter
- **Status Aktif**: Opsional, boolean (default: true)

## 📝 Response Format

### Sukses
```json
{
  "success": true,
  "message": "User berhasil dibuat",
  "data": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@perusahaan.com",
    "phone_number": "08123456789",
    "is_active": true,
    "department": "IT"
  }
}
```

### Error
```json
{
  "success": false,
  "message": "Data tidak valid",
  "errors": {
    "email": ["Format email tidak valid"],
    "phone_number": ["Nomor telepon harus berupa angka minimal 10 digit"]
  }
}
```

## 📚 Dokumentasi API

**Swagger UI**: http://localhost:8000/api/documentation

Dokumentasi interaktif lengkap dengan:
- ✅ Semua endpoint API
- ✅ Request/response examples
- ✅ Try it out feature
- ✅ Schema definitions

## 🧪 Testing

```bash
# Jalankan test
php artisan test

# Test dengan data sample
php artisan db:seed --class=UserManagementSeeder

# Generate ulang dokumentasi Swagger
php artisan l5-swagger:generate
```

## 🐳 Docker (Opsional)

```bash
# Setup untuk Docker
cp .env.docker .env

# Jalankan dengan Docker
docker-compose up -d

# Migration di container
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed --class=UserManagementSeeder

# Generate dokumentasi Swagger
docker-compose exec app php artisan l5-swagger:generate
```

**Akses:**
- API: http://localhost:8000/api/users
- Swagger: http://localhost:8000/api/documentation
- Database: localhost:3307 (user: laravel, password: root)

## 🛠️ Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Swagger UI (L5-Swagger)
- Docker (opsional)

## 📂 Struktur Database

Tabel `users_management`:
- id (auto increment)
- name (string)
- email (string, unique)
- phone_number (string)
- is_active (boolean, default: true)
- department (string)
- created_at, updated_at (timestamps)

## 🚀 Deployment

Untuk deployment ke production:

1. **Railway/Render:**
   - Connect repository ke platform
   - Set environment variables
   - Deploy otomatis

2. **Manual Server:**
   ```bash
   # Set production environment
   APP_ENV=production
   APP_DEBUG=false
   
   # Optimize untuk production
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 🔧 Troubleshooting

**Error "Route not found":**
```bash
php artisan route:clear
php artisan config:clear
```

**Swagger tidak muncul:**
```bash
php artisan l5-swagger:generate
```

**Database connection error:**
- Pastikan database sudah dibuat
- Cek konfigurasi .env
- Jalankan `php artisan migrate`

---

**Status**: ✅ Siap digunakan
**Build By** : Wildan Miladji
