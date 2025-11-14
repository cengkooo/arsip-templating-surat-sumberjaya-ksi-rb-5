# 🧪 BLACK BOX TESTING GUIDE - Arsip Templating Surat

## 📋 Pengertian Black Box Testing

**Black Box Testing** = Testing berdasarkan **fungsi/behavior** sistem tanpa melihat internal code.
- ✅ Fokus: Input → Process → Output
- ✅ Tidak peduli bagaimana kode bekerja
- ✅ Fokus apakah hasil sesuai requirement

---

## 🎯 TEST SCENARIOS (Sesuai Todo List)

### ✅ SCENARIO 1: Upload Logo Kop Surat

**Objective:** Verifikasi logo desa otomatis muncul di PDF

#### Test Case 1.1: Upload Logo Desa
```
Input:
  1. Buka Master Data → Pengaturan Desa
  2. Tab "DESA"
  3. Upload Logo (file PNG/JPG)
  4. Save

Expected Output:
  ✅ Logo tersimpan
  ✅ File muncul di folder storage/app/public/logo-desa/
  ✅ Notification: "Berhasil diperbarui"
```

**Test Steps:**
1. Login sebagai admin
2. Navigasi ke **Master Data → Pengaturan Desa**
3. Tab **DESA**
4. Cari field **"Logo Desa"**
5. Upload file logo (gunakan file PNG/JPG lokal, size 1-2MB)
6. Klik **Save**
7. **Verify:**
   - ✅ Data tersimpan (tidak error)
   - ✅ Notification success muncul
   - ✅ File ada di `/storage/app/public/logo-desa/`

**Test Data:**
- Logo: `lambung-selatan.png` (1.2 MB, 500x500px)

**Pass Criteria:**
- Logo berhasil diupload
- Tidak ada error message

---

#### Test Case 1.2: Logo Muncul di PDF
```
Input:
  1. Generate surat (dengan logo sudah diupload)
  2. Download PDF

Expected Output:
  ✅ Logo muncul di bagian atas (kop surat)
  ✅ Logo format rapi dan tidak pecah
  ✅ Posisi sesuai (center/atas halaman)
```

**Test Steps:**
1. Pastikan logo sudah diupload (Test Case 1.1)
2. Generate surat: **Arsip Surat → Create from Template**
3. Isi semua form
4. Klik **Create**
5. **Download** PDF
6. **Verify:**
   - ✅ Logo muncul di bagian atas surat
   - ✅ Logo tidak pecah/corrupt
   - ✅ Format rapi
   - ✅ Posisi center

**Pass Criteria:**
- Logo terlihat dengan jelas di PDF
- Kualitas gambar OK

---

### ✅ SCENARIO 2: Setup Pengaturan Desa

**Objective:** Verifikasi semua data desa tersimpan dan siap pakai

#### Test Case 2.1: Isi Data DESA Tab
```
Input:
  Tab "DESA" di Pengaturan Desa:
  - Nama Desa: Sumberjaya
  - Nama Kecamatan: Kalianda
  - Nama Kabupaten: Lampung Selatan
  - Nama Provinsi: Lampung
  - Alamat: Jl. Way Urang No. 123
  - Email: desa@sumberjaya.com
  - Telepon: 0727-123456
  - Website: www.sumberjaya.desa.id
  - Kode Pos: 35551

Expected Output:
  ✅ Semua data tersimpan di database
  ✅ Data dapat ditampilkan kembali saat edit
  ✅ Notification success
```

**Test Steps:**
1. Login sebagai admin
2. **Master Data → Pengaturan Desa**
3. Tab **DESA**
4. Isi semua field sesuai data di atas
5. Klik **Save**
6. **Verify:**
   - ✅ Notification: "Berhasil diperbarui"
   - ✅ Data masih ada saat refresh page
   - ✅ Edit kembali, data masih ada

**Pass Criteria:**
- Semua data tersimpan
- Tidak ada field yang hilang

---

