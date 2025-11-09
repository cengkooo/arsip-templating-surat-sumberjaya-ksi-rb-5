# 📝 CARA EDIT ISI SURAT - PANDUAN LENGKAP

## 🎯 Solusi: Edit dengan HTML (Simple & Powerful)

Karena editor WYSIWYG (seperti Word) sulit di-integrate, saya sudah ubah sistem menjadi **HTML-based** dengan **Copy-Paste Template**.

### ✅ Keuntungan Metode Ini:
- 💯 **Full Control** atas format (indentasi, spacing, alignment)
- 🚀 **Super Cepat** - Copy template → Paste → Edit sedikit
- 📱 **Ringan** - Tidak perlu load library berat
- 🎨 **Konsisten** - Format selalu sama di PDF
- 🔧 **Fleksibel** - Bisa custom style sesuka hati

---

## 📖 TUTORIAL STEP-BY-STEP

### 1️⃣ Buka Halaman Buat Template

```
Master Data → Template Surat → Create (tombol hijau)
```

### 2️⃣ Isi Tab "Umum" (Data Dasar)

- **Nama Template**: SKTM (atau nama surat lainnya)
- **Kategori**: Pilih kategori yang sesuai
- **Ukuran Kertas**: F4 (standar surat dinas)
- **Orientasi**: Portrait
- **Status**: Aktif ✅

### 3️⃣ Pindah ke Tab "Template"

Scroll ke bagian **"Isi Surat"**

### 4️⃣ Copy Template HTML

Klik button hijau **"📋 Copy Template HTML Ini"**

Alert akan muncul: ✅ Template HTML berhasil di-copy!

### 5️⃣ Paste ke Field "Tulis Template Isi Surat (HTML)"

```
1. Klik di dalam textarea (kotak besar)
2. Tekan Ctrl + V (paste)
3. Template HTML sudah masuk!
```

### 6️⃣ Edit Sesuai Kebutuhan

Sekarang kamu bisa edit:
- Judul surat (ganti "SURAT KETERANGAN TIDAK MAMPU")
- Nama instansi (ganti "Desa Sumberjaya")
- Isi paragraf
- Data di tabel
- Variable yang digunakan

---

## 🎨 CARA EDIT ISI SURAT

### Format Judul (Bold + Underline + Center)

```html
<p style="text-align: center; margin: 0;"><strong><u>JUDUL SURAT KAMU</u></strong></p>
<p style="text-align: center; margin: 0 0 20px 0;">Nomor: {{nomor_surat}}</p>
```

**Keterangan:**
- `<strong>` = Bold
- `<u>` = Underline
- `text-align: center` = Rata tengah
- `margin: 0 0 20px 0` = Jarak bawah 20px

---

### Format Paragraf (Justify + Indentasi 50px)

```html
<p style="text-align: justify; text-indent: 50px;">
    Isi paragraf kamu di sini. Paragraf ini akan rata kiri-kanan (justify) 
    dengan indentasi awal 50px seperti surat resmi.
</p>
```

**Keterangan:**
- `text-align: justify` = Rata kiri-kanan
- `text-indent: 50px` = Indentasi awal paragraf 50px
- Tambahkan `line-height: 1.5` untuk jarak baris

---

### Format Paragraf Tanpa Indent

```html
<p style="text-align: justify;">
    Paragraf tanpa indentasi, biasanya untuk kalimat pembuka.
</p>
```

---

### Format Tabel Data (Seperti di SKTM)

```html
<table style="margin-left: 50px; margin-bottom: 15px; border: none;">
    <tr>
        <td width="200">Nama</td>
        <td>: <strong>{{nama}}</strong></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>: {{nik}}</td>
    </tr>
    <tr>
        <td>Tempat Tanggal Lahir</td>
        <td>: {{tempat_lahir}}, {{tanggal_lahir}}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: {{jenis_kelamin}}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>: {{agama}}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>: {{pekerjaan}}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: {{alamat}}</td>
    </tr>
</table>
```

**Keterangan:**
- `width="200"` = Lebar kolom kiri 200px
- `margin-left: 50px` = Posisi tabel indent 50px (sejajar paragraf)
- `border: none` = Tanpa garis border
- `{{nama}}` = Variable yang akan diganti otomatis

**Cara Edit:**
1. Tambah baris: Copy-paste `<tr>...</tr>`
2. Hapus baris: Hapus `<tr>...</tr>` yang tidak perlu
3. Ganti label: Edit "Nama", "NIK", dll
4. Ganti variable: Edit `{{nama}}`, `{{nik}}`, dll

