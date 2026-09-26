# Sistem Perpustakaan Digital Kampus (`app-perpustakaan`)

Aplikasi manajemen perpustakaan kampus berbasis Laravel 12 untuk mengelola data buku, anggota, dan transaksi peminjaman.

## Tech Stack

- **Framework:** Laravel 12
- **Database:** MySQL (via XAMPP)
- **PHP:** >= 8.2

## Cara Menjalankan Project Secara Lokal

1. Pastikan PHP (>= 8.2), Composer, dan MySQL (XAMPP) sudah aktif.
2. Clone repository dan masuk ke direktori proyek:
   ```bash
   git clone https://github.com/AkihikoRalisTyan/app-perpustakaan.git
   cd app-perpustakaan
   ```
3. Install dependensi:
   ```bash
   composer install
   ```
4. Salin file environment dan generate key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Sesuaikan konfigurasi database di `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
6. Jalankan migration:
   ```bash
   php artisan migrate
   ```
7. Jalankan server:
   ```bash
   php artisan serve
   ```

## Progress Pertemuan

| Pertemuan | Topik | Status |
|---|---|---|
| 1 | Instalasi Laravel & Setup Project | ✅ Done |
| 2 | Routing & Controller | ✅ Done |
| 3 | Blade Views & Form | ✅ Done |
| 4 | Form Request & Validasi | ✅ Done |
| 5 | Migration, Eloquent Model & CRUD | ✅ Done |