#### Test Case 2.2: Isi Data PEJABAT Tab
```
Input:
  Tab "PEJABAT":
  - Nama Pamong TTD: YUYUK MINDARSIH
  - Jabatan Pamong TTD: Kepala Desa Sumberjaya
  - NIP Pamong TTD: 123456789012345

Expected Output:
  ✅ Data tersimpan
  ✅ Muncul sebagai default di form Generate Surat
```

**Test Steps:**
1. **Pengaturan Desa → Tab PEJABAT**
2. Isi field sesuai data
3. **Save**
4. **Generate Surat → Buat dari Template → Tidak isi Penandatangan**
5. **Verify:**
   - ✅ Form Penandatangan auto-fill dari default
   - ✅ Nama: YUYUK MINDARSIH
   - ✅ Jabatan: Kepala Desa Sumberjaya
   - ✅ NIP: 123456789012345

**Pass Criteria:**
- Default data muncul di form generate

---

### ✅ SCENARIO 3: Buat Kategori

**Objective:** Verifikasi kategori surat dapat dibuat dan digunakan

#### Test Case 3.1: Create Kategori
```
Input:
  - Nama Kategori: "Surat Keluar"
  - Warna Badge: Biru

Expected Output:
  ✅ Kategori tersimpan
  ✅ Muncul di daftar kategori
  ✅ Dapat dipilih saat buat template
```

**Test Steps:**
1. **Master Data → Kategori**
2. Klik **Create**
3. Isi:
   - **Nama**: Surat Keluar
   - **Warna**: Biru (pilih dari color picker)
4. **Save**
5. **Verify:**
   - ✅ Kategori muncul di list
   - ✅ Warna badge sesuai (biru)
   - ✅ Badge muncul di halaman template

**Pass Criteria:**
- Kategori berhasil dibuat
- Badge warna sesuai

---

### ✅ SCENARIO 4: Buat Template SKTM

**Objective:** Verifikasi template dapat dibuat dengan semua field terisi

#### Test Case 4.1: Create Template SKTM
```
Input:
  Tab "UMUM":
  - Nama Template: SKTM
  - Kategori: Surat Keluar
  - Ukuran Kertas: F4
  - Orientasi: Portrait
  - Status: Aktif

Expected Output:
  ✅ Template tersimpan
  ✅ Muncul di daftar template
```

**Test Steps:**
1. **Master Data → Template Surat**
2. Klik **Create**
3. Tab **UMUM** - Isi sesuai data di atas
4. Tab **TEMPLATE** - Isi HTML (gunakan template dari TEMPLATE-HTML-SKTM.md)
5. Tab **FORM ISIAN** - Buat 8 variable (nama, nik, alamat, dll)
6. **Create**
7. **Verify:**
   - ✅ Template muncul di list
   - ✅ Kategori sesuai
   - ✅ Status "Aktif"

**Pass Criteria:**
- Template berhasil dibuat
- Semua field terisi

---

#### Test Case 4.2: Edit Template SKTM
```
Input:
  Edit template:
  - Ubah Nama: "SKTM - Versi 2025"

Expected Output:
  ✅ Perubahan tersimpan
  ✅ Nama update di list
```

**Test Steps:**
1. **Template SKTM → Edit**
2. Ubah nama template
3. **Update**
4. **Verify:**
   - ✅ Nama berubah di list
   - ✅ Edit kembali, perubahan tetap ada

**Pass Criteria:**
- Perubahan berhasil disimpan

---

#### Test Case 4.3: Preview Template
```
Input:
  Klik "Preview" di template

Expected Output:
  ✅ Preview modal muncul
  ✅ Menampilkan contoh format surat
  ✅ Variable visible di preview
```

**Test Steps:**
1. **Template SKTM → Lihat (View)**
2. Scroll ke section "Preview"
3. **Verify:**
   - ✅ Preview muncul
   - ✅ Judul surat terlihat
   - ✅ Format tabel visible
   - ✅ Footer terlihat

**Pass Criteria:**
- Preview ditampilkan dengan benar

---

### ✅ SCENARIO 5: Generate Surat dari Template

**Objective:** Verifikasi surat dapat di-generate dengan data terisi otomatis

