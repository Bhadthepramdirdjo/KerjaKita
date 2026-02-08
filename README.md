# KerjaKita - Platform Job Marketplace untuk Pekerja Lepas

![Laravel](https://img.shields.io/badge/Laravel-12.0-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![MySQL](https://img.shields.io/badge/MySQL-10.4-orange)

## Deskripsi Program

**KerjaKita** adalah platform berbasis web yang menghubungkan **Pemberi Kerja** dengan **Pekerja** untuk pekerjaan lepas atau proyek jangka pendek. Sistem ini memfasilitasi proses pencarian kerja, pelamaran, pengelolaan pekerjaan, hingga sistem rating dan review untuk membangun kepercayaan antara kedua belah pihak.

### Konsep Utama
Aplikasi ini dirancang sebagai **marketplace pekerjaan** yang memungkinkan:
- **Pemberi Kerja**: Membuat lowongan pekerjaan, mengelola pelamar, memilih pekerja yang sesuai, dan memberikan rating
- **Pekerja**: Mencari lowongan, melamar pekerjaan, mengelola lamaran, dan membangun portofolio berbasis rating

---

## Fitur Utama

### Untuk Pemberi Kerja

#### 1. Manajemen Lowongan
- Membuat lowongan pekerjaan dengan detail lengkap (judul, deskripsi, lokasi, upah, gambar)
- Menyimpan lowongan sebagai draft atau langsung publikasi
- Mengelola status lowongan (aktif/tidak aktif)
- Upload gambar lowongan untuk menarik pelamar

#### 2. Manajemen Pelamar
- Melihat daftar semua pelamar untuk setiap lowongan
- Melihat profil lengkap pelamar (keahlian, rating, pengalaman kerja)
- Menerima atau menolak lamaran pekerja
- Sistem otomatis menutup lowongan ketika pekerja diterima

#### 3. Manajemen Pekerjaan
- Melacak status pekerjaan yang sedang berjalan
- Konfirmasi pekerjaan selesai
- Memberikan rating dan review untuk pekerja

#### 4. Dashboard & Statistik
- Melihat jumlah lowongan aktif
- Jumlah pelamar baru hari ini
- Pekerjaan dalam proses
- Pekerjaan yang telah selesai

### Untuk Pekerja

#### 1. Pencarian Pekerjaan
- Browse lowongan yang tersedia
- Filter berdasarkan kategori, lokasi, dan kata kunci
- Melihat detail lowongan lengkap

#### 2. Manajemen Lamaran
- Melamar lowongan dengan satu klik
- Melihat status lamaran (pending, diterima, ditolak)
- Melacak pekerjaan yang sedang dikerjakan

#### 3. Profil & Portofolio
- Mengelola profil pribadi (foto, bio, keahlian)
- Menambahkan multiple keahlian
- Melihat rating dan ulasan dari pemberi kerja
- Riwayat pekerjaan yang telah diselesaikan

#### 4. Sistem Notifikasi
- Notifikasi lamaran diterima/ditolak
- Notifikasi pekerjaan selesai
- Notifikasi rating baru dari pemberi kerja

### Fitur Tambahan

- **Sistem Rating & Review**: Rating 1-5 bintang dengan ulasan detail
- **Sistem Notifikasi Real-time**: Notifikasi untuk setiap aktivitas penting
- **Upload Gambar**: Untuk lowongan dan foto profil (validasi ukuran dan format)
- **Activity Log**: Pencatatan setiap aktivitas pengguna (login, register, dll)
- **Database Views & Stored Procedures**: Optimasi query dengan views dan stored procedures
- **Database Triggers**: Otomasi pembuatan data terkait (auto-create Pekerja/PemberiKerja)

---

## Struktur Database

### Tabel Utama

1. **User** - Data pengguna (Pekerja dan Pemberi Kerja)
2. **Pekerja** - Profil detail pekerja
3. **PemberiKerja** - Profil detail pemberi kerja
4. **Lowongan** - Data lowongan pekerjaan
5. **Lamaran** - Data lamaran pekerja
6. **Pekerjaan** - Tracking pekerjaan yang sedang/sudah berjalan
7. **Rating** - Rating dan ulasan
8. **Notifikasi** - Sistem notifikasi
9. **Kategori** - Kategori pekerjaan
10. **Activity_Log** - Log aktivitas sistem

### Database Views

- `v_lowongan_detail` - View untuk detail lowongan dengan relasi
- `v_lamaran_detail` - View untuk detail lamaran dengan relasi
- `v_rating_pekerja` - View agregat rating pekerja
- `v_rating_pemberi_kerja` - View agregat rating pemberi kerja

### Stored Procedures

- `sp_cari_lowongan` - Pencarian lowongan dengan filter
- `sp_dashboard_pekerja` - Statistik dashboard pekerja
- `sp_dashboard_pemberi_kerja` - Statistik dashboard pemberi kerja

### Database Triggers

- `after_user_insert` - Auto-create Pekerja/PemberiKerja setelah user dibuat
- `after_message_insert` - Update timestamp terakhir pesan

---

## Teknologi yang Digunakan

### Backend
- **Laravel Framework** v12.0
- **PHP** v8.2
- **MySQL/MariaDB** v10.4+
- **Composer** - Dependency management

### Frontend
- **Blade Template Engine**
- **TailwindCSS** - Styling framework
- **JavaScript** - Interaktivitas
- **Alpine.js** (opsional) - Lightweight JavaScript framework

### Tools & Library
- **Laravel Tinker** - REPL untuk debugging
- **Laravel Pail** - Log viewer
- **Storage** - File upload management
- **Queue** - Background job processing

---

## Instalasi & Konfigurasi

### Prasyarat

Pastikan sistem Anda memiliki:
- **PHP** >= 8.2
- **Composer** >= 2.x
- **MySQL/MariaDB** >= 10.4
- **XAMPP/WAMP/MAMP** atau web server lainnya
- **Node.js & NPM** (untuk asset compilation)

### Langkah 1: Clone/Download Project

```bash
# Jika dari Git
git clone <repository-url> KerjaKita
cd KerjaKita

# Atau extract file zip ke folder htdocs/www
```

### Langkah 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install frontend dependencies (jika ada)
npm install
```

### Langkah 3: Konfigurasi Environment

1. Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

2. Edit file `.env` sesuaikan dengan konfigurasi lokal:
```env
APP_NAME=KerjaKita
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kerjakita
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

3. Generate application key:
```bash
php artisan key:generate
```

### Langkah 4: Setup Database

1. Buat database baru di MySQL:
```sql
CREATE DATABASE kerjakita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import database dari file SQL:
```bash
# Via phpMyAdmin:
# - Buka phpMyAdmin
# - Pilih database 'kerjakita'
# - Tab 'Import', pilih file sql/kerjakita.sql
# - Klik 'Go'

# Atau via command line:
mysql -u root -p kerjakita < sql/kerjakita.sql
```

### Langkah 5: Setup Storage

```bash
# Buat symlink untuk storage public
php artisan storage:link

# Pastikan folder storage dan bootstrap/cache writable
chmod -R 775 storage bootstrap/cache
```

### Langkah 6: Build Assets (Opsional)

```bash
# Development mode
npm run dev

# Production build
npm run build
```

### Langkah 7: Jalankan Aplikasi

```bash
# Menggunakan Laravel development server
php artisan serve

# Aplikasi akan berjalan di http://localhost:8000

# Atau menggunakan XAMPP/WAMP
# Akses melalui http://localhost/KerjaKita/public
```

---

## Panduan Penggunaan

### Untuk Pemberi Kerja

#### 1. Registrasi & Login

1. Buka aplikasi di browser: `http://localhost:8000`
2. Klik **"Daftar"** atau **"Register"**
3. Isi formulir registrasi:
   - Nama Lengkap
   - Username (unik)
   - Email (valid & unik)
   - Password (minimal 6 karakter)
   - Konfirmasi Password
   - Jenis Kelamin
   - **Pilih Tipe User: "Pemberi Kerja"**
   - Alamat (opsional)
   - No. HP (opsional)
4. Klik **"Daftar"**
5. Setelah berhasil, login dengan username dan password

#### 2. Melengkapi Profil

1. Setelah login, klik **"Profil"** di navbar
2. Klik **"Edit Profil"**
3. Lengkapi informasi:
   - Nama Perusahaan
   - Alamat Lengkap
   - No. Telepon
   - Upload Foto Profil (opsional)
4. Klik **"Simpan"**

#### 3. Membuat Lowongan Pekerjaan

1. Di dashboard, klik **"Buat Lowongan"** atau menu **"Lowongan Saya"** > **"Buat Baru"**
2. Isi formulir lowongan:
   - **Judul**: Nama pekerjaan (contoh: "Developer Backend PHP")
   - **Deskripsi**: Detail pekerjaan, requirement, dll
   - **Lokasi**: Lokasi pekerjaan (contoh: "Bandung", "Jakarta", "Remote")
   - **Upah**: Masukkan angka (contoh: 1500000)
   - **Kategori**: Pilih kategori yang sesuai (opsional)
   - **Gambar**: Upload gambar terkait pekerjaan (opsional, max 5MB)
   - **Status**: 
     - Pilih **"Aktif"** untuk langsung publikasi
     - Pilih **"Draft"** untuk simpan dulu, publikasi nanti
3. Klik **"Simpan Lowongan"** atau **"Publikasikan"**

**Catatan**: Format upah otomatis diformat ke Rupiah di frontend

#### 4. Mengelola Lowongan

**Melihat Lowongan:**
1. Klik menu **"Lowongan Saya"**
2. Anda akan melihat daftar semua lowongan dengan status:
   - **Aktif**: Lowongan yang sedang tayang
   - **Draft**: Lowongan yang belum dipublikasi
   - **Tidak Aktif**: Lowongan yang sudah ditutup (ada pekerja yang diterima)

**Publikasi Draft:**
1. Pada lowongan berstatus "Draft"
2. Klik tombol **"Publikasikan"**
3. Lowongan akan aktif dan terlihat oleh pekerja

**Edit Lowongan:**
1. Klik tombol **"Edit"** pada lowongan
2. Ubah informasi yang diperlukan
3. Klik **"Update"**

#### 5. Melihat & Mengelola Pelamar

1. Di halaman **"Lowongan Saya"**, klik tombol **"Lihat Pelamar"** pada lowongan
2. Anda akan melihat daftar semua pelamar dengan informasi:
   - Nama pekerja
   - Rating rata-rata (bintang)
   - Jumlah ulasan
   - Keahlian
   - Pengalaman
   - Kontak
   - Status lamaran (Pending/Diterima/Ditolak)
3. Pelamar diurutkan: Pending > Diterima > Ditolak

**Melihat Profil Lengkap Pelamar:**
1. Klik nama pelamar atau tombol **"Lihat Profil"**
2. Anda dapat melihat:
   - Rating dan ulasan dari pemberi kerja lain
   - Riwayat pekerjaan yang pernah diselesaikan
   - Keahlian dan pengalaman detail
   - Informasi kontak

#### 6. Menerima/Menolak Pelamar

**Menerima Pelamar:**
1. Di halaman pelamar, klik tombol **"Terima"** pada pelamar pilihan
2. Konfirmasi keputusan Anda
3. Sistem akan otomatis:
   - Mengubah status lamaran menjadi "Diterima"
   - Membuat record pekerjaan baru dengan status "Berjalan"
   - Menutup lowongan (status menjadi "Tidak Aktif")
   - Menolak semua pelamar lainnya secara otomatis
   - Mengirim notifikasi ke semua pelamar

**Menolak Pelamar:**
1. Klik tombol **"Tolak"** pada pelamar
2. Status lamaran berubah menjadi "Ditolak"
3. Pekerja akan menerima notifikasi penolakan

**Catatan Penting**: Satu lowongan hanya bisa memilih SATU pekerja. Setelah Anda menerima satu pelamar, lowongan otomatis ditutup.

#### 7. Mengelola Pekerjaan yang Sedang Berjalan

1. Klik menu **"Konfirmasi Pekerja"**
2. Anda akan melihat dua tab:
   - **Menunggu Konfirmasi**: Pekerja yang diterima tapi belum dikonfirmasi mulai bekerja
   - **Sedang Dikerjakan**: Pekerjaan yang sedang berjalan dengan progress bar

**Konfirmasi Mulai Pekerjaan:**
1. Di tab "Menunggu Konfirmasi"
2. Klik **"Konfirmasi Mulai"** setelah pekerja siap mulai
3. Pekerjaan akan pindah ke tab "Sedang Dikerjakan"

#### 8. Menyelesaikan Pekerjaan & Memberikan Rating

**Konfirmasi Selesai:**
1. Setelah pekerjaan selesai, klik tombol **"Tandai Selesai"** pada pekerjaan
2. Anda akan diarahkan ke halaman pemberian rating

**Memberikan Rating:**
1. Isi formulir rating:
   - **Rating Bintang**: 1-5 bintang (klik bintang untuk memilih)
   - **Detail Penilaian**:
     - Kualitas Pekerjaan (1-5)
     - Ketepatan Waktu (1-5)
     - Komunikasi (1-5)
     - Inisiatif (1-5)
   - **Ulasan**: Tulis review detail tentang pekerja
   - **Bersedia Bekerja Lagi?**: Ya/Tidak/Tidak Yakin
2. Klik **"Kirim Rating"**
3. Rating tidak bisa diubah setelah dikirim
4. Pekerja akan menerima notifikasi rating

**Catatan**: Rating sangat penting untuk membantu pekerja membangun reputasi mereka!

#### 9. Melihat Notifikasi

1. Klik ikon notifikasi (Bell) di navbar
2. Anda akan melihat notifikasi tentang:
   - Pelamar baru untuk lowongan Anda
   - Pekerjaan yang selesai
   - Rating yang Anda berikan terkirim
3. Notifikasi yang belum dibaca ditandai dengan badge merah

**Menghapus Semua Notifikasi:**
1. Di halaman notifikasi, klik **"Hapus Notifikasi"**
2. Semua notifikasi akan dihapus

---

### Untuk Pekerja

#### 1. Registrasi & Login

1. Buka aplikasi: `http://localhost:8000`
2. Klik **"Daftar"** atau **"Register"**
3. Isi formulir registrasi:
   - Nama Lengkap
   - Username (unik)
   - Email (valid & unik)
   - Password (minimal 6 karakter)
   - Konfirmasi Password
   - Jenis Kelamin
   - **Pilih Tipe User: "Pekerja"**
   - Alamat (opsional)
   - No. HP (opsional)
4. Klik **"Daftar"**
5. Login dengan username dan password

#### 2. Melengkapi Profil

1. Klik menu **"Profil"** di navbar
2. Klik **"Edit Profil"**
3. Lengkapi informasi:
   - Nama Lengkap
   - Usia (minimal 17 tahun)
   - Alamat
   - No. Telepon
   - Upload Foto Profil (JPEG, PNG, max 2MB)
4. Klik **"Simpan Profil"**

#### 3. Menambahkan Keahlian

Keahlian penting untuk meningkatkan peluang diterima!

1. Di halaman profil, scroll ke bagian **"Keahlian"**
2. Klik tombol **"+ Tambah Keahlian"**
3. Masukkan keahlian (contoh: "PHP", "Desain Grafis", "Tukang Bangunan")
4. Klik **"Tambah"**
5. Keahlian akan muncul di profil Anda
6. Ulangi untuk menambah keahlian lainnya

**Catatan**: Keahlian disimpan dalam format comma-separated (PHP,JavaScript,MySQL)

#### 4. Mencari Lowongan Pekerjaan

**Melalui Dashboard:**
1. Login sebagai pekerja
2. Dashboard akan langsung menampilkan daftar lowongan aktif
3. Setiap kartu lowongan menampilkan:
   - Judul pekerjaan
   - Deskripsi singkat
   - Lokasi
   - Upah (dalam format Rupiah)
   - Gambar lowongan (jika ada)

**Melalui Menu Cari Pekerjaan:**
1. Klik menu **"Cari Pekerjaan"**
2. Gunakan filter pencarian (jika tersedia):
   - Kata kunci
   - Kategori
   - Lokasi
   - Range upah

#### 5. Melihat Detail Lowongan

1. Klik tombol **"Lihat Detail"** atau klik pada kartu lowongan
2. Anda akan melihat informasi lengkap:
   - Judul pekerjaan
   - Deskripsi detail
   - Lokasi
   - Upah yang ditawarkan
   - Kategori
   - Nama perusahaan/pemberi kerja
   - Kontak pemberi kerja
   - Gambar lowongan (jika ada)
3. Status: Apakah Anda sudah melamar atau belum

#### 6. Melamar Pekerjaan

1. Di halaman detail lowongan
2. Klik tombol **"Lamar Sekarang"**
3. Sistem akan otomatis mengirim lamaran
4. Anda akan melihat pesan sukses
5. Tombol berubah menjadi **"Sudah Dilamar"** (disabled)
6. Pemberi kerja akan menerima notifikasi pelamar baru

**Catatan**: 
- Anda tidak bisa melamar lowongan yang sama dua kali
- Pastikan profil dan keahlian sudah diisi sebelum melamar untuk meningkatkan peluang diterima

#### 7. Melihat Status Lamaran

1. Klik menu **"Lamaran Saya"**
2. Anda akan melihat dua tab:
   - **Menunggu Konfirmasi**: Lamaran dengan status Pending
   - **Sedang Dikerjakan**: Pekerjaan yang diterima dan sedang berjalan

**Tab "Menunggu Konfirmasi":**
- Menampilkan semua lamaran yang statusnya "Pending"
- Informasi: Judul pekerjaan, perusahaan, lokasi, upah, tanggal melamar
- Tunggu pemberi kerja mereview lamaran Anda

**Tab "Sedang Dikerjakan":**
- Menampilkan pekerjaan yang lamarannya diterima
- Informasi: Judul pekerjaan, perusahaan, tanggal mulai, status
- Anda bisa melihat progress pekerjaan

#### 8. Mengelola Pekerjaan yang Diterima

1. Ketika lamaran diterima, Anda akan menerima **notifikasi**
2. Pekerjaan akan muncul di tab **"Sedang Dikerjakan"**
3. Hubungi pemberi kerja untuk koordinasi detail pekerjaan
4. Kerjakan pekerjaan sesuai kesepakatan

**Catatan**: Pemberi kerja yang akan mengonfirmasi pekerjaan selesai, bukan pekerja.

#### 9. Melihat Rating & Review

**Melihat Rating Anda:**
1. Klik menu **"Profil"**
2. Di bagian atas profil, Anda akan melihat:
   - Rating rata-rata (dari 5.0)
   - Jumlah total rating yang diterima
3. Scroll ke bawah untuk melihat:
   - **Pengalaman Kerja**: Riwayat pekerjaan yang sudah diselesaikan
   - **Ulasan Terbaru**: Review dari pemberi kerja

**Detail Ulasan:**
Setiap ulasan menampilkan:
- Nama pemberi kerja
- Judul pekerjaan
- Rating bintang (1-5)
- Tanggal ulasan
- Komentar/review detail

**Manfaat Rating Tinggi:**
- Meningkatkan kredibilitas Anda
- Pemberi kerja lebih tertarik menerima Anda
- Membangun portofolio kerja yang kuat

#### 10. Melihat Notifikasi

1. Klik ikon notifikasi (Bell) di navbar
2. Badge merah menunjukkan jumlah notifikasi belum dibaca
3. Jenis notifikasi yang bisa Anda terima:
   - **Lamaran Diterima**: Selamat! Lamaran Anda diterima
   - **Lamaran Ditolak**: Lamaran belum diterima (tetap semangat!)
   - **Pekerjaan Selesai**: Pemberi kerja menandai pekerjaan selesai
   - **Rating Baru**: Anda menerima rating dari pemberi kerja

**Mengelola Notifikasi:**
- Klik **"Hapus Notifikasi"** untuk menghapus semua notifikasi
- Atau tunggu, notifikasi lama akan otomatis terhapus setelah waktu tertentu

---

## Fitur Lanjutan

### 1. Sistem Kategori Pekerjaan

Aplikasi memiliki kategori bawaan:
1. **Cleaning** - Pekerjaan kebersihan
2. **Konstruksi** - Tukang bangunan, renovasi
3. **Asisten Rumah Tangga** - Memasak, mengurus rumah
4. **Tukang Kebun** - Perawatan taman
5. **Angkut Barang** - Pindahan
6. **Perbaikan** - Service AC, elektronik
7. **Jaga Toko** - Menjaga toko/warung
8. **Cuci Kendaraan** - Mencuci motor/mobil
9. **Digital** - Desain, programming, dll

**Menambah Kategori Baru:**
1. Akses database via phpMyAdmin
2. Buka tabel `kategori`
3. Insert data baru dengan format:
```sql
INSERT INTO kategori (nama_kategori, deskripsi) 
VALUES ('Nama Kategori', 'Deskripsi kategori');
```

### 2. Activity Log

Sistem mencatat semua aktivitas penting:
- Login/Logout
- Registrasi user baru
- Pembuatan lowongan
- Lamaran dikirim
- Pekerjaan selesai

**Melihat Log:**
1. Akses database > tabel `activity_log`
2. Kolom yang dicatat:
   - `idUser`: User yang melakukan aktivitas
   - `activity_type`: Jenis aktivitas
   - `description`: Deskripsi detail
   - `ip_address`: IP address user
   - `created_at`: Waktu aktivitas

### 3. Database Views untuk Reporting

**View yang tersedia:**

**v_lowongan_detail:** Lowongan dengan detail lengkap
```sql
SELECT * FROM v_lowongan_detail WHERE status = 'aktif';
```

**v_rating_pekerja:** Agregat rating per pekerja
```sql
SELECT * FROM v_rating_pekerja ORDER BY rating_average DESC;
```

**v_rating_pemberi_kerja:** Agregat rating per pemberi kerja
```sql
SELECT * FROM v_rating_pemberi_kerja ORDER BY rating_average DESC;
```

### 4. Pencarian Lowongan dengan Stored Procedure

```sql
CALL sp_cari_lowongan('keyword', 'lokasi', id_kategori, limit, offset);

-- Contoh:
CALL sp_cari_lowongan('developer', 'bandung', NULL, 10, 0);
```

---

## Akun Demo untuk Testing

Untuk testing, database sudah menyediakan akun demo:

### Pemberi Kerja

| Username | Password | Nama | Perusahaan |
|----------|----------|------|------------|
| `john_doe` | `password` | John Doe | PT Maju Jaya |
| `ahmad_rizki` | `password` | Ahmad Rizki | CV Sejahtera |
| `bayangan_gwehhh` | `password` | Pramudya | Pramudya |

### Pekerja

| Username | Password | Nama | Keahlian |
|----------|----------|------|----------|
| `jane_smith` | `password` | Jane Smith | Cleaning, Tukang Bangunan |
| `siti_nurhaliza` | `password` | Siti Nurhaliza | Memasak, Mengasuh Anak |
| `Bhadriko` | `password` | Bhadriko Theo | Front-End Dev, Bongkar PC |

**Catatan**: Password default adalah `password` (atau sesuai hash di database)

---

## Struktur Folder Project

```
KerjaKita/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controller MVC
│   │   │   ├── AuthController.php         # Login, Register, Logout
│   │   │   ├── PekerjaController.php      # Fitur untuk Pekerja
│   │   │   ├── PemberiKerjaController.php # Fitur untuk Pemberi Kerja
│   │   │   ├── LamaranController.php      # Manajemen Lamaran
│   │   │   ├── LowonganController.php     # Manajemen Lowongan
│   │   │   ├── PekerjaanController.php    # Manajemen Pekerjaan
│   │   │   ├── RatingController.php       # Sistem Rating
│   │   │   └── NotifikasiController.php   # Sistem Notifikasi
│   │   └── Middleware/           # Custom middleware
│   │
│   └── Models/                   # Eloquent Models
│       └── User.php              # Model User
│
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
│
├── public/
│   ├── index.php                 # Entry point
│   └── storage/                  # Symlink ke storage (foto, gambar)
│       ├── profil/               # Foto profil user
│       └── lowongan/             # Gambar lowongan
│
├── resources/
│   └── views/                    # Blade templates
│       ├── auth/                 # Login, Register
│       ├── pekerja/              # Views untuk Pekerja
│       ├── pemberi-kerja/        # Views untuk Pemberi Kerja
│       ├── layouts/              # Layout templates
│       └── welcome.blade.php     # Landing page
│
├── routes/
│   └── web.php                   # Definisi routes
│
├── sql/
│   └── kerjakita.sql             # Database dump
│
├── storage/
│   ├── app/
│   │   └── public/               # File storage
│   └── logs/                     # Application logs
│
├── .env                          # Environment configuration
├── composer.json                 # PHP dependencies
├── package.json                  # Frontend dependencies
└── README.md                     # File ini
```

---

## Troubleshooting

### Error: "No application encryption key has been specified"

**Solusi:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [1045] Access denied"

**Solusi:**
- Cek konfigurasi database di file `.env`
- Pastikan username dan password MySQL benar
- Pastikan database `kerjakita` sudah dibuat

### Error: Storage symlink tidak bekerja

**Solusi:**
```bash
# Hapus symlink lama (jika ada)
rm public/storage

# Buat ulang symlink
php artisan storage:link
```

### Gambar tidak muncul setelah upload

**Solusi:**
1. Cek folder `storage/app/public` sudah dibuat
2. Cek symlink `public/storage` mengarah ke `storage/app/public`
3. Pastikan permission folder storage writable:
```bash
chmod -R 775 storage
```

### Error: "Class 'name' not found"

**Solusi:**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerate autoload
composer dump-autoload
```

### Layout/CSS tidak muncul atau berantakan

**Solusi:**
1. Pastikan sudah run `npm install`
2. Build assets:
```bash
npm run dev
# atau
npm run build
```

### Port 8000 sudah digunakan

**Solusi:**
```bash
# Gunakan port lain
php artisan serve --port=8080

# Akses via http://localhost:8080
```

### Database import error (trigger/procedure)

**Solusi:**
- Import ulang dengan setting DELIMITER
- Atau disable trigger dulu, import, enable lagi:
```sql
SET FOREIGN_KEY_CHECKS=0;
-- import SQL
SET FOREIGN_KEY_CHECKS=1;
```

---

## Catatan Pengembangan

### Fitur yang Bisa Dikembangkan

1. Chat System - Real-time chat antara pemberi kerja dan pekerja
2. Favorit - Pekerja bisa bookmark lowongan
3. Payment Gateway - Integrasi pembayaran
4. Advanced Search - Filter lebih detail (range upah, rating minimum)
5. Recommendation System - ML-based recommendation
6. Multi-language - Support bahasa Inggris
7. Mobile App - Flutter/React Native version
8. Verification System - KYC untuk user
9. Portfolio Upload - Pekerja upload portofolio file (PDF, gambar)
10. Contract/Agreement - Digital contract signing

### Best Practices yang Diterapkan

- MVC Architecture
- Database normalization
- Eloquent ORM untuk relasi database
- Blade templating untuk reusable components
- CSRF protection
- Password hashing (bcrypt)
- File upload validation
- Database transactions untuk operasi kompleks
- Middleware untuk authorization
- Activity logging
- Responsive design

---

## Kontribusi

Project ini dikembangkan untuk tujuan edukasi. Jika Anda ingin berkontribusi:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## Lisensi

Project ini menggunakan lisensi **MIT License**. Anda bebas untuk:
- Menggunakan secara komersial
- Memodifikasi
- Mendistribusikan
- Penggunaan pribadi

Dengan ketentuan menyertakan lisensi dan copyright notice.

---

## Developer

**KerjaKita** dikembangkan menggunakan Laravel Framework.

### Tim Pengembang
- Backend Developer - Laravel + MySQL
- Frontend Developer - Blade + TailwindCSS
- Database Designer - MySQL Schema Design

### Kontak
- Email: support@kerjakita.app
- Website: https://kerjakita.app

---

## Ucapan Terima Kasih

Terima kasih kepada:
- **Laravel Framework** - Framework PHP yang powerful
- **TailwindCSS** - Utility-first CSS framework
- **MySQL/MariaDB** - Reliable database system
- **PHP Community** - Dokumentasi dan support yang luar biasa

---

## Referensi & Dokumentasi

- [Laravel Documentation](https://laravel.com/docs/12.x)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [Blade Templates](https://laravel.com/docs/12.x/blade)
- [Eloquent ORM](https://laravel.com/docs/12.x/eloquent)

---

## Update History

### Version 1.0.0 (Current)
- Sistem autentikasi (Login, Register, Logout)
- Manajemen lowongan untuk pemberi kerja
- Pencarian dan lamaran pekerjaan untuk pekerja
- Sistem rating dan review
- Notifikasi real-time
- Upload gambar (profil & lowongan)
- Dashboard dengan statistik
- Activity logging
- Database views dan stored procedures
- Responsive design

---

**Selamat Menggunakan KerjaKita!**

Jika ada pertanyaan atau masalah, jangan ragu untuk membuka issue atau menghubungi tim developer.

**Happy Coding!**
