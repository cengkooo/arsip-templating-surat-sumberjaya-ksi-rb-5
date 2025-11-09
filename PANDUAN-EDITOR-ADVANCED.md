# 📝 PANDUAN EDITOR ADVANCED - TINYMCE FULL VERSION

## ✨ Fitur Baru yang Tersedia

Editor template surat kamu sudah di-upgrade ke **TinyMCE Full Version** dengan kemampuan seperti Microsoft Word!

### 🎯 Fitur Utama

1. **Indentasi Otomatis**
   - Tekan `Tab` untuk indent paragraf
   - Tekan `Shift + Tab` untuk outdent
   - Button `⇥` (Indent) dan `⇤` (Outdent) di toolbar

2. **Line Spacing (Jarak Baris)**
   - Menu: `Format > Line Height`
   - Pilihan: 1.0, 1.15, 1.5, 2.0, 2.5, 3.0
   - Default: 1.5 (standar surat resmi)

3. **Style Preset untuk Surat**
   Klik dropdown **"Styles"** di toolbar:
   
   - ✅ **Judul Surat**: Tengah, Bold, Underline (14pt)
   - ✅ **Subjudul**: Tengah, Bold (12pt)
   - ✅ **Paragraf Normal**: Justify, Indent 50px, Line height 1.5
   - ✅ **Paragraf Tanpa Indent**: Justify, No indent
   - ✅ **Paragraf Tengah**: Center alignment
   - ✅ **Paragraf Kanan**: Right alignment (untuk tanda tangan)

4. **Menu Bar Lengkap**
   - **File**: Preview, Print
   - **Edit**: Undo/Redo, Cut/Copy/Paste, Find & Replace
   - **View**: Code view, Fullscreen
   - **Insert**: Link, Image, Table, Date/Time, Special Characters
   - **Format**: Bold/Italic, Alignment, Indent, Remove Format
   - **Table**: Insert/Edit table, Merge cells, Sort
   - **Tools**: Word count, Source code

5. **Toolbar Buttons**
   ```
   Undo/Redo | Styles Font Size | Bold Italic Underline Strike |
   Text Color BG Color | Align Left/Center/Right/Justify |
   Indent/Outdent | Lists | Quote Table | Link Image | Code Fullscreen
   ```

---

## 📖 CARA MENGGUNAKAN

### 1️⃣ Membuat Paragraf dengan Indentasi

**Metode A: Gunakan Style Preset** (RECOMMENDED)
```
1. Tulis paragraf kamu
2. Blok paragraf tersebut
3. Klik dropdown "Styles" di toolbar
4. Pilih "Paragraf Normal" (otomatis justify + indent 50px)
```

**Metode B: Manual dengan Tab**
```
1. Tulis paragraf kamu
2. Letakkan cursor di awal paragraf
3. Tekan tombol Tab di keyboard
4. Atau klik button Indent (⇥) di toolbar
```

**Metode C: HTML Custom** (Advanced)
```html
<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Teks paragraf dengan indent 50px...
</p>
```

---

### 2️⃣ Membuat Tabel Data (Seperti SKTM)

```
1. Klik button "Table" di toolbar
2. Pilih ukuran tabel (misalnya 2x7 untuk data SKTM)
3. Isi kolom kiri dengan label: Nama, NIK, TTL, dll
4. Isi kolom kanan dengan variable: {{nama}}, {{nik}}, dll
5. Klik kanan pada tabel > Table Properties:
   - Width: Auto atau 500px
   - Border: 0 (tanpa garis)
   - Cell padding: 2px
   - Cell spacing: 0px
6. Style tabel (optional):
   - Margin left: 50px (agar sejajar indent paragraf)
```

**Contoh HTML Tabel:**
```html
<table style="margin-left: 50px; margin-bottom: 15px; border: none;">
    <tbody>
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
    </tbody>
</table>
```

---

### 3️⃣ Format Judul Surat

**Untuk Judul Utama (Bold + Underline + Center):**
```
1. Tulis judul: SURAT KETERANGAN TIDAK MAMPU
2. Blok teks judul
3. Klik dropdown "Styles"
4. Pilih "Judul Surat"
5. Atau manual:
   - Klik "Bold" (B)
   - Klik "Underline" (U)
   - Klik "Center Align"
```