#### Test Case 5.1: Generate Surat dengan Data Lengkap
```
Input:
  1. Click "Gunakan Template" di template SKTM
  2. Pilih template: SKTM
  3. Isi Form:
     - Nomor Surat: 001/SKTM/XI/2025
     - Tanggal Surat: 12 November 2025
     - Lampiran: 1 lembar
     - Perihal: Surat Keterangan Tidak Mampu
     - Nama: Andryano
     - NIK: 1231236782136872613
     - TTL: SDK, 20 Juli 2001
     - Jenis Kelamin: Pria (dropdown)
     - Agama: Islam
     - Pekerjaan: Mahasiswa
     - Alamat: Jl. Aer Bersih
     - Penandatangan: YUYUK MINDARSIH
     - Jabatan: Kepala Desa Sumberjaya
     - NIP: 123456789012345

Expected Output:
  ✅ Surat tersimpan dengan status "Draft"
  ✅ File PDF generated
  ✅ Redirect ke halaman detail surat
```

**Test Steps:**
1. **Arsip Surat**
2. Klik **"Create from Template"** (atau di Template: "Gunakan Template")
3. **Pilih Template:** SKTM
4. **Isi semua form** sesuai data di atas
5. Klik **Create**
6. **Verify:**
   - ✅ Redirect ke halaman detail surat
   - ✅ Nomor surat terlihat: 001/SKTM/XI/2025
   - ✅ Status: Draft
   - ✅ File PDF ada (link download)

**Pass Criteria:**
- Surat berhasil di-generate
- PDF tersimpan

---

#### Test Case 5.2: Download & Verifikasi PDF
```
Input:
  Download PDF dari surat yang baru di-generate

Expected Output:
  ✅ PDF download berhasil
  ✅ Semua variable terganti dengan nilai yang diinput
  ✅ Format rapi (indentasi, spacing, alignment)
```

**Test Steps:**
1. **Dari Test Case 5.1** - Di halaman detail surat
2. Klik button **"Download PDF"** atau **"Print"**
3. **PDF terbuka di browser**
4. **Verify content:**
   - ✅ Judul: "SURAT KETERANGAN TIDAK MAMPU"
   - ✅ Nomor: 001/SKTM/XI/2025 ✓ (otomatis)
   - ✅ Lampiran: 1 lembar ✓ (otomatis)
   - ✅ Perihal: Surat Keterangan Tidak Mampu ✓ (otomatis)
   - ✅ Nama: Andryano ✓ (dari form)
   - ✅ NIK: 1231236782136872613 ✓ (dari form)
   - ✅ TTL: SDK, 20 Juli 2001 ✓ (dari form)
   - ✅ Jenis Kelamin: Pria ✓ (dari dropdown)
   - ✅ Agama: Islam ✓ (dari form)
   - ✅ Pekerjaan: Mahasiswa ✓ (dari form)
   - ✅ Alamat: Jl. Aer Bersih ✓ (dari form)
   - ✅ Footer ada (Tanggal, Jabatan, Nama, NIP)
   - ✅ Format rapi (indentasi, alignment)
   - ✅ Tabel data rapi sejajar

**Pass Criteria:**
- PDF muncul tanpa error
- Semua variable terganti dengan benar
- Format sesuai standar surat dinas

---

#### Test Case 5.3: Variable Replacement Test
```
Input:
  Generate 2 surat dengan data berbeda

Expected Output:
  ✅ Setiap surat punya data sendiri (tidak tercampur)
  ✅ Variable terganti sesuai input masing-masing
```

**Test Steps:**
1. **Generate Surat 1:**
   - Nama: Andryano
   - Nomor: 001/SKTM/XI/2025
2. **Download PDF 1** - Verify nama Andryano ada
3. **Generate Surat 2:**
   - Nama: Budi Santoso
   - Nomor: 002/SKTM/XI/2025
4. **Download PDF 2** - Verify nama Budi ada
5. **Verify:**
   - ✅ PDF 1 punya nama Andryano
   - ✅ PDF 2 punya nama Budi
   - ✅ Nomor surat berbeda

**Pass Criteria:**
- Variable terganti sesuai data input
- Tidak ada mix-up data antar surat

---

