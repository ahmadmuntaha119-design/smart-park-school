# 🚗 Parkir Pintar — Dokumentasi Teknis Lengkap

> **Untuk Pewaris Proyek:** Dokumen ini adalah panduan terlengkap yang kamu butuhkan untuk memahami, menjalankan, dan mengembangkan aplikasi ini. Baca dari atas ke bawah sebelum menyentuh kode apapun!

---

## 📋 Daftar Isi

1. [Pendahuluan & Tujuan Proyek](#1-pendahuluan--tujuan-proyek)
2. [Tech Stack yang Digunakan](#2-tech-stack-yang-digunakan)
3. [Gaya UI & Panduan Tampilan](#3-gaya-ui--panduan-tampilan)
4. [Skema & Relasi Database](#4-skema--relasi-database)
5. [Peta Navigasi & Struktur Folder](#5-peta-navigasi--struktur-folder)
6. [Cheatsheet Perintah Terminal](#6-cheatsheet-perintah-terminal)

---

## 1. Pendahuluan & Tujuan Proyek

**Parkir Pintar** adalah sistem manajemen parkir berbasis web yang dirancang khusus untuk lingkungan sekolah (SMKN 1 Kebumen).

### Masalah yang Diselesaikan

Sebelum aplikasi ini ada, pengelolaan parkir sekolah menghadapi banyak masalah:

- 🚦 **Kemacetan di gerbang** — Tidak ada sistem antrian atau tiket digital, semua manual.
- ❓ **Tidak ada rekam jejak** — Admin tidak bisa tahu berapa motor yang masuk/keluar setiap hari.
- 🏍️ **Motor parkir sembarangan** — Tidak ada pembagian zona yang tegas per kelas atau per jenis motor.
- 📋 **Absensi tidak efisien** — Proses absensi masuk/keluar motor masih dilakukan manual.
- 🔍 **Barang hilang sulit dilacak** — Tidak ada sistem siaran barang temuan yang terpusat.

### Solusi yang Diberikan Aplikasi Ini

- ✅ Siswa **mendaftar sekali** dengan NIS (yang sudah diverifikasi Admin lewat Whitelist).
- ✅ Setiap hari, siswa **check-in via GPS** saat tiba di sekolah.
- ✅ Admin dapat **memantau real-time** siapa saja yang sedang parkir, di zona mana, dan slot berapa.
- ✅ Admin bisa **mengatur zona parkir** (Zona A, B, C...) dengan aturan khusus per baris (merek, warna, transmisi).
- ✅ Admin bisa **menyiarkan informasi barang temuan** langsung dari dashboard.

---

## 2. Tech Stack yang Digunakan

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | 8.3+ | Bahasa pemrograman utama di sisi server. |
| **Laravel** | 12 | Framework PHP utama. Mengatur routing, database, autentikasi, dan logika bisnis aplikasi. |
| **Tailwind CSS** | 3.x | Framework CSS berbasis *utility-class*. Dipakai untuk menata tampilan langsung dari HTML tanpa menulis file CSS terpisah. |
| **Vite** | 5.x | Bundler aset modern. Bertugas mengompilasi file CSS dan JavaScript agar siap dipakai browser, dan menyediakan *hot-reload* saat development. |
| **Alpine.js** | 3.x | Library JavaScript ringan. Digunakan untuk interaksi UI sederhana seperti dropdown, toggle, dan animasi tanpa harus menulis JavaScript penuh. |
| **Livewire** | 3.x | Disertakan sebagai dependensi, namun logika utama aplikasi saat ini menggunakan *Controller + Blade* biasa (bukan Livewire component). |
| **MySQL** | 8.x | Database relasional untuk menyimpan semua data (pengguna, kendaraan, absensi, dll). |
| **Maatwebsite Excel** | 3.x | Package Laravel untuk membaca dan mengekspor file Excel (.xlsx). Dipakai di fitur import/export NIS Whitelist. |
| **Laragon** | - | *Recommended* environment untuk development lokal di Windows (sudah menyertakan PHP, MySQL, Nginx). |

---

## 3. Gaya UI & Panduan Tampilan

### Filosofi Desain: Dark Monochrome Bento Box

Seluruh antarmuka Admin menggunakan tema **gelap monokromatik** (hitam dan abu-abu). Nama "Bento Box" mengacu pada kartu-kartu kotak yang tertata rapi layaknya kotak bekal Jepang.

### Variabel CSS Global (Warna Utama)

Semua warna didefinisikan sebagai variabel CSS di file layout utama:
`resources/views/components/admin-layout.blade.php`

```css
--sl2:       #1a1a1a;    /* Background kartu/panel */
--on-s:      #ffffff;    /* Teks utama (putih terang) */
--on-v:      #a1a1aa;    /* Teks sekunder (abu-abu) */
--outline-v: rgba(255,255,255,0.08); /* Border halus */
```

> ⚠️ **Aturan Wajib:** Jangan pernah menggunakan warna *hardcoded* seperti `#ffffff` langsung di file Blade. Selalu gunakan variabel CSS di atas (contoh: `style="color: var(--on-s);"`). Ini menjaga konsistensi tema di seluruh aplikasi.

### Komponen yang Bisa Dipakai Ulang (Reusable Components)

Komponen Blade tersimpan di `resources/views/components/`.

| File Komponen | Cara Pakai | Fungsi |
|---|---|---|
| `admin-layout.blade.php` | `<x-admin-layout>` | Layout utama semua halaman Admin (sidebar, header, variabel CSS) |
| `app-layout.blade.php` | `<x-app-layout>` | Layout alternatif (jika ada) |

**Cara membuat halaman Admin baru yang konsisten:**

```blade
<x-admin-layout>
    <x-slot name="title">Judul Halaman Baru</x-slot>

    {{-- Konten halaman kamu di sini --}}
    <div class="rounded-2xl p-5 border" style="background: var(--sl2); border-color: var(--outline-v);">
        <h3 style="color: var(--on-s);">Judul Kartu</h3>
        <p style="color: var(--on-v);">Isi konten...</p>
    </div>

</x-admin-layout>
```

### Pola Desain Standar

- **Kartu/Panel** → `rounded-2xl border` dengan `background: var(--sl2)` dan `border-color: var(--outline-v)`
- **Tombol Utama** → `background: #ffffff; color: #000000;` (putih tegas)
- **Tombol Bahaya** → `border-color: rgba(239,68,68,0.2); color: #ef4444;` (merah transparan)
- **Badge Sukses** → `background: rgba(16,185,129,0.1); color: #34d399;` (hijau)
- **Input Form** → `background: rgba(255,255,255,0.02); border: 1px solid var(--outline-v); color: var(--on-s);`

---

## 4. Skema & Relasi Database

### Gambaran Umum Tabel

Anggap database ini seperti beberapa buku catatan yang saling berkaitan:

```
users ──────────────────────────────────────────────┐
  │ (1 siswa punya 1 motor)                         │
  ├──► kendaraans ──► zona_parkirs ──► baris_parkirs │
  │                                                  │
  ├──► absensi_parkirs (log check-in/out harian)     │
  │                                                  │
nis_whitelists (daftar NIS yang boleh daftar)        │
merek_motors (referensi merek: Honda, Yamaha, dll)   │
barang_temuans (informasi barang hilang/temuan)      │
```

### Detail Tabel

#### 📋 `users` — Data Pengguna (Siswa & Admin)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary Key, auto-increment |
| `nis_nip` | string | NIS (untuk Siswa) atau NIP (untuk Admin PKS). **Harus unik.** |
| `nama_lengkap` | string | Nama lengkap pengguna |
| `password` | string | Password terenkripsi (bcrypt) |
| `role` | enum | `'Admin'` atau `'Siswa'` |
| `kelas` | string | Nama kelas siswa (contoh: XI RPL 1) |
| `is_first_login` | boolean | `true` = wajib ganti password dulu sebelum bisa masuk |

#### 🏍️ `kendaraans` — Data Motor Siswa
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id_user` | FK → `users.id` | Motor ini milik siapa |
| `id_zona` | FK → `zona_parkirs.id` | Motor ini diparkir di zona mana |
| `id_baris` | FK → `baris_parkirs.id` | Tepatnya di baris mana dalam zona |
| `nomor_slot` | integer | Nomor petak parkir (1, 2, 3...) |
| `id_merek` | FK → `merek_motors.id` | Merek motor (Honda, Yamaha, dll) |
| `model_motor` | string | Tipe/model motor (Vario, NMAX, dll) |
| `warna` | string | Warna motor |
| `jenis_transmisi` | enum | `'Matic'` atau `'Manual'` |
| `plat_nomor` | string | Plat nomor. **Harus unik.** |
| `kelas` | string | Kelas pemilik motor (disimpan di sini juga untuk filter cepat) |

#### 🅿️ `zona_parkirs` — Zona Area Parkir
| Kolom | Tipe | Keterangan |
|---|---|---|
| `nama_zona` | string | Nama zona (contoh: A, B, C) |
| `keterangan` | string | Deskripsi zona (opsional) |
| `kode_warna` | string | Kode warna HEX untuk penanda visual (contoh: #3b82f6) |
| `kapasitas_total` | integer | Total slot dihitung otomatis dari semua baris |
| `foto_denah` | string | Path foto denah/peta zona (opsional) |

#### 🛣️ `baris_parkirs` — Baris dalam Zona Parkir
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id_zona` | FK → `zona_parkirs.id` | Baris ini ada di zona mana |
| `nama_baris` | string | Nama baris (contoh: Baris 1, Baris 2) |
| `kapasitas` | integer | Berapa slot yang tersedia di baris ini |
| `syarat_filter` | JSON | **Aturan khusus** baris ini. Contoh: `{"warna": ["Putih", "Silver"], "transmisi": "Matic", "merek": ["Honda"], "tipe": ["Vario"]}` |

#### 📅 `absensi_parkirs` — Log Absensi Harian
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id_user` | FK → `users.id` | Absensi milik siapa |
| `waktu_masuk` | timestamp | Waktu motor masuk area sekolah |
| `waktu_keluar` | timestamp | Waktu motor keluar (null = masih parkir) |
| `jarak_dari_sekolah` | float | Jarak GPS saat check-in (dalam meter) |
| `foto_bukti_masuk` | string | Path foto motor saat check-in (jika diaktifkan) |

#### ✅ `nis_whitelists` — Daftar NIS yang Boleh Mendaftar
| Kolom | Tipe | Keterangan |
|---|---|---|
| `nis` | string | NIS siswa yang diizinkan mendaftar |
| `nama` | string | Nama siswa (dari file Excel import) |
| `sudah_daftar` | boolean | `true` = NIS ini sudah dipakai mendaftar |

> **Alur Keamanan:** Siswa baru **hanya bisa mendaftar** jika NIS-nya sudah ada di tabel ini. Admin harus *import* file Excel dulu sebelum siswa bisa membuat akun.

### Diagram Relasi Singkat

```
nis_whitelists          users (1) ────── kendaraans (1)
   (validasi)             │                  │        │
                          │              zona_parkirs  merek_motors
                          │              baris_parkirs
                          │
                    absensi_parkirs (banyak)
                    barang_temuans (banyak, oleh Admin)
```

---

## 5. Peta Navigasi & Struktur Folder

### Struktur Folder Utama

```
ParkirPintar/
│
├── app/                         ← Otak aplikasi (logika backend)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           ← Semua fitur Admin (Zona, Kendaraan, Absensi, dll)
│   │   │   ├── Auth/            ← Login, Logout, Ganti Password
│   │   │   ├── Registrasi/      ← Proses pendaftaran siswa baru
│   │   │   └── Siswa/           ← Dashboard & Absensi GPS siswa
│   │   └── Middleware/          ← Penjaga akses (cek role, cek login, force password)
│   ├── Models/                  ← Blueprint database (User, Kendaraan, dll)
│   ├── Exports/                 ← Kelas untuk export Excel
│   └── Imports/                 ← Kelas untuk import Excel
│
├── database/
│   ├── migrations/              ← Skrip pembuatan tabel database
│   └── seeders/                 ← Data awal (contoh: akun Admin pertama)
│
├── resources/
│   └── views/                   ← Semua tampilan (HTML/Blade)
│       ├── admin/               ← Halaman-halaman khusus Admin
│       │   ├── dashboard.blade.php
│       │   ├── kendaraan/
│       │   ├── zona/
│       │   ├── whitelist/
│       │   ├── absensi/
│       │   └── lost-found/
│       ├── auth/                ← Halaman Login & Ganti Password
│       ├── siswa/               ← Halaman Dashboard & Panduan Siswa
│       ├── registrasi/          ← Halaman pendaftaran siswa baru
│       ├── components/          ← Komponen layout yang dipakai ulang
│       │   └── admin-layout.blade.php ← ← ← LAYOUT UTAMA ADMIN
│       └── welcome.blade.php    ← Landing page publik
│
├── routes/
│   └── web.php                  ← PETA SEMUA URL aplikasi ini
│
└── public/storage/              ← File yang bisa diakses publik (foto motor, denah)
```

### Panduan "Saya ingin mengubah X, ke mana?"

| Tujuan | Lokasi File |
|---|---|
| Ubah tampilan halaman **login** | `resources/views/auth/login.blade.php` |
| Ubah tampilan **landing page** | `resources/views/welcome.blade.php` |
| Ubah tampilan **sidebar/header Admin** | `resources/views/components/admin-layout.blade.php` |
| Ubah tampilan **dashboard Admin** | `resources/views/admin/dashboard.blade.php` |
| Ubah tampilan halaman **manajemen zona** | `resources/views/admin/zona/` |
| Ubah tampilan **dashboard siswa** | `resources/views/siswa/dashboard.blade.php` |
| Ubah **logika login/logout** | `app/Http/Controllers/Auth/AuthController.php` |
| Ubah **logika zona/baris parkir** | `app/Http/Controllers/Admin/ZonaController.php` |
| Ubah **logika absensi GPS** | `app/Http/Controllers/Siswa/DashboardController.php` |
| Tambah/ubah **rute URL baru** | `routes/web.php` |
| Ubah **struktur tabel** database | Buat file baru di `database/migrations/` |

### Penjelasan File Krusial

#### `routes/web.php`
Ini adalah **peta jalan** aplikasi. Setiap URL yang bisa dikunjungi pengguna terdaftar di sini. Format umumnya:
```php
Route::get('/url-halaman', [NamaController::class, 'namaMethod'])->name('nama.rute');
```
- `get` = untuk halaman yang dibuka (klik link)
- `post` = untuk form yang dikirim (klik submit)
- `delete` = untuk form hapus data
- `->name(...)` = nama alias rute, dipakai di Blade dengan `route('nama.rute')`

#### `app/Http/Middleware/`
Middleware adalah **satpam** yang menjaga akses halaman:
- `Authenticate` → Cek apakah pengguna sudah login
- `CheckRole` → Cek apakah rolenya 'Admin' atau 'Siswa'
- `ForcePasswordChange` → Kalau `is_first_login = true`, paksa ke halaman ganti password

---

## 6. Cheatsheet Perintah Terminal

### 🚀 Setup Pertama Kali (Setelah Clone dari GitHub)

Jalankan perintah-perintah ini **berurutan** setelah download/clone proyek:

```bash
# 1. Masuk ke folder proyek
cd ParkirPintar

# 2. Install semua dependensi PHP (butuh internet, bisa lama)
composer install

# 3. Salin file konfigurasi
cp .env.example .env

# 4. Buka file .env dengan teks editor, lalu isi bagian ini:
#    DB_DATABASE=nama_database_kamu
#    DB_USERNAME=root
#    DB_PASSWORD=        (kosongkan jika pakai Laragon default)

# 5. Generate APP_KEY (kunci keamanan aplikasi)
php artisan key:generate

# 6. Buat semua tabel di database
php artisan migrate

# 7. Isi data awal (akun Admin pertama, merek motor, dll)
php artisan db:seed

# 8. Buat symlink storage agar foto bisa diakses publik
php artisan storage:link

# 9. Install dependensi JavaScript/CSS
npm install

# 10. Jalankan kompilator aset (buka di terminal terpisah, biarkan berjalan)
npm run dev

# 11. Jalankan server PHP (buka di terminal terpisah lainnya)
php artisan serve
```

Setelah langkah 10 dan 11 berjalan, buka browser dan kunjungi: **http://127.0.0.1:8000**

---

### 🔑 Akun Admin Default (Setelah Seeder)

Cek file `database/seeders/DatabaseSeeder.php` untuk melihat kredensial default akun Admin yang dibuat oleh seeder.

---

### 🛠️ Development Sehari-hari

```bash
# Jalankan server pengembangan (2 terminal berbeda)
php artisan serve
npm run dev

# Membuat Model baru sekaligus dengan Migration-nya
php artisan make:model NamaModel -m

# Membuat Controller baru
php artisan make:controller NamaController

# Membuat Migration saja (untuk mengubah tabel yang sudah ada)
php artisan make:migration nama_deskriptif_perubahan

# Menjalankan migration baru yang belum dieksekusi
php artisan migrate

# MEMBATALKAN migration terakhir (hati-hati! data bisa hilang)
php artisan migrate:rollback

# Melihat semua rute yang terdaftar (berguna untuk debugging)
php artisan route:list

# Membersihkan cache aplikasi jika ada perubahan konfigurasi
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### 📦 Menyimpan Perubahan ke GitHub

```bash
# 1. Cek file apa saja yang berubah
git status

# 2. Tandai semua perubahan untuk disimpan
git add .

# 3. Simpan perubahan dengan pesan yang jelas
git commit -m "feat: tambah fitur filter merek pada aturan baris zona"

# 4. Kirim ke GitHub
git push origin main
```

> 💡 **Tips Pesan Commit yang Baik:**
> - `feat:` → Menambah fitur baru
> - `fix:` → Memperbaiki bug
> - `style:` → Perubahan tampilan/UI saja
> - `refactor:` → Merapikan kode tanpa mengubah fitur

---

### 🌐 Deploy ke Production (Server Online)

```bash
# 1. Di server, clone atau pull perubahan terbaru
git pull origin main

# 2. Install dependensi (mode production, tanpa package dev)
composer install --no-dev --optimize-autoloader

# 3. Install dan build aset JavaScript/CSS (untuk production)
npm install
npm run build

# 4. Jalankan migration di server
php artisan migrate --force

# 5. Optimalkan aplikasi untuk kecepatan
php artisan optimize

# 6. Pastikan permission folder storage dan cache benar
chmod -R 775 storage bootstrap/cache
```

> ⚠️ **Sebelum Deploy:** Ubah nilai `APP_ENV=production` dan `APP_DEBUG=false` di file `.env` server agar pesan error tidak terlihat oleh pengguna umum.

---

## 🆘 Troubleshooting Umum

| Masalah | Solusi |
|---|---|
| Halaman tampil error "No application encryption key" | Jalankan `php artisan key:generate` |
| Foto tidak muncul | Jalankan `php artisan storage:link` |
| CSS/JS tidak update | Jalankan `npm run dev` atau `npm run build` |
| Perubahan database tidak muncul | Jalankan `php artisan migrate` |
| Error 419 (CSRF) saat submit form | Pastikan form Blade punya `@csrf` di dalamnya |
| Route tidak ditemukan | Cek `routes/web.php` dan jalankan `php artisan route:list` |
| Perubahan `.env` tidak efektif | Jalankan `php artisan config:clear` |

---

*Dokumentasi ini dibuat pada 2026. Jika ada fitur baru yang ditambahkan, mohon perbarui dokumen ini agar pewaris selanjutnya juga terbantu.* 🙏