---

### Format Footer Tanda Tangan

```html
<div style="text-align: right; margin-top: 30px;">
    <p style="margin: 0;">Sumberjaya, {{tanggal_surat}}</p>
    <p style="margin: 5px 0;"><strong>{{jabatan}}</strong></p>
    <br><br><br>
    <p style="margin: 0;"><strong><u>{{penandatangan}}</u></strong></p>
    <p style="margin: 0;">NIP: {{nip}}</p>
</div>
```

**Keterangan:**
- `text-align: right` = Rata kanan
- `margin-top: 30px` = Jarak atas 30px
- `<br><br><br>` = 3 baris kosong untuk tanda tangan fisik
- `{{tanggal_surat}}`, `{{jabatan}}`, dll = Variable otomatis

---

## 🔧 HTML TAGS YANG SERING DIPAKAI

| Tag | Fungsi | Contoh |
|-----|--------|--------|
| `<p>` | Paragraf | `<p>Teks paragraf</p>` |
| `<strong>` | Bold (tebal) | `<strong>Teks Bold</strong>` |
| `<u>` | Underline (garis bawah) | `<u>Teks Underline</u>` |
| `<br>` | Line break (enter) | `Baris 1<br>Baris 2` |
| `<table>` | Tabel | `<table>...</table>` |
| `<tr>` | Table row (baris) | `<tr><td>Cell</td></tr>` |
| `<td>` | Table cell (kolom) | `<td>Isi cell</td>` |
| `<div>` | Container | `<div>...</div>` |

---

## 🎨 CSS STYLE YANG SERING DIPAKAI

### Text Alignment (Rata Teks)
```css
text-align: left;      /* Rata kiri */
text-align: center;    /* Rata tengah */
text-align: right;     /* Rata kanan */
text-align: justify;   /* Rata kiri-kanan (justify) */
```

### Indentasi
```css
text-indent: 50px;     /* Indentasi awal paragraf */
margin-left: 50px;     /* Geser seluruh elemen ke kanan */
```

### Spacing
```css
margin: 0;             /* Hilangkan jarak */
margin: 0 0 20px 0;    /* Jarak bawah 20px */
margin-top: 30px;      /* Jarak atas 30px */
line-height: 1.5;      /* Jarak baris 1.5x */
```

### Font
```css
font-size: 12pt;       /* Ukuran font */
font-weight: bold;     /* Bold */
font-family: 'Times New Roman', serif;  /* Jenis font */
```

### Border & Background
```css
border: none;          /* Tanpa garis */
border: 1px solid #000;  /* Garis hitam 1px */
background: #f0f0f0;   /* Warna background abu-abu */
```

---

## 💡 TIPS & TRIK

### 1. Copy dari Word/Google Docs

Kalau kamu sudah punya template di Word:

```
1. Buka Word → Select All (Ctrl+A)
2. Copy (Ctrl+C)
3. Paste ke https://wordtohtml.net/
4. Klik "Convert"
5. Copy HTML yang dihasilkan
6. Paste ke field "Isi Surat"
7. Edit sedikit (hapus style yang tidak perlu)
```

### 2. Preview di Browser

Sebelum save, test HTML kamu:

```
1. Copy HTML kamu
2. Buka https://htmledit.squarefree.com/
3. Paste di sebelah kanan
4. Lihat preview di sebelah kiri
5. Edit sampai sesuai
6. Copy kembali ke sistem
```

### 3. Indentasi Rapi

Untuk indentasi konsisten:

```html
<!-- Paragraf dengan indent -->
<p style="text-align: justify; text-indent: 50px;">
    Paragraf 1...
</p>

<p style="text-align: justify; text-indent: 50px;">
    Paragraf 2...
</p>

<!-- Tabel sejajar indent paragraf -->
<table style="margin-left: 50px;">
    ...
</table>
```

### 4. Line Height untuk Surat Resmi

Surat resmi biasanya pakai line height 1.5 atau 2.0:

```html
<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Paragraf dengan jarak baris 1.5x...
</p>
```

### 5. Bold untuk Nama Orang

```html
Nama : <strong>{{nama}}</strong>
```

Hasil: **Nama : John Doe** (nama orang jadi bold)

---

## 📌 VARIABLE YANG TERSEDIA

### Data Surat (Auto)
- `{{nomor_surat}}` - Nomor surat
- `{{lampiran}}` - Jumlah lampiran
- `{{perihal}}` - Perihal surat
- `{{tanggal_surat}}` - Tanggal surat (format Indonesia)

