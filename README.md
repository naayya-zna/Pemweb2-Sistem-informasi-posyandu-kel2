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
| 2 | Ghozi Itmam Aldani | H1H024003 | [Shift Awal] | A | CRUD Kegiatan | [YouTube/Drive](https://youtu.be/Vp5Fea1xhKY)) |
| 3 | Diva Syahita Mawarni | H1H024015 | [Shift Awal] | A | CRUD Pemeriksaan | [YouTube/Drive](https://youtu.be/xVi1wBf11q8?si=hA1_afuPSGo-VKPC) |
| 4 | Kaira Meilasya Nayada | H1H024020 | [Shift Awal] | A | CRUD Jadwal | [YouTube/Drive](https://youtu.be/85LLGqTDB9Q) |

---

## Live Demo

**Link Deploy:** [https://a1.athafa.cloud/](https://a1.athafa.cloud/)

Aplikasi dapat diakses secara online melalui tautan di atas.

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

# Dokumentasi API Sistem Informasi Posyandu Digital

Dokumentasi ini berisi daftar endpoint API pada Sistem Informasi Posyandu Digital, meliputi autentikasi, pengelolaan warga, kegiatan, jadwal, pendaftaran, dan pemeriksaan.

## Base URL

```text
http://127.0.0.1:8000/api
```

> **Catatan:** Base URL tersebut digunakan untuk lingkungan pengembangan lokal. Hak akses dan ketersediaan endpoint perlu disesuaikan dengan konfigurasi route aktual pada aplikasi.

## Daftar Endpoint API

| No. | Modul | Metode HTTP | Endpoint | Fungsi | Hak Akses |
|---:|---|---|---|---|---|
| 1 | Autentikasi | POST | `/auth/register` | Registrasi akun pengguna | Publik* |
| 2 | Autentikasi | POST | `/auth/login` | Login pengguna dan memperoleh token | Publik* |
| 3 | Warga | GET | `/warga` | Menampilkan daftar warga | Perlu verifikasi |
| 4 | Warga | POST | `/warga` | Menambahkan data warga | Perlu verifikasi |
| 5 | Warga | GET | `/warga/{id}` | Menampilkan detail warga | Perlu verifikasi |
| 6 | Warga | PUT/PATCH | `/warga/{id}` | Memperbarui data warga | Perlu verifikasi |
| 7 | Warga | DELETE | `/warga/{id}` | Menghapus data warga | Perlu verifikasi |
| 8 | Kegiatan | GET | `/kegiatan` | Menampilkan daftar kegiatan | Perlu verifikasi |
| 9 | Kegiatan | POST | `/kegiatan` | Menambahkan kegiatan | Perlu verifikasi |
| 10 | Kegiatan | GET | `/kegiatan/{id}` | Menampilkan detail kegiatan | Perlu verifikasi |
| 11 | Kegiatan | PUT/PATCH | `/kegiatan/{id}` | Memperbarui kegiatan | Perlu verifikasi |
| 12 | Kegiatan | DELETE | `/kegiatan/{id}` | Menghapus kegiatan | Perlu verifikasi |
| 13 | Jadwal | GET | `/jadwal` | Menampilkan daftar jadwal | Pengguna terautentikasi |
| 14 | Jadwal | GET | `/jadwal/{jadwal}` | Menampilkan detail jadwal | Pengguna terautentikasi |
| 15 | Jadwal | GET | `/jadwal/opsi` | Mengambil opsi jadwal untuk formulir | Admin, kader |
| 16 | Jadwal | POST | `/jadwal` | Menambahkan jadwal | Admin, kader |
| 17 | Jadwal | PUT/PATCH | `/jadwal/{jadwal}` | Memperbarui jadwal | Admin, kader |
| 18 | Jadwal | DELETE | `/jadwal/{jadwal}` | Menghapus jadwal | Admin, kader |
| 19 | Jadwal | POST | `/jadwal/{jadwal}/mulai` | Memulai pelaksanaan jadwal | Admin, kader |
| 20 | Jadwal | POST | `/jadwal/{jadwal}/selesai` | Menandai jadwal selesai | Admin, kader |
| 21 | Jadwal | POST | `/jadwal/{jadwal}/batal` | Membatalkan jadwal | Admin, kader |
| 22 | Pendaftaran | GET | `/jadwal/{jadwal}/pendaftaran` | Menampilkan daftar pendaftar jadwal | Admin, kader |
| 23 | Pendaftaran | POST | `/jadwal/{jadwal}/pendaftaran` | Mendaftarkan warga ke jadwal | Warga |
| 24 | Pendaftaran | DELETE | `/jadwal/{jadwal}/pendaftaran` | Membatalkan pendaftaran jadwal | Warga |
| 25 | Pemeriksaan | GET | `/pemeriksaan` | Menampilkan daftar pemeriksaan | Autentikasi Sanctum |
| 26 | Pemeriksaan | POST | `/pemeriksaan` | Menambahkan data pemeriksaan | Autentikasi Sanctum |
| 27 | Pemeriksaan | GET | `/pemeriksaan/{pemeriksaan}` | Menampilkan detail pemeriksaan | Autentikasi Sanctum |
| 28 | Pemeriksaan | PUT/PATCH | `/pemeriksaan/{pemeriksaan}` | Memperbarui data pemeriksaan | Autentikasi Sanctum |
| 29 | Pemeriksaan | DELETE | `/pemeriksaan/{pemeriksaan}` | Menghapus data pemeriksaan | Autentikasi Sanctum |

## Keterangan Metode HTTP

- **GET**: mengambil atau menampilkan data.
- **POST**: membuat data baru atau menjalankan suatu aksi.
- **PUT/PATCH**: memperbarui data yang sudah ada.
- **DELETE**: menghapus data.

## Keterangan Parameter

Parameter yang ditulis menggunakan kurung kurawal merupakan nilai dinamis yang perlu diganti dengan identitas data terkait.

Contoh:

- `/warga/{id}` — `{id}` diganti dengan ID warga.
- `/kegiatan/{id}` — `{id}` diganti dengan ID kegiatan.
- `/jadwal/{jadwal}` — `{jadwal}` diganti dengan ID jadwal.
- `/pemeriksaan/{pemeriksaan}` — `{pemeriksaan}` diganti dengan ID pemeriksaan.

## Keterangan Hak Akses

- **Publik**: endpoint dirancang agar dapat diakses tanpa login, tetapi middleware aktual perlu diperiksa.
- **Pengguna terautentikasi**: pengguna harus login sebelum mengakses endpoint.
- **Admin, kader**: akses dibatasi untuk pengguna dengan role admin atau kader.
- **Warga**: endpoint ditujukan bagi pengguna dengan role warga.
- **Autentikasi Sanctum**: permintaan memerlukan autentikasi sesuai konfigurasi Laravel Sanctum.
- **Perlu verifikasi**: hak akses endpoint belum dipastikan dan perlu diperiksa pada konfigurasi route aplikasi.

## Verifikasi Endpoint

Untuk memastikan endpoint yang terdokumentasi sesuai dengan implementasi aplikasi, jalankan perintah berikut pada terminal di direktori proyek Laravel:

```bash
php artisan route:list --path=api
```

Perintah tersebut menampilkan daftar route API yang terdaftar, termasuk metode HTTP, URI, dan action controller. Periksa juga middleware yang digunakan untuk memastikan pembatasan hak aksesnya sesuai.

**Catatan:** Dokumentasi ini merupakan daftar endpoint berdasarkan rancangan yang tersedia. Endpoint Warga dan Kegiatan serta hak aksesnya masih perlu diverifikasi sebelum dokumentasi dianggap sebagai representasi final dari implementasi API.

---

## Video Penjelasan

Link video penjelasan masing-masing anggota:

- **Anggota 1:** [Link Video](https://youtu.be/0QB7TKRvrNk?si=GyIpvIwCL7OgHx6_)
- **Anggota 2:** [Link Video](https://...)
- **Anggota 3:** [Link Video](https://...)
- **Anggota 4:** [Link Video](https://youtu.be/85LLGqTDB9Q)

---
