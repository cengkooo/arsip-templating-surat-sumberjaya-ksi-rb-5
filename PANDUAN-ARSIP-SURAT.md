# 📁 Panduan Penggunaan Arsip Surat

## 🎯 Fitur Utama

Menu **Arsip Surat** menggabungkan 2 fungsi dalam 1 tempat:

### 1. 📝 Buat Surat dari Template (Auto Generate PDF)
- **Tombol:** Hijau "Buat Surat dari Template"
- **Fungsi:** Membuat surat baru dari template yang sudah dibuat
- **Proses:**
  1. Pilih template yang tersedia
  2. Isi nomor surat, tanggal, dan perihal
  3. Isi data variable sesuai template (otomatis muncul berdasarkan template)
  4. Isi data penandatangan (opsional, akan pakai default dari Pengaturan Desa jika kosong)
  5. Klik Simpan
  6. **PDF otomatis terbuat** dan tersimpan di arsip
  7. Status otomatis menjadi "Selesai"

### 2. 📤 Tambah Surat Manual
- **Tombol:** Abu-abu "Tambah Surat Manual"
- **Fungsi:** Input surat yang sudah ada sebelumnya (scan/dokumen existing)
- **Proses:**
  1. Isi form manual (kategori, jenis, nomor, tanggal, perihal, dll)
  2. Upload file surat (PDF/gambar/DOC)
  3. Klik Simpan
  4. Surat tersimpan di arsip tanpa generate PDF

---

## 🔄 Workflow Generate Surat dari Template

```
Template Surat
    ↓
Pilih Template → Isi Form Dinamis → Generate PDF → Simpan ke Arsip
```

### Variable yang Tersedia

Saat membuat template, Anda bisa menggunakan variable:

**📍 Dari Pengaturan Desa:**
- `{{nama_desa}}`, `{{kode_desa}}`
- `{{nama_kecamatan}}`, `{{kode_kecamatan}}`
- `{{nama_kabupaten}}`, `{{kode_kabupaten}}`
- `{{nama_provinsi}}`, `{{kode_provinsi}}`
- `{{alamat_desa}}`, `{{kode_pos}}`
- `{{telepon_desa}}`, `{{email_desa}}`, `{{website_desa}}`
- `{{nama_kepala_desa}}`, `{{nip_kepala_desa}}`
- Dan lainnya...

**🔧 Variable Sistem:**
- `{{nomor_surat}}` - Nomor surat yang diisi user
- `{{tanggal_surat}}` - Tanggal surat yang diisi user
- `{{perihal}}` - Perihal surat

**✏️ Variable Custom:**
- Variable yang Anda buat sendiri di template
- Contoh: `{{nama_pemohon}}`, `{{nik}}`, `{{alamat}}`, dll
- Form akan otomatis muncul untuk isi variable ini

### Penandatangan

Data penandatangan akan diambil dari:
1. **Prioritas 1:** Data yang diisi di form (jika diisi)
2. **Prioritas 2:** Data default dari Pengaturan Desa (Pamong TTD Default)

Variable penandatangan di template:
- `{{nama_penandatangan}}`
- `{{jabatan_penandatangan}}`
- `{{nip_penandatangan}}`

---

## 🎨 Kop Surat Otomatis

Setiap PDF yang digenerate akan memiliki **KOP SURAT** otomatis dari **Pengaturan Desa**:

✅ Logo Desa (jika sudah diupload)
✅ Nama Kabupaten
✅ Nama Kecamatan  
✅ Nama Desa
✅ Alamat lengkap
✅ Kontak (Telepon, Email, Website)
✅ Border profesional

Kop surat ini **TIDAK PERLU DITULIS** di template, sistem akan menambahkan otomatis!

---

## 📋 Status Surat

- **Draft:** Surat masih draft, belum final
- **Terkirim:** Surat sudah dikirim ke penerima
- **Diarsipkan:** Surat sudah diarsipkan
- **Selesai:** Surat yang digenerate dari template (otomatis)

---

## 🔍 Fitur View Arsip Surat

Saat melihat detail arsip surat, tersedia tombol:

### ✅ Untuk Surat dari Template:
- **Generate Ulang PDF** (biru) - Generate ulang jika ada perubahan template/data
- **Edit** - Ubah data surat
- **Download File** - Download PDF
- **Cetak** - Cetak PDF
- **Hapus** - Hapus arsip

### ✅ Untuk Surat Manual:
- **Edit** - Ubah data surat
- **Download File** - Download file yang diupload
- **Cetak** - Cetak file
- **Hapus** - Hapus arsip

---

## 💡 Tips Penggunaan

### ⚡ Generate Surat dari Template
**Kapan digunakan:**
- Surat keluar yang sering dibuat (SK, undangan, keterangan, dll)
- Membutuhkan format profesional dengan kop surat
- Ingin konsistensi format
- Ingin otomatis jadi PDF

**Keuntungan:**
- ⚡ Cepat, tinggal isi data
- 🎨 Otomatis profesional dengan kop surat
- 📄 Langsung jadi PDF
- ✅ Konsisten formatnya

### 📝 Input Manual
**Kapan digunakan:**
- Surat masuk dari pihak lain
- Scan surat lama
- Dokumen yang sudah jadi
- Tidak perlu generate baru

**Keuntungan:**
- 📂 Upload file existing
- 📥 Simpan surat masuk
- 🗃️ Arsip dokumen lama

---

## ⚠️ Catatan Penting

1. **Template harus dibuat dulu** di menu **Template Surat**
2. **Pengaturan Desa harus diisi** untuk kop surat yang lengkap
3. **Logo Desa** opsional, tapi disarankan diupload untuk tampilan profesional
4. **Generate Ulang PDF** akan menimpa file PDF lama
5. **Variable di template** harus match dengan yang diisi di form

---

## 🚀 Quick Start

### Buat Surat Pertama Kali:

1. **Setup Pengaturan Desa** (Master Data → Pengaturan Desa)
   - Isi semua data desa
   - Upload logo (opsional)

2. **Buat Template** (Master Data → Template Surat)
   - Buat template baru
   - Tambah variable yang dibutuhkan
   - Aktifkan template

3. **Generate Surat** (Surat → Arsip Surat)
   - Klik "Buat Surat dari Template"
   - Pilih template
   - Isi form
   - Simpan
   - ✅ PDF otomatis jadi!

---

## 📞 Bantuan

Jika ada kendala:
- Pastikan **Pengaturan Desa** sudah terisi lengkap
- Pastikan **Template** sudah aktif
- Cek **variable template** sudah benar
- Gunakan **Generate Ulang PDF** jika PDF tidak sesuai

---

**Versi:** 1.0  
**Terakhir Update:** November 2025