#### Test Case 5.4: Jenis Kelamin Dropdown Test
```
Input:
  Generate surat dengan Jenis Kelamin = "Wanita"

Expected Output:
  ✅ Variable {{jenis_kelamin}} = "Wanita" di PDF
  ✅ Dropdown berfungsi dengan 2 pilihan: Pria, Wanita
```

**Test Steps:**
1. **Create from Template - SKTM**
2. Di field **Jenis Kelamin** - Pilih **"Wanita"**
3. Isi form lainnya
4. **Create**
5. **Download PDF**
6. **Verify:**
   - ✅ Jenis Kelamin: Wanita (bukan Pria)
   - ✅ Dropdown ada 2 pilihan (Pria/Wanita)

**Pass Criteria:**
- Dropdown berfungsi
- Nilai yang dipilih muncul di PDF

---

### ✅ SCENARIO 6: Footer & Header Test

**Objective:** Verifikasi tanda tangan dan header terisi otomatis

#### Test Case 6.1: Footer Tanda Tangan
```
Input:
  Generate surat dengan data penandatangan

Expected Output:
  ✅ Footer muncul dengan:
     - Tanggal: 12 November 2025
     - Jabatan: Kepala Desa Sumberjaya
     - Nama: YUYUK MINDARSIH (bold + underline)
     - NIP: 123456789012345
```

**Test Steps:**
1. **Generate Surat** (Test Case 5.1)
2. **Download PDF**
3. **Scroll ke bagian bawah**
4. **Verify:**
   - ✅ Tanggal terlihat
   - ✅ Jabatan terlihat
   - ✅ Nama BOLD + UNDERLINE
   - ✅ NIP terlihat
   - ✅ Ada ruang untuk tanda tangan + stempel (~3-4 baris kosong)

**Pass Criteria:**
- Semua footer data terlihat
- Format sesuai standar surat dinas

---

#### Test Case 6.2: Header Optional (Nomor, Lampiran, Perihal)
```
Input:
  Generate surat (dengan header optional)

Expected Output:
  ✅ Header muncul sebelum judul surat:
     - Nomor: 001/SKTM/XI/2025
     - Lampiran: 1 lembar
     - Perihal: Surat Keterangan Tidak Mampu
```

**Test Steps:**
1. **Download PDF** (Test Case 5.2)
2. **Lihat bagian atas (sebelum judul)**
3. **Verify:**
   - ✅ Nomor terlihat
   - ✅ Lampiran terlihat
   - ✅ Perihal terlihat

**Pass Criteria:**
- Header info terlihat dengan benar

---

### ✅ SCENARIO 7: Error Handling & Validation

**Objective:** Verifikasi error handling bekerja dengan benar

#### Test Case 7.1: Nomor Surat Duplikat
```
Input:
  Generate surat dengan nomor yang sudah ada

Expected Output:
  ❌ Error: Nomor sudah digunakan
  ❌ Form tidak ter-submit
```

**Test Steps:**
1. **Generate surat pertama:**
   - Nomor: 001/SKTM/XI/2025
   - Create ✓
2. **Generate surat kedua dengan nomor sama:**
   - Nomor: 001/SKTM/XI/2025
   - Create ❌
3. **Verify:**
   - ❌ Error message muncul
   - ❌ Surat tidak tersimpan

**Pass Criteria:**
- Error message muncul
- Nomor tidak boleh duplikat

---

#### Test Case 7.2: Form Kosong
```
Input:
  Create surat tanpa isi form (submit kosong)

Expected Output:
  ❌ Validation error untuk field required
  ❌ Form tidak ter-submit
```

**Test Steps:**
1. **Create from Template**
2. Pilih template
3. **Jangan isi form**
4. Klik **Create**
5. **Verify:**
   - ❌ Validation error muncul
   - ❌ Field required berubah merah
   - ❌ Surat tidak tersimpan

**Pass Criteria:**
- Validation berfungsi
- Field required tidak boleh kosong

---

#### Test Case 7.3: Invalid File Type untuk Logo
```
Input:
  Upload logo dengan format .txt atau .exe

Expected Output:
  ❌ Error: Format tidak valid
  ❌ File tidak ter-upload
```

