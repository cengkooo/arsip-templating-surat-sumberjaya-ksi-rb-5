# 📋 Panduan Instalasi
## Sistem Arsip & Template Surat Sumber Jaya

---

## 📌 Persyaratan Sistem

Sebelum memulai instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

### Software yang Dibutuhkan:
- **PHP** >= 8.2
- **Composer** (dependency manager PHP)
- **MySQL** >= 8.0 atau **MariaDB** >= 10.3
- **Node.js** >= 18.x (opsional, untuk development)
- **Git** (untuk clone repository)

### Extension PHP yang Diperlukan:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD
- ZIP

---

## 🚀 Langkah Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/cengkooo/arsip-templating-surat-sumberjaya-ksi-rb-5.git
cd arsip-templating-surat-sumberjaya-ksi-rb-5
```

### 2. Install Dependencies

```bash
composer install
```

**Catatan:** Proses ini akan menginstal semua package PHP yang dibutuhkan termasuk:
- Laravel Framework
- Filament Admin Panel
- DomPDF (untuk generate PDF)
- Laravel Trend (untuk chart dashboard)

### 3. Konfigurasi Environment

```bash
# Copy file .env.example menjadi .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=password_anda
```

**Buat database baru:**
```sql
CREATE DATABASE nama_database_anda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Migrasi Database & Seeding

```bash
# Jalankan migrasi dan seeder
php artisan migrate:fresh --seed
```

**Apa yang terjadi:**
- Membuat tabel database (users, arsip_surats, template_surats, kategoris, desa_settings)
- Membuat user default
- Membuat kategori "Umum"
- Membuat 2 template contoh (SKTM & Domisili)

### 6. Storage Link

```bash
# Buat symbolic link untuk storage public
php artisan storage:link
```

Ini diperlukan agar logo desa dapat diakses melalui browser.

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

Admin panel: **http://127.0.0.1:8000/admin**

---

## 👤 Login Default

Setelah seeding, Anda bisa login dengan:

- **Email:** `admindesa@sumberjaya.com`
- **Password:** `password`

**⚠️ PENTING:** Segera ubah email dan password default setelah login pertama!

---

## 🎨 Konfigurasi Awal

### 1. Pengaturan Desa

Setelah login, masuk ke menu **"Pengaturan Desa"** untuk mengisi:
- Nama Provinsi, Kabupaten, Kecamatan, Desa
- Alamat lengkap
- Kontak (telepon, email, website)
- Upload logo desa
- Data kepala desa & pamong penandatangan

### 2. Upload Logo Desa

1. Menu **Pengaturan Desa** → Edit
2. Bagian **"Logo Desa"**
3. Klik **"Choose file"** → Pilih file logo (PNG/JPG, max 2MB)
4. Klik **"Save"**

Logo akan muncul di kop surat PDF yang di-generate.

### 3. Kelola Template Surat

Sistem sudah menyediakan 2 template contoh:
- **Surat Keterangan Tidak Mampu (SKTM)**
- **Surat Keterangan Domisili**

Anda bisa:
- Menggunakan template yang ada
- Membuat template baru dari menu **Template Surat**
- Edit template sesuai kebutuhan desa

---

## 📊 Fitur Utama Dashboard

Setelah login, Anda akan melihat dashboard dengan:

### Row 1 - Statistik (4 Cards)
- Total Surat
- Total Arsip
- Total Template
- Surat Pending

### Row 2 - Chart
- Surat per Bulan (line chart)
- Penggunaan Template (bar chart)

### Row 3 - Activity Table
- Surat Terbaru (5 surat terakhir)

### Row 4 - Shortcut Buttons
- **Buat Surat Baru** (biru)
- **Tambah Template** (kuning)
- **Upload Arsip** (hijau)

---

## 📝 Cara Membuat Surat

### Metode 1: Dari Template

1. Menu **Arsip Surat** → **"Buat dari Template"**
2. Pilih template surat
3. Isi data sesuai form yang muncul
4. Klik **"Simpan"**
5. PDF otomatis ter-generate

### Metode 2: Upload Manual

1. Menu **Arsip Surat** → **"Tambah"**
2. Upload file surat yang sudah ada
3. Isi metadata (nomor, tanggal, perihal, dll)
4. Klik **"Simpan"**

---

## 🔧 Troubleshooting

### Widget Dashboard Tidak Muncul

```bash
php artisan optimize:clear
php artisan view:clear
# Restart browser atau clear cache browser
```

### PDF Tidak Ter-generate

1. Pastikan storage link sudah dibuat:
   ```bash
   php artisan storage:link
   ```

2. Cek permission folder storage:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

### Logo Tidak Muncul di PDF

1. Pastikan logo sudah diupload di **Pengaturan Desa**
2. Pastikan storage link sudah dibuat
3. Cek setting template: **"Tampilkan Logo"** harus dicentang

### Error "Class not found"

```bash
composer dump-autoload
php artisan optimize:clear
```

---

## 🔄 Update Aplikasi

Jika ada update dari repository:

```bash
# Pull update terbaru
git pull origin main

# Update dependencies
composer install

# Jalankan migrasi baru (jika ada)
php artisan migrate

# Seed data baru (jika ada template/kategori baru)
php artisan db:seed

# Clear cache
php artisan optimize:clear
```

---

## 📚 Dokumentasi Lengkap

Dokumentasi lebih detail tersedia di:

- **README.md** - Overview aplikasi
- **TUTORIAL-LENGKAP.md** - Tutorial penggunaan lengkap
- **PANDUAN-PENGATURAN-DESA.md** - Setup konfigurasi desa
- **PANDUAN-UPLOAD-LOGO.md** - Cara upload dan troubleshoot logo
- **PANDUAN-CUSTOM-KOP-SURAT.md** - Customize kop surat
- **PANDUAN-EDITOR-ADVANCED.md** - Editor template advanced
- **SPESIFIKASI-VARIABLE-FORM.md** - Daftar variable yang tersedia

---

## 🛡️ Keamanan

### Untuk Production:

1. **Ubah APP_ENV** di `.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Generate APP_KEY baru:**
   ```bash
   php artisan key:generate
   ```

3. **Ubah kredensial database default**

4. **Setup HTTPS** (gunakan Nginx/Apache + SSL Certificate)

5. **Backup rutin database:**
   ```bash
   # Manual backup
   php artisan backup:run

   # Atau via cron job
   mysqldump -u username -p database_name > backup.sql
   ```

---

## 🆘 Support

Jika mengalami kesulitan:

1. Cek dokumentasi di folder proyek
2. Buka issue di GitHub: https://github.com/cengkooo/arsip-templating-surat-sumberjaya-ksi-rb-5/issues
3. Lihat log error di `storage/logs/laravel.log`

---

## 📄 Lisensi

Aplikasi ini dikembangkan untuk Desa Sumber Jaya, Kecamatan Jati Agung, Kabupaten Lampung Selatan.

---

**Selamat menggunakan Sistem Arsip & Template Surat Sumber Jaya! 🎉**

*Dibuat dengan ❤️ menggunakan Laravel & Filament*
