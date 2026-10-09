# Sistem Informasi Posyandu
> Digitalisasi Pengelolaan Data dan Pelayanan Posyandu

---

## Informasi Kelompok

- **Nomor Kelompok:** Team 10
- **Shift Praktikum:** Shift A

---

## Anggota Kelompok

| No | Nama Lengkap | NIM | Shift Awal | Shift Akhir | Jobdesk / Kontribusi | Link Video Penjelasan |
|---|---|---|---|---|---|---|
| 1 | Lulu Waskito Adi | H1H024001 | A | A | CRUD Warga | [YouTube/Drive](https://youtu.be/0QB7TKRvrNk?si=GyIpvIwCL7OgHx6_) |
| 2 | Ghozi Itmam Aldani | H1H024003 | [Shift Awal] | A | CRUD Kegiatan | [YouTube/Drive](https://...) |
| 3 | Diva Syahita Mawarni | H1H024015 | [Shift Awal] | A | CRUD Pemeriksaan | [YouTube/Drive](https://...) |
| 4 | Kaira Meilasya Nayada | H1H024020 | [Shift Awal] | A | CRUD Jadwal | [YouTube/Drive](https://youtu.be/85LLGqTDB9Q) |

---

## Deskripsi Aplikasi

**Sistem Informasi Posyandu** merupakan aplikasi berbasis web yang dibuat untuk membantu proses pengelolaan data dan pelayanan Posyandu secara lebih terstruktur dan terpusat.

Aplikasi ini menyediakan berbagai fitur untuk mengelola data warga, kegiatan Posyandu, jadwal kegiatan, pemeriksaan kesehatan, serta riwayat pemeriksaan warga. Dengan adanya sistem ini, proses pencatatan dan pengelolaan data Posyandu dapat dilakukan secara digital sehingga informasi lebih mudah dikelola dan diakses.

Sistem memiliki beberapa jenis pengguna dengan hak akses yang berbeda, yaitu **Admin, Kader, dan Warga**. Setiap pengguna memiliki akses sesuai dengan kebutuhan dan perannya dalam sistem.

---

## Penjelasan Teknis

### 1. Teknologi (Tech Stack)

- **Backend:** Laravel 13.34.0
- **Bahasa Pemrograman:** PHP 8.3.25
- **Frontend:** Blade, Tailwind CSS, JavaScript
- **Database:** MySQL
- **Build Tool:** Vite
- **API:** Laravel REST API
- **Authentication:** Laravel Authentication & Session
- **Version Control:** Git & GitHub

---

### 2. Fitur Utama & Modul

#### Autentikasi dan Otorisasi

- Login pengguna
- Register pengguna
- Logout
- Pengelolaan session pengguna
- Role pengguna:
  - Admin
  - Kader
  - Warga
- Pembatasan akses berdasarkan role menggunakan middleware

#### Modul Warga

- Melihat daftar warga
- Melihat detail warga
- Menambahkan data warga
- Mengubah data warga
- Menghapus data warga
- Pencarian data warga
- Pengelompokan data warga berdasarkan kategori
- Melihat riwayat pemeriksaan warga

#### Modul Pemeriksaan

- Melihat data pemeriksaan
- Menambahkan data pemeriksaan
- Mengubah data pemeriksaan
- Menghapus data pemeriksaan
- Mencatat hasil pemeriksaan kesehatan warga
- Melihat riwayat pemeriksaan warga

#### Modul Jadwal

- Melihat daftar jadwal Posyandu
- Melihat detail jadwal
- Menampilkan tanggal kegiatan
- Menampilkan waktu kegiatan
- Menampilkan informasi kegiatan yang akan datang

#### Modul Kegiatan

- Melihat daftar kegiatan Posyandu
- Melihat detail kegiatan
- Menambahkan kegiatan
- Mengubah kegiatan
- Menghapus kegiatan
- Upload foto kegiatan
- Menampilkan status kegiatan

#### Dashboard dan Informasi

- Menampilkan jumlah warga
- Menampilkan jumlah kegiatan aktif
- Menampilkan jumlah jadwal yang akan datang
- Menampilkan informasi kegiatan Posyandu
- Menampilkan informasi jadwal terbaru

---

### 3. Skema Data Singkat

Relasi utama yang digunakan dalam sistem antara lain:

- `users` → `warga`
  - User dapat terhubung dengan data warga melalui `warga_id`.

- `warga` → `pemeriksaans`
  - Satu warga dapat memiliki beberapa data pemeriksaan.

- `users` → `pemeriksaans`
  - User dapat terhubung sebagai pemeriksa pada data pemeriksaan.

- `kegiatan` → `jadwal`
  - Jadwal dapat berkaitan dengan kegiatan Posyandu.

- `warga` → `riwayat pemeriksaan`
  - Data riwayat digunakan untuk menampilkan catatan pemeriksaan warga.

---

## Panduan Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://github.com/naayya-zna/Pemweb2-Sistem-informasi-posyandu-kel2.git
cd Pemweb2-Sistem-informasi-posyandu-kel2
```

### 2. Install Dependensi

Install dependency Laravel:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

### 3. Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Kemudian generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database MySQL, kemudian sesuaikan konfigurasi pada file `.env`.

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi Database

Jalankan migrasi:

```bash
php artisan migrate
```

Jika project menggunakan seeder:

```bash
php artisan migrate --seed
```

### 6. Jalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Kemudian jalankan Vite:

```bash
npm run dev
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## Struktur Project

Struktur utama project Laravel:

```text
Pemweb2-Sistem-informasi-posyandu-kel2/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── auth/
│       ├── components/
│       ├── kegiatan/
│       ├── jadwal/
│       ├── pemeriksaan/
│       └── warga/
├── routes/
│   ├── api.php
│   ├── web.php
│   ├── api/
│   └── web/
├── public/
├── .env.example
├── composer.json
├── package.json
└── README.md
```

---

## Hak Akses Pengguna

| Fitur | Admin | Kader | Warga |
|---|---|---|---|
| Login | ✅ | ✅ | ✅ |
| Melihat Data Warga | ✅ | ✅ | ✅ |
| Menambah Warga | ✅ | ❌ | ❌ |
| Mengubah Warga | ✅ | ❌ | ❌ |
| Menghapus Warga | ✅ | ❌ | ❌ |
| Melihat Jadwal | ✅ | ✅ | ✅ |
| Melihat Kegiatan | ✅ | ✅ | ✅ |
| Mengelola Pemeriksaan | ✅ | ✅ | ❌ |
| Melihat Riwayat Pemeriksaan | ✅ | ✅ | ✅ |

---

## Video Penjelasan

Link video penjelasan masing-masing anggota:

- **Anggota 1:** [Link Video](https://youtu.be/0QB7TKRvrNk?si=GyIpvIwCL7OgHx6_)
- **Anggota 2:** [Link Video](https://...)
- **Anggota 3:** [Link Video](https://...)
- **Anggota 4:** [Link Video](https://youtu.be/85LLGqTDB9Q)

---