**Test Steps:**
1. **Pengaturan Desa → DESA**
2. Upload file: `logo.txt` atau `logo.exe`
3. **Save**
4. **Verify:**
   - ❌ Error message muncul
   - ❌ File tidak tersimpan

**Pass Criteria:**
- Hanya file gambar (PNG, JPG) yang diterima

---

---

## 📊 TEST SUMMARY CHECKLIST

Buat tabel untuk track hasil testing:

```
No | Test Case | Input | Expected | Actual | Status | Notes
---|-----------|-------|----------|--------|--------|-------
1.1| Upload Logo | PNG 500x500 | Tersimpan | ... | ✅/❌ | 
1.2| Logo di PDF | Generate PDF | Logo muncul | ... | ✅/❌ |
2.1| Setup Desa | Data lengkap | Tersimpan | ... | ✅/❌ |
2.2| Default Pejabat | TTD auto-fill | Muncul default | ... | ✅/❌ |
3.1| Buat Kategori | Surat Keluar | Kategori ada | ... | ✅/❌ |
4.1| Create Template | HTML + Variable | Template ada | ... | ✅/❌ |
4.2| Edit Template | Ubah nama | Nama update | ... | ✅/❌ |
4.3| Preview | Click preview | Preview muncul | ... | ✅/❌ |
5.1| Generate Surat | Form lengkap | PDF generated | ... | ✅/❌ |
5.2| Download PDF | Download | PDF rapi | ... | ✅/❌ |
5.3| Multi-Surat | 2 surat | Data terpisah | ... | ✅/❌ |
5.4| Jenis Kelamin | Dropdown Wanita | Wanita di PDF | ... | ✅/❌ |
6.1| Footer TTD | Generate | Footer ok | ... | ✅/❌ |
6.2| Header Info | Generate | Header ok | ... | ✅/❌ |
7.1| Nomor Duplikat | Nomor sama | Error | ... | ✅/❌ |
7.2| Form Kosong | Submit kosong | Validation | ... | ✅/❌ |
7.3| Invalid Logo | .txt file | Error | ... | ✅/❌ |
```

---

## 🎯 PASSING CRITERIA

Sistem dianggap **PASS** jika:
- ✅ **95%+ test case** berhasil
- ✅ **Tidak ada critical error** (crash, data hilang)
- ✅ **Semua variable** terganti dengan benar
- ✅ **PDF format** rapi sesuai standar
- ✅ **Logo muncul** di PDF
- ✅ **Validation** berfungsi

---

## 🚀 TESTING EXECUTION PLAN

### **Phase 1: Setup (Hari 1)**
```
1. Upload Logo Desa
2. Setup Pengaturan Desa
3. Buat Kategori
```

### **Phase 2: Template Creation (Hari 2)**
```
4. Create Template SKTM
5. Edit Template (jika perlu)
6. Preview Template
```

### **Phase 3: Main Testing (Hari 3-4)**
```
7. Generate Surat
8. Download & Verify PDF
9. Multi-Surat Test
10. Jenis Kelamin Dropdown Test
11. Footer & Header Test
```

### **Phase 4: Error Handling (Hari 5)**
```
12. Nomor Duplikat Test
13. Form Kosong Test
14. Invalid File Test
```

---

## 📝 BUG REPORT TEMPLATE

Kalau ada yang error, dokumentasikan:

```
BUG #001
--------
Title: [Judul bug]
Severity: CRITICAL / HIGH / MEDIUM / LOW
Test Case: [Nomor test case]
Steps to Reproduce:
  1. ...
  2. ...
  3. ...

Expected Result:
  [Apa yang seharusnya terjadi]

Actual Result:
  [Apa yang benar-benar terjadi]

Screenshots:
  [Sertakan screenshot]

Environment:
  - OS: Windows 10
  - Browser: Chrome 120
  - Date: 12 November 2025
```

---

## ✅ KESIMPULAN

Dengan mengikuti panduan Black Box Testing ini, kamu akan:
- ✅ **Verify** semua fitur bekerja sesuai requirement
- ✅ **Identify** bug atau issue
- ✅ **Document** hasil testing
- ✅ **Ensure** kualitas sistem

**Happy Testing! 🎉**