**Untuk Nomor Surat (Center, tanpa bold):**
```html
<p style="text-align: center; margin-bottom: 20px;">
    Nomor: {{nomor_surat}}
</p>
```

---

### 4️⃣ Membuat Footer Tanda Tangan

**Layout Kanan (Recommended):**
```
1. Klik dropdown "Styles"
2. Pilih "Paragraf Kanan"
3. Atau klik button "Right Align" di toolbar
4. Ketik:

Sumberjaya, {{tanggal_surat}}
{{jabatan}}


(tanda tangan + stempel)


{{penandatangan}}
NIP: {{nip}}
```

**Atau dengan Tabel (Layout Lebih Rapi):**
```html
<table style="width: 100%; border: none; margin-top: 30px;">
    <tbody>
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                <p>Sumberjaya, {{tanggal_surat}}</p>
                <p><strong>{{jabatan}}</strong></p>
                <br><br><br>
                <p><strong><u>{{penandatangan}}</u></strong></p>
                <p>NIP: {{nip}}</p>
            </td>
        </tr>
    </tbody>
</table>
```

---

## 🎨 TIPS & TRIK

### 1. Copy-Paste dari Microsoft Word
- ✅ **Bisa langsung paste!** Format akan tetap terjaga
- TinyMCE otomatis membersihkan kode kotor dari Word
- Gunakan `Ctrl + V` untuk paste biasa
- Gunakan `Ctrl + Shift + V` untuk paste tanpa format

### 2. Keyboard Shortcuts
| Shortcut | Fungsi |
|----------|--------|
| `Ctrl + B` | Bold |
| `Ctrl + I` | Italic |
| `Ctrl + U` | Underline |
| `Ctrl + E` | Center align |
| `Ctrl + J` | Justify align |
| `Ctrl + L` | Left align |
| `Ctrl + R` | Right align |
| `Tab` | Indent (paragraf) |
| `Shift + Tab` | Outdent |
| `Ctrl + Z` | Undo |
| `Ctrl + Y` | Redo |
| `Ctrl + F` | Find & Replace |
| `F11` | Fullscreen mode |

### 3. Fullscreen Mode untuk Fokus
```
1. Klik button "Fullscreen" di toolbar (atau tekan F11)
2. Editor akan memenuhi layar
3. Cocok untuk menulis template panjang
4. Tekan F11 lagi untuk keluar
```

### 4. Word Count (Hitung Kata)
- Lihat pojok kanan bawah editor
- Menampilkan jumlah kata dan karakter
- Berguna untuk mengecek panjang surat

### 5. Code View (HTML)
```
1. Klik Menu "View" > "Source code"
2. Atau klik button "</>" di toolbar
3. Edit HTML langsung (untuk user advanced)
4. Cocok untuk styling detail dengan CSS inline
```

---

## 🚀 CONTOH TEMPLATE LENGKAP SKTM

```html
<p style="text-align: center; margin-bottom: 5px;">
    <strong><u>SURAT KETERANGAN TIDAK MAMPU</u></strong>
</p>
<p style="text-align: center; margin-bottom: 20px;">
    Nomor: {{nomor_surat}}
</p>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan Kalianda 
    Kabupaten Lampung Selatan menerangkan bahwa:
</p>

<table style="margin-left: 50px; margin-bottom: 15px; border: none;">
    <tbody>
        <tr>
            <td width="200">Nama</td>
            <td>: <strong>{{nama}}</strong></td>
        </tr>
        <tr>
            <td>Tempat Tanggal Lahir</td>
            <td>: {{tempat_lahir}}, {{tanggal_lahir}}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{nik}}</td>
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
    </tbody>
</table>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Bahwa nama yang tercantum diatas adalah benar-benar berdomisili di Desa Sumberjaya, 
    Kecamatan Kalianda. Sepanjang pengamatan kami dan sesuai data yang ada dalam catatan 
    kependudukan orang tersebut diatas benar tergolong dalam keluarga prasejahtera 
    (Keluarga Berpenghasilan Rendah). Surat Keterangan ini diberikan untuk mendapatkan 
    bantuan berupa rehab/perbaikan rumah tempat tinggal.
</p>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5;">
    Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang 
    bersangkutan untuk dapat dipergunakan sebagaimana mestinya.
</p>
```

