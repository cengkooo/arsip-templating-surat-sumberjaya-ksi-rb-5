# 📚 TUTORIAL LENGKAP - Sistem Arsip & Templating Surat Desa

> **Tutorial step-by-step dari awal sampai cetak PDF**  
> Contoh: Membuat "Surat Keterangan Tidak Mampu"

---

## 📋 Daftar Isi

1. [Setup Awal - Pengaturan Desa](#1-setup-awal---pengaturan-desa)
2. [Buat Kategori Surat](#2-buat-kategori-surat)
3. [Buat Template Surat](#3-buat-template-surat)
4. [Generate Surat dari Template](#4-generate-surat-dari-template)
5. [Download & Cetak PDF](#5-download--cetak-pdf)

---

## 1. Setup Awal - Pengaturan Desa

### 📍 **Lokasi Menu:** Master Data → Pengaturan Desa

### **Langkah-langkah:**

#### **Tab 1: DESA**
```
Nama Desa: KEPALA DESA SUMBER JAYA
Kode Desa: 1871041008

Upload Logo:
- Klik "Browse" atau drag & drop logo desa
- Format: PNG/JPG/JPEG
- Ukuran max: 2MB
- Rasio: 1:1 (persegi) disarankan

Nama Kepala Desa: (Nama kepala desa Anda)
NIP Kepala Desa: 19xxxxxxxx
```

#### **Tab 2: KECAMATAN**
```
Nama Kecamatan: KECAMATAN SIAK KECIL
Kode Kecamatan: 187104

Nama Kepala Camat: (Nama camat)
NIP Kepala Camat: 19xxxxxxxx
```

#### **Tab 3: KABUPATEN**
```
Nama Kabupaten: KABUPATEN BENGKALIS
Kode Kabupaten: 1871

Nama Kepala Kabupaten/Bupati: (Nama bupati)
NIP Kepala Kabupaten: 19xxxxxxxx
```

#### **Tab 4: PROVINSI**
```
Nama Provinsi: RIAU
Kode Provinsi: 18
```

#### **Tab 5: Alamat & Kontak**
```
Alamat Lengkap: SUMBER JAYA
Kode Pos: 28772

No. Telepon: 0812-xxxx-xxxx
Email: desasumberjaya@gmail.com
Website: www.desasumberjaya.id (opsional)

Latitude: (jika ada)
Longitude: (jika ada)
```

#### **Tab 6: Pejabat**
```
Pamong Penandatangan Default:
Nama: (Nama kepala desa yang akan TTD default)
Jabatan: KEPALA DESA
NIP: 19xxxxxxxx
```

**✅ Klik SIMPAN**

---

## 2. Buat Kategori Surat

### 📍 **Lokasi Menu:** Master Data → Kategori Surat

### **Langkah-langkah:**

1. **Klik tombol "Tambah" (kanan atas)**

2. **Isi Form:**
   ```
   Nama Kategori: Surat Keterangan
   Kode: SK
   Warna: success (hijau) atau pilih warna lain
   Keterangan: Surat keterangan untuk berbagai keperluan warga
   ```

3. **✅ Klik SIMPAN**

**Contoh Kategori Lain:**
- **Surat Undangan** - Kode: SU - Warna: info (biru)
- **Surat Tugas** - Kode: ST - Warna: warning (kuning)
- **Surat Keputusan** - Kode: SK-KEP - Warna: danger (merah)
- **Surat Pengantar** - Kode: SP - Warna: primary (ungu)

---

## 3. Buat Template Surat

### 📍 **Lokasi Menu:** Master Data → Template Surat

### **Contoh: Template "Surat Keterangan Tidak Mampu"**

### **Langkah-langkah:**

1. **Klik tombol "Tambah"**

2. **Tab 1: PENGATURAN UMUM**
   ```
   Nama Template: Surat Keterangan Tidak Mampu
   Kode Template: SKTM
   Kategori: Surat Keterangan (pilih yang sudah dibuat)
   
   Ukuran Kertas: A4
   Orientasi: portrait
   
   Margin (cm):
   - Margin Kiri: 2
   - Margin Kanan: 2
   - Margin Atas: 1.5
   - Margin Bawah: 1.5
   
   Opsi Tampilan:
   ☑ Tampilkan Header (KOP SURAT)
   ☑ Tampilkan Logo
   ☑ Tampilkan Footer
   ☐ Tampilkan QR Code (opsional)
   
   Status:
   ☑ Aktif
   ```

3. **Tab 2: KONTEN TEMPLATE**

   **🔵 PENTING:** Kop surat TIDAK PERLU ditulis di sini! Sistem akan tambahkan otomatis dari Pengaturan Desa.

   **A. Header (Tambahan - OPSIONAL):**
   ```
   Kosongkan saja, karena kop surat sudah otomatis
   ```

   **B. Body (ISI SURAT - WAJIB):**
   
   Salin template ini dan paste ke editor:
   
   ```html
   <div style="text-align: center; margin-bottom: 20px;">
       <h3 style="margin: 0; text-decoration: underline;"><strong>SURAT KETERANGAN TIDAK MAMPU</strong></h3>
       <p style="margin: 5px 0;">Nomor : {{nomor_surat}}</p>
   </div>

   <p style="text-align: justify;">
       Kepala Desa Sumber Jaya Kecamatan Siak Kecil Kabupaten Bengkalis menerangkan dengan sesungguhnya bahwa:
   </p>

   <table style="width: 100%; margin: 20px 0; border: none;" cellspacing="0" cellpadding="5">
       <tr>
           <td style="width: 200px; vertical-align: top;">Nama</td>
           <td style="width: 20px; vertical-align: top;">:</td>
           <td>{{nama}}</td>
       </tr>
       <tr>
           <td style="vertical-align: top;">Tempat tanggal lahir</td>
           <td style="vertical-align: top;">:</td>
           <td>{{tempat_lahir}}, {{tanggal_lahir}}</td>
       </tr>
       <tr>
           <td style="vertical-align: top;">Jenis kelamin</td>
           <td style="vertical-align: top;">:</td>
           <td>{{jenis_kelamin}}</td>
       </tr>
       <tr>
           <td style="vertical-align: top;">Agama</td>
           <td style="vertical-align: top;">:</td>
           <td>{{agama}}</td>
       </tr>
       <tr>
           <td style="vertical-align: top;">Status perkawinan</td>
           <td style="vertical-align: top;">:</td>
           <td>{{status_kawin}}</td>
       </tr>
       <tr>
           <td style="vertical-align: top;">Pekerjaan</td>
           <td style="vertical-align: top;">:</td>
           <td>{{pekerjaan}}</td>
       </tr>
       <tr>
           <td style="vertical-align: top;">Alamat</td>
           <td style="vertical-align: top;">:</td>
           <td>{{alamat}}</td>
       </tr>
   </table>

   <p style="text-align: justify;">
       Siak Kecil Kabupaten Bengkalis diatas adalah benar warga Desa Sumber Jaya Kecamatan Siak Kecil Kabupaten Bengkalis dan berdasarkan data yang ada di kantor Desa orang tersebut diatas, benar keluarga kurang mampu (<strong>KELUARGA BERPENGHASILAN RENDAH</strong>). Dan Surat Keterangan ini diberikan untuk mendapatkan pelayanan pengobatan gratis.
   </p>

   <p style="text-align: justify;">
       Demikian surat keterangan ini dibuat dengan sebenarnya untuk yang bersangkutan dan kiranya dapat dipergunakan seperlunya.
   </p>
   ```

   **C. Footer (TANDA TANGAN - WAJIB):**
   
   ```html
   <table style="width: 100%; margin-top: 30px; border: none;" cellspacing="0">
       <tr>
           <td style="width: 50%;"></td>
           <td style="width: 50%; text-align: center;">
               <p style="margin: 0;">Sumber Jaya, {{tanggal_surat}}</p>
               <p style="margin: 5px 0;"><strong>KEPALA DESA SUMBER JAYA</strong></p>
               <div style="height: 80px;"></div>
               <p style="margin: 0;"><strong><u>{{nama_penandatangan}}</u></strong></p>
               <p style="margin: 0;">NIP: {{nip_penandatangan}}</p>
           </td>
       </tr>
   </table>
   ```

4. **Tab 3: FORM ISIAN (VARIABLE)**

   **Klik tombol "Tambah Variable" untuk setiap data yang perlu diisi:**
   
   | No | Nama Variable | Keterangan |
   |----|---------------|------------|
   | 1  | `nama` | Nama lengkap pemohon |
   | 2  | `tempat_lahir` | Tempat lahir |
   | 3  | `tanggal_lahir` | Tanggal lahir (contoh: 12-05-1968) |
   | 4  | `jenis_kelamin` | LAKI-LAKI atau PEREMPUAN |
   | 5  | `agama` | ISLAM, KRISTEN, dll |
   | 6  | `status_kawin` | KAWIN, BELUM KAWIN, CERAI |
   | 7  | `pekerjaan` | Pekerjaan pemohon |
   | 8  | `alamat` | Alamat lengkap (RT/RW/Desa) |

   **Cara menambahkan:**
   - Klik "Tambah Variable"
   - Ketik nama variable (tanpa {{ }})
   - Contoh: ketik `nama`, bukan `{{nama}}`
   - Variable otomatis jadi form field saat generate surat

5. **✅ Klik SIMPAN**

---

## 4. Generate Surat dari Template

### 📍 **Lokasi Menu:** Surat → Arsip Surat

### **Langkah-langkah:**

1. **Klik tombol hijau "Buat Surat dari Template"**

2. **Section: PILIH TEMPLATE**
   ```
   Template Surat: Surat Keterangan Tidak Mampu
   ```
   
   **⚡ Setelah pilih template, form akan muncul otomatis!**

3. **Section: DATA SURAT**
   ```
   Nomor Surat: 282 / SK/TM / 05 / XI / 2010
   Tanggal Surat: 08-11-2010 (pilih dari calendar)
   Perihal/Judul: Surat Keterangan Tidak Mampu
   ```

4. **Section: DATA ISIAN**
   
   **Form ini muncul otomatis sesuai variable di template!**
   
   Isi sesuai data pemohon:
   ```
   Nama: ZULKIFLI S
   Tempat Lahir: SUNGAI MANGSIS
   Tanggal Lahir: 12-05-1968
   Jenis Kelamin: LAKI-LAKI
   Agama: ISLAM
   Status Kawin: KAWIN
   Pekerjaan: PETANI
   Alamat: RT / RW 01 / 01, Desa Sumber Jaya, Kec.Siak Kecil, Kab.Bengkalis
   ```

5. **Section: PENANDATANGAN**
   
   **Kosongkan jika mau pakai default dari Pengaturan Desa, atau isi jika berbeda:**
   ```
   Nama Penandatangan: (akan pakai default jika kosong)
   Jabatan: (akan pakai default jika kosong)
   NIP: (akan pakai default jika kosong)
   ```

6. **Section: CATATAN (Opsional)**
   ```
   Catatan: Surat untuk pengajuan KIP/KIS
   ```

7. **✅ Klik "SIMPAN"**

### **🎉 Apa yang Terjadi:**

1. ✅ Data tersimpan ke database
2. ✅ **PDF otomatis digenerate** dengan:
   - Kop surat lengkap (logo + header)
   - Isi surat dengan data yang diisi
   - Tanda tangan pejabat
3. ✅ Status otomatis jadi **"Selesai"**
4. ✅ File PDF tersimpan di: `storage/app/public/surat-arsip/`
5. ✅ Redirect ke halaman view surat

---

## 5. Download & Cetak PDF

### **Di Halaman View Surat:**

### **Tombol yang Tersedia:**

1. **🔵 Generate Ulang PDF**
   - Klik jika mau generate ulang (misalnya ada perubahan data)
   - Konfirmasi → PDF dibuat ulang

2. **✏️ Edit**
   - Ubah data surat jika ada kesalahan
   - Setelah edit, klik "Generate Ulang PDF"

3. **📥 Download File**
   - Klik tombol hijau "Download File"
   - PDF akan terdownload ke komputer
   - File format: `surat-{nomor}-{timestamp}.pdf`

4. **🖨️ Cetak**
   - Klik tombol biru "Cetak"
   - PDF terbuka di tab baru
   - Tekan `Ctrl+P` atau pilih Print
   - Atur printer & setting kertas
   - Klik Print

5. **🗑️ Hapus**
   - Hapus surat jika tidak jadi dipakai
   - Konfirmasi → Data & PDF terhapus

---

## 📊 Hasil PDF yang Akan Terbuat

### **Struktur PDF:**

```
┌─────────────────────────────────────────────┐
│         [LOGO]    KOP SURAT OTOMATIS        │
│                                             │
│  PEMERINTAH KABUPATEN BENGKALIS            │
│  KECAMATAN SIAK KECIL                      │
│  KEPALA DESA SUMBER JAYA                   │
│  SUMBER JAYA                               │
│  ─────────────────────────────────────     │
│  Alamat: ... Telp: ... Email: ...         │
├─────────────────────────────────────────────┤
│                                             │
│     SURAT KETERANGAN TIDAK MAMPU           │
│        Nomor : 282/SK/TM/05/XI/2010        │
│                                             │
│  Kepala Desa ... menerangkan bahwa:        │
│                                             │
│  Nama                : ZULKIFLI S           │
│  Tempat tanggal lahir: SUNGAI MANGSIS,     │
│                        12-05-1968           │
│  Jenis kelamin       : LAKI-LAKI            │
│  Agama               : ISLAM                │
│  Status perkawinan   : KAWIN                │
│  Pekerjaan           : PETANI               │
│  Alamat              : RT/RW 01/01 ...      │
│                                             │
│  ... adalah benar warga ... kurang mampu   │
│  (KELUARGA BERPENGHASILAN RENDAH) ...      │
│                                             │
│  Demikian surat keterangan ini dibuat...   │
│                                             │
│                    Sumber Jaya, 08-11-2010 │
│                  KEPALA DESA SUMBER JAYA   │
│                                             │
│                      (TTD SPACE)            │
│                                             │
│                   (Nama Kepala Desa)        │
│                   NIP: 19xxxxxxxx           │
└─────────────────────────────────────────────┘
```

---

## 💡 Tips & Trik

### ✅ **DO's (Yang Harus Dilakukan):**

1. **Isi Pengaturan Desa lengkap** sebelum buat template
2. **Upload logo desa** untuk tampilan profesional
3. **Gunakan variable** untuk data dinamis (nama, tanggal, dll)
4. **Test template** sebelum pakai untuk surat resmi
5. **Backup data** berkala
6. **Simpan PDF** ke folder terorganisir

### ❌ **DON'T's (Jangan Dilakukan):**

1. **JANGAN tulis kop surat manual** di template (sudah otomatis!)
2. **JANGAN hardcode** nama/tanggal di template (gunakan variable)
3. **JANGAN lupa** isi nomor surat dengan format benar
4. **JANGAN edit** file PDF manual (edit di sistem lalu generate ulang)
5. **JANGAN hapus** template yang masih dipakai

---

## 🔍 Variable yang Tersedia

### **📍 Variable Sistem (Otomatis):**
- `{{nomor_surat}}` - Nomor yang diisi user
- `{{tanggal_surat}}` - Tanggal yang diisi user
- `{{perihal}}` - Perihal yang diisi user

### **📍 Variable Pengaturan Desa (Otomatis):**
- `{{nama_desa}}` - KEPALA DESA SUMBER JAYA
- `{{nama_kecamatan}}` - KECAMATAN SIAK KECIL
- `{{nama_kabupaten}}` - KABUPATEN BENGKALIS
- `{{nama_provinsi}}` - RIAU
- `{{alamat_desa}}` - Alamat lengkap
- `{{kode_pos}}` - Kode pos
- `{{telepon_desa}}` - No telepon
- `{{email_desa}}` - Email desa
- `{{website_desa}}` - Website desa
- `{{nama_kepala_desa}}` - Nama kepala desa
- `{{nip_kepala_desa}}` - NIP kepala desa
- `{{latitude}}` - Koordinat GPS
- `{{longitude}}` - Koordinat GPS

### **📍 Variable Penandatangan:**
- `{{nama_penandatangan}}` - Nama yang TTD
- `{{jabatan_penandatangan}}` - Jabatan yang TTD
- `{{nip_penandatangan}}` - NIP yang TTD

### **📍 Variable Custom (Sesuai Kebutuhan):**
- `{{nama}}` - Nama pemohon
- `{{nik}}` - NIK
- `{{alamat}}` - Alamat
- `{{keperluan}}` - Keperluan surat
- Dan variable lain sesuai yang Anda buat!

---

## 🎯 Contoh Template Lain

### **1. Surat Pengantar**

**Variable:**
- `nama_lengkap`
- `nik`
- `tempat_lahir`
- `tanggal_lahir`
- `pekerjaan`
- `alamat`
- `keperluan`
- `tujuan`

**Body:**
```html
<div style="text-align: center; margin-bottom: 20px;">
    <h3><strong><u>SURAT PENGANTAR</u></strong></h3>
    <p>Nomor : {{nomor_surat}}</p>
</div>

<p>Yang bertanda tangan di bawah ini Kepala Desa {{nama_desa}} Kecamatan {{nama_kecamatan}} 
Kabupaten {{nama_kabupaten}} menerangkan dengan sesungguhnya bahwa:</p>

<table style="width: 100%; margin: 20px 0;">
    <tr><td width="200px">Nama</td><td>: {{nama_lengkap}}</td></tr>
    <tr><td>NIK</td><td>: {{nik}}</td></tr>
    <tr><td>Tempat/Tgl Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
    <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
    <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
</table>

<p>Adalah benar penduduk Desa {{nama_desa}} dan surat ini diberikan kepada 
yang bersangkutan untuk keperluan <strong>{{keperluan}}</strong> ke {{tujuan}}.</p>

<p>Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
```

### **2. Surat Keterangan Usaha**

**Variable:**
- `nama_lengkap`
- `nik`
- `tempat_lahir`
- `tanggal_lahir`
- `alamat`
- `jenis_usaha`
- `nama_usaha`
- `alamat_usaha`
- `tahun_berdiri`

---

## 🆘 Troubleshooting

### **Q: Logo tidak muncul di PDF?**
**A:** 
- Pastikan logo sudah diupload di Pengaturan Desa
- Format logo harus PNG/JPG
- Ukuran max 2MB
- Centang "Tampilkan Logo" di template

### **Q: Variable tidak terganti (masih muncul {{nama}})?**
**A:**
- Pastikan variable sudah ditambahkan di Tab 3 template
- Nama variable harus exact match (case-sensitive)
- Refresh form kalau perlu

### **Q: Kop surat tidak muncul?**
**A:**
- Pastikan "Tampilkan Header" dicentang di template
- Pastikan Pengaturan Desa sudah diisi lengkap

### **Q: Format tanggal salah?**
**A:**
- Sistem otomatis format tanggal Indonesia
- Contoh input: 2025-11-09 → Output: 9 November 2025

### **Q: PDF blank/kosong?**
**A:**
- Cek apakah Body template terisi
- Cek browser console untuk error
- Generate ulang PDF

---

## 📞 Bantuan Lebih Lanjut

Lihat dokumentasi lainnya:
- [PANDUAN-ARSIP-SURAT.md](PANDUAN-ARSIP-SURAT.md)
- [PANDUAN-PENGATURAN-DESA.md](PANDUAN-PENGATURAN-DESA.md)
- [PANDUAN-UPLOAD-LOGO.md](PANDUAN-UPLOAD-LOGO.md)

---

**Versi:** 1.0  
**Terakhir Update:** November 2025  
**Sistem:** Arsip & Templating Surat Desa Sumber Jaya
