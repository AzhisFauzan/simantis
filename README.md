# Sistem Informasi Inventaris & Maintenance Aset IT RS Berbasis Web

Sistem Informasi Inventaris dan Maintenance Aset IT (PC, Laptop, Printer, dll) berbasis web. Dibangun menggunakan framework Laravel 12 dan Bootstrap, sistem ini ditujukan untuk mempermudah pengelolaan perangkat, pelacakan jadwal perbaikan, pencetakan laporan PDF.

## Fitur Utama
- **Manajemen Aset IT:** Pendataan perangkat secara sistematis dengan kode berurutan.
- **Maintenance Tracking:** Pencatatan jadwal pemeliharaan serta perbaikan perangkat.
- **Reporting:** Fitur *export* dan cetak laporan data inventaris ke format PDF DAN Excel.

## Tech Stack
- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Bootstrap 
- **Database:** MySQL

## Struktur project saat ini
```
sistemInventaris/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthCtrl.php
│   │   ├── Controller.php
│   │   ├── DashboardCtrl.php
│   │   ├── KategoriCtrl.php
│   │   ├── LaporanCtrl.php
│   │   ├── MaintenanceCtrl.php
│   │   ├── PerangkatCtrl.php
│   │   ├── RuanganCtrl.php
│   │   └── UserCtrl.php
│   ├── Models/
│   │   ├── KategoriPerangkat.php
│   │   ├── Perangkat.php
│   │   ├── Ruangan.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   ├── cache/
│   │   ├── .gitignore
│   │   ├── packages.php
│   │   └── services.php
│   ├── app.php
│   └── providers.php
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .editorconfig
├── .env
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── Dockerfile
├── package.json
└── phpunit.xml
```
## Petunjuk Instalasi Lokal
Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

**1. Clone Repository**
git clone [https://github.com/AzhisFauzan/sistemInventaris.git](https://github.com/AzhisFauzan/sistemInventaris.git)
cd sistemInventaris

**2. Install Dependencies**
- composer install

**3. Siapkan File Environment**
Duplikat file .env.example menjadi .env lalu generate key aplikasi:
- cp .env.example .env
- php artisan key:generate

**4. Konfigurasi Database Lokal**
Buka file .env dan sesuaikan dengan kredensial database MySQL lokal:

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=sisteminventaris
- DB_USERNAME=root
- DB_PASSWORD=

**5. Jalankan Migrasi Database**
- php artisan migrate

**6. Jalankan Aplikasi**
Buka dua terminal untuk menjalankan server backend dan asset frontend:
- php artisan serve