---

## 🔧 TROUBLESHOOTING

### Masalah: Indentasi tidak muncul di PDF
**Solusi:**
- Pastikan pakai `text-indent: 50px;` di style paragraf
- Atau gunakan style preset "Paragraf Normal"

### Masalah: Tabel terlalu lebar
**Solusi:**
- Klik kanan tabel > Table Properties
- Set width: Auto atau 500px
- Atau edit HTML: `<table style="width: auto;">`

### Masalah: Warna teks hilang di PDF
**Solusi:**
- Jangan gunakan warna putih (white)
- Gunakan hitam (#000000) untuk teks surat resmi
- DomPDF sudah otomatis set warna hitam

### Masalah: Line spacing tidak konsisten
**Solusi:**
- Gunakan style preset yang sudah disediakan
- Atau tambahkan `line-height: 1.5;` di setiap paragraf

---

## 📌 VARIABLE YANG TERSEDIA

### Data Surat Otomatis:
- `{{nomor_surat}}` - Nomor surat
- `{{lampiran}}` - Jumlah lampiran
- `{{perihal}}` - Perihal surat
- `{{tanggal_surat}}` - Tanggal surat (format: 10 November 2025)

### Data Penandatangan:
- `{{penandatangan}}` - Nama pejabat
- `{{jabatan}}` - Jabatan (Kepala Desa, Sekretaris Desa)
- `{{nip}}` - NIP pejabat

### Data Desa (dari Pengaturan Desa):
- `{{nama_desa}}` - Nama desa
- `{{nama_kecamatan}}` - Nama kecamatan
- `{{nama_kabupaten}}` - Nama kabupaten
- `{{nama_provinsi}}` - Nama provinsi
- `{{kode_pos}}` - Kode pos
- `{{email}}` - Email desa
- `{{telepon}}` - Telepon desa
- `{{website}}` - Website desa
- Dan 22+ variable lainnya (lihat Pengaturan Desa)

### Data Custom (sesuai Form Isian):
- `{{nama}}` - Nama warga
- `{{nik}}` - NIK
- `{{tempat_lahir}}` - Tempat lahir
- `{{tanggal_lahir}}` - Tanggal lahir
- `{{jenis_kelamin}}` - Jenis kelamin
- `{{agama}}` - Agama
- `{{pekerjaan}}` - Pekerjaan
- `{{alamat}}` - Alamat
- Dan variable custom lainnya sesuai kebutuhan template

---

## 💡 BEST PRACTICES

1. **Gunakan Style Preset** untuk konsistensi format
2. **Test di Preview Mode** sebelum save (Menu > File > Preview)
3. **Gunakan Fullscreen** untuk editing template panjang
4. **Copy-paste dari Word** jika sudah punya template jadi
5. **Gunakan Table** untuk data terstruktur (lebih rapi dari <br>)
6. **Set margin left 50px** untuk tabel agar sejajar dengan indent paragraf
7. **Line height 1.5** adalah standar surat resmi Indonesia
8. **Font Times New Roman 12pt** adalah default (sudah optimal)

---

## 🎓 KESIMPULAN

Dengan TinyMCE Full Version, kamu bisa:
- ✅ Edit seperti di Microsoft Word
- ✅ Indentasi otomatis dengan Tab
- ✅ Line spacing custom (1.0 - 3.0)
- ✅ Style preset untuk surat resmi
- ✅ Copy-paste dari Word tetap rapi
- ✅ Table editor lengkap
- ✅ Fullscreen mode
- ✅ Word count & character count
- ✅ Find & Replace
- ✅ HTML code view untuk advanced user

**Happy editing! 🎉**

---

💬 **Butuh bantuan?** Lihat menu **Help** di toolbar TinyMCE atau tekan `?` untuk keyboard shortcuts.
