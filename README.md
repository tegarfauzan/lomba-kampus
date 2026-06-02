# Kampus Juara - Website Lomba Organisasi Kampus

Website MVP untuk menampilkan informasi lomba, menerima pendaftaran peserta/tim, memverifikasi pendaftar, mengelola pengumuman, dan mengatur konten dasar website.

## 1. Stack

- Laravel 13.12 Blade
- Laravel Breeze Auth
- Spatie Laravel Permission
- Tailwind CSS, Vite, Alpine.js
- MySQL, cocok untuk Laragon dan phpMyAdmin
- PHP 8.3+

## 2. Akun Demo

```text
URL admin : /login
Email     : admin@kampus.test
Password  : password
Role      : admin
```

## 3. Mind Map Arsitektur

```text
Kampus Juara
|
+-- Public / Peserta
|   |
|   +-- Landing Page
|   |   +-- Hero, daftar lomba, timeline, benefit, pengumuman
|   |
|   +-- Lomba
|   |   +-- List lomba
|   |   +-- Detail lomba
|   |   +-- Form pendaftaran
|   |   +-- Halaman sukses + kode pendaftaran
|   |
|   +-- Cek Status
|   |   +-- Kode pendaftaran atau email ketua
|   |   +-- Pending, approved, rejected
|   |
|   +-- Pengumuman
|       +-- List, filter lomba, detail
|
+-- Admin / Panitia
    |
    +-- Auth + Spatie Role
    +-- Dashboard statistik
    +-- CRUD kategori
    +-- CRUD lomba
    +-- Verifikasi pendaftar
    +-- CRUD pengumuman
    +-- Settings website
```

## 4. Pendekatan Berjenjang

### Step 1 - Siapkan Database

Buat database MySQL:

```sql
CREATE DATABASE lomba_projek;
```

Konfigurasi `.env` sudah diarahkan ke:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lomba_projek
DB_USERNAME=root
DB_PASSWORD=
```

### Step 2 - Install Dependency

```bash
composer install
npm install
```

### Step 3 - Generate Key

```bash
php artisan key:generate
```

### Step 4 - Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Seeder membuat semua data demo utama:

- 1 admin
- 1 role Spatie `admin`
- 4 kategori
- 4 lomba
- 3 pendaftar
- 6 anggota pendaftar
- 2 pengumuman
- 1 settings website

### Step 5 - Storage Link

```bash
php artisan storage:link
```

Ini dibutuhkan agar upload poster lomba, dokumen peserta, dan logo bisa diakses dari browser.

### Step 6 - Build Asset

Untuk development:

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

### Step 7 - Jalankan Website

```bash
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000
```

## 5. Struktur Domain

```text
app/
|-- Enums/
|-- Http/
|   |-- Controllers/
|   |-- Middleware/
|   +-- Requests/
|-- Models/
|-- Repositories/
|   |-- Contracts/
|   +-- Eloquent...
+-- Services/
```

Prinsipnya:

- Controller tipis, hanya urus HTTP.
- Request khusus untuk validasi.
- Service menyimpan aturan bisnis seperti generate kode, upload file, approve/reject.
- Repository menyimpan query Eloquent agar mudah dirapikan ketika data makin besar.
- Enum menjaga status tidak tersebar sebagai string liar.

## 6. Tabel Utama

```text
users
roles, model_has_roles, permissions
categories
competitions
registrations
registration_members
announcements
settings
```

Relasi inti:

```text
Category has many Competition
Competition has many Registration
Registration has many RegistrationMember
Competition has many Announcement
Announcement belongs to Competition nullable
```

## 7. Route Penting

Public:

```text
/                         Landing page
/lomba                    List lomba
/lomba/{slug}             Detail lomba
/lomba/{slug}/daftar      Form daftar
/pendaftaran/berhasil/{kode}
/cek-status
/pengumuman
/pengumuman/{slug}
```

Admin:

```text
/login
/admin/dashboard
/admin/categories
/admin/competitions
/admin/registrations
/admin/announcements
/admin/settings
```

## 8. Keamanan yang Sudah Diterapkan

- Public self-register Breeze dimatikan karena MVP hanya admin/panitia.
- Admin route dilindungi middleware `auth` dan `admin`.
- Role memakai Spatie Permission.
- Form Request dipakai untuk validasi input.
- Upload file dibatasi tipe dan ukuran.
- CSRF aktif pada semua form.
- Password otomatis hashed oleh cast Laravel.
- Route model binding memakai slug/kode untuk URL publik.
- Foreign key dan index dipasang pada tabel inti.
- Reject pendaftar wajib memakai catatan admin.

## 9. Style Guide

Palette ada di `tailwind.config.js`:

```text
brand.maroon : #7D0A0A
brand.red    : #BF3131
brand.cream  : #EAD196
brand.soft   : #EEEEEE
```

Komponen UI umum ada di `resources/css/app.css`:

```text
.ui-card
.btn-primary
.btn-secondary
.btn-danger
.form-input
.form-label
.badge
.admin-link
```

Dark mode memakai class strategy Tailwind:

```js
darkMode: 'class'
```

Toggle tema memakai `localStorage` di `resources/js/app.js`.

## 10. Verifikasi

Sudah dijalankan:

```bash
php artisan route:list
php artisan migrate --seed --no-interaction
php artisan storage:link
npm run build
composer test
```

Hasil test terakhir:

```text
25 passed, 60 assertions
```

HTTP lokal yang dicek:

```text
GET /                200
GET /login           200
GET /admin/dashboard 302 ke /login saat belum login
```

## 11. Catatan Pengembangan Berikutnya

Fitur yang realistis untuk versi lanjutan:

- Export Excel pendaftar
- Email notifikasi approved/rejected
- Role tambahan seperti super admin, panitia, juri
- Upload karya final
- Sistem penilaian juri
- Sertifikat otomatis