### Data Penandatangan (Auto)
- `{{penandatangan}}` - Nama pejabat TTD
- `{{jabatan}}` - Jabatan (Kepala Desa, dll)
- `{{nip}}` - NIP pejabat

### Data Desa (dari Pengaturan Desa)
- `{{nama_desa}}` - Nama desa
- `{{nama_kecamatan}}` - Nama kecamatan
- `{{nama_kabupaten}}` - Nama kabupaten
- `{{kode_pos}}` - Kode pos
- Dan 25+ variable lainnya

### Data Custom (dari Form Isian)
Kamu bisa tambah variable sendiri di tab "Form Isian":

- `{{nama}}` - Nama warga
- `{{nik}}` - NIK
- `{{alamat}}` - Alamat
- `{{pekerjaan}}` - Pekerjaan
- Dll (sesuai kebutuhan template)

---

## 🔥 CONTOH LENGKAP: SURAT KETERANGAN DOMISILI

```html
<p style="text-align: center; margin: 0;"><strong><u>SURAT KETERANGAN DOMISILI</u></strong></p>
<p style="text-align: center; margin: 0 0 20px 0;">Nomor: {{nomor_surat}}</p>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan Kalianda 
    Kabupaten Lampung Selatan menerangkan bahwa:
</p>

<table style="margin-left: 50px; margin-bottom: 15px; border: none;">
    <tr>
        <td width="200">Nama</td>
        <td>: <strong>{{nama}}</strong></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>: {{nik}}</td>
    </tr>
    <tr>
        <td>Tempat Tanggal Lahir</td>
        <td>: {{tempat_lahir}}, {{tanggal_lahir}}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>: {{pekerjaan}}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: {{alamat}}</td>
    </tr>
</table>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Adalah benar berdomisili di {{alamat}}, {{nama_desa}}, Kecamatan {{nama_kecamatan}}, 
    Kabupaten {{nama_kabupaten}}, Provinsi {{nama_provinsi}}.
</p>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan 
    sebagaimana mestinya.
</p>
```

---

## ❓ FAQ (Frequently Asked Questions)

### Q: Kenapa tidak pakai editor visual seperti Word?
**A:** Editor visual (WYSIWYG) sangat berat dan sering bikin masalah di PDF. HTML lebih ringan, konsisten, dan kamu punya full control.

### Q: Apa aku harus jago HTML?
**A:** TIDAK! Kamu cukup:
1. Copy template yang sudah disediakan
2. Edit teks-nya aja (yang di antara `>` dan `<`)
3. Ganti variable `{{nama}}` sesuai kebutuhan
4. Save!

### Q: Gimana kalau mau ganti warna teks?
**A:** Tambahkan `color: #FF0000;` di style:
```html
<p style="text-align: center; color: #FF0000;">Teks Merah</p>
```

### Q: Gimana cara buat list (bullet/numbering)?
**A:** Pakai `<ul>` (bullet) atau `<ol>` (numbering):
```html
<ul style="margin-left: 70px;">
    <li>Item 1</li>
    <li>Item 2</li>
    <li>Item 3</li>
</ul>
```

### Q: Hasil di PDF tidak sesuai preview?
**A:** DomPDF punya limitasi CSS. Pakai style inline (di tag langsung) dan hindari CSS kompleks.

### Q: Cara buat tabel dengan border?
**A:**
```html
<table style="border-collapse: collapse; margin-left: 50px;">
    <tr>
        <td style="border: 1px solid #000; padding: 5px;">Cell 1</td>
        <td style="border: 1px solid #000; padding: 5px;">Cell 2</td>
    </tr>
</table>
```

---

## 🎓 KESIMPULAN

### Workflow Edit Isi Surat:
1. ✅ Klik button "📋 Copy Template HTML Ini"
2. ✅ Paste (Ctrl+V) ke field "Isi Surat"
3. ✅ Edit teks yang perlu diubah
4. ✅ Ganti variable sesuai kebutuhan
5. ✅ Save template
6. ✅ Test generate surat
7. ✅ Download PDF dan cek hasilnya

### Keuntungan Metode Ini:
- 🚀 **Cepat**: Copy-paste dalam 10 detik
- 🎨 **Konsisten**: Format selalu sama
- 💪 **Powerful**: Full control CSS
- 📱 **Ringan**: Tidak lag
- 🔧 **Fleksibel**: Bisa custom sesuka hati

---

**Happy Editing! Kalau ada pertanyaan, cek tutorial lengkap di TUTORIAL-LENGKAP.md** 🎉
