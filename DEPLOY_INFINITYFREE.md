# Panduan Deploy PartyKit-Z ke InfinityFree

## Persiapan Sebelum Upload

### 1. Build dependency (jalanin di terminal lokal)
```bash
cd D:/PartyKit-Z

# Install Composer (production mode)
composer install --no-dev --optimize-autoloader

# Build frontend assets (Vue + Vite)
npm install
npm run build
```

### 2. Konfigurasi Database MySQL di InfinityFree

1. Login ke https://infinityfree.net/ → **Control Panel**
2. Klik **MySQL Databases** → **New Database**
3. Isi nama database (misal: `partykitz`)
4. Catat info berikut:
   - **Host**: `sqlXXX.infinityfree.com` (lihat di panel)
   - **Database**: `if0_XXXXXX_partykitz`
   - **Username**: `if0_XXXXXX`
   - **Password**: (isi sendiri)

### 3. Siapkan File .env

Copy `.env.example` → `.env` lalu isi:

```
APP_NAME=PartyKit-Z
APP_ENV=production
APP_DEBUG=false
APP_URL=https://namadomainkamu.42web.io

DB_CONNECTION=mysql
DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_XXXXXX_partykitz
DB_USERNAME=if0_XXXXXX
DB_PASSWORD=password_kamu

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

> **PENTING**: Ganti semua `XXX` dan `XXXXXX` dengan data dari panel InfinityFree.

### 4. Generate APP_KEY

```bash
php artisan key:generate
```

---

## Upload ke InfinityFree

### Via File Manager (rekomendasi)

1. Login ke **InfinityFree Control Panel**
2. Klik **File Manager**
3. Buka folder **htdocs**

4. **Upload & Extract:**
   - Zip folder `D:\PartyKit-Z` (kecuali folder `node_modules`, `.env`, `storage/logs/*`)
   - Klik **Upload** → pilih file zip
   - Setelah upload selesai, **Extract** file zip

5. **Atau upload satu per satu** (lebih lambat):
   - Upload file `.htaccess` dulu
   - Upload folder `public/`, `app/`, `config/`, `routes/`, `vendor/`, `resources/`, `storage/`, `bootstrap/`
   - Upload file `php.ini`, `artisan`, `composer.json`, `composer.lock`

### Struktur folder setelah upload:
```
/htdocs/
  ├── .htaccess         ← redirect ke /public
  ├── php.ini           ← konfigurasi PHP
  ├── .env              ← setting database
  ├── app/
  ├── public/
  ├── vendor/
  ├── storage/
  ├── ... (file lain)
```

---

## Setelah Upload

### 1. Set Permission Storage

Di **File Manager**, klik kanan folder `storage/` → **Permissions** → set ke `755`.
Lakukan hal yang sama untuk `bootstrap/cache/`.

### 2. Jalankan Migration via Remote MySQL

Ada 3 cara:

**Cara A — Pakai MySQL Workbench / HeidiSQL (termudah):**
1. Buka HeidiSQL atau MySQL Workbench
2. Konek ke:
   - Host: `sqlXXX.infinityfree.com`
   - Port: `3306`
   - User: `if0_XXXXXX`
   - Password: (yang tadi)
3. Import file SQL (export dulu dari SQLite atau jalankan migration dari lokal)

**Cara B — Migration via command (butuh remote MySQL access):**
```bash
php artisan migrate --force --database=mysql \
  --host=sqlXXX.infinityfree.com \
  --port=3306 \
  --database=if0_XXXXXX_partykitz \
  --username=if0_XXXXXX
```

**Cara C — Pakai script migration (upload file migrasi):**
Upload file berikut sebagai `migrate.php` di root:

```php
<?php
// migrate.php — upload ke /htdocs/migrate.php, akses via browser, hapus setelah selesai
putenv('APP_ENV=production');
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call('migrate', ['--force' => true]);
echo "Migration selesai!";
```

Akses: `https://domainkamu.42web.io/migrate.php`
**HAPUS FILE INI SETELAH SELESAI!**

### 3. Cek Hasil

Akses domain InfinityFree Anda:
`https://namadomainkamu.42web.io/`

---

## Catatan Penting

| Hal | Info |
|-----|------|
| **PHP Version** | InfinityFree pake PHP 8.x (cocok dengan Laravel 12) |
| **Composer** | Tidak tersedia di server — jalanin `composer install` **sebelum upload** |
| **Artisan** | Tidak bisa jalan di InfinityFree — migrasi via remote atau script |
| **File Storage** | File upload user akan tersimpan di `storage/app/public/` |
| **SSL** | InfinityFree kasih SSL gratis via Cloudflare |
| **Backup** | Backup file dan database secara berkala via panel |
| **Session & Cache** | Pakai `file` driver (tersimpan di folder `storage/`), nggak perlu tabel database |

---

## ⚠️ Keamanan

**Jangan commit file `.env` ke GitHub!**
File `.env.example` aman karena isinya cuma contoh. Tapi pastikan:
- `.env` asli masuk `.gitignore` (sudah otomatis)
- Jangan upload `.env` ke InfinityFree yang bisa dibaca publik
- Hapus file `migrate.php` setelah selesai migrasi

**Email password di .env.example:**
Password email `xxukvleujaivngon` adalah App Password Gmail. Jika ini password asli, segera ganti setelah deploy. Simpan di `.env` saja, jangan di `.env.example`.

---

## Troubleshooting

**Error 500 / Blank page:**
- Cek file `.env` sudah benar
- Cek permission `storage/` dan `bootstrap/cache/` sudah 755
- Cek file `.htaccess` sudah ada

**Error "No application encryption key":**
- Belum `php artisan key:generate` — generate dulu, copy APP_KEY ke .env

**Error database connection:**
- Pastikan host, database name, username, password benar dari panel InfinityFree
- Cek apakah database sudah dibuat

**Error "Class not found":**
- Jalankan `composer dump-autoload` di lokal, upload ulang folder `vendor/`
