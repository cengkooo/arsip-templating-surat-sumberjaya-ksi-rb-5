# 📄 TEMPLATE HTML SKTM (Surat Keterangan Tidak Mampu)

## 🎯 TEMPLATE LENGKAP - SIAP PAKAI

Copy script di bawah ini dan paste ke field **"Tulis Template Isi Surat (HTML)"**

---

## 📝 ISI SURAT (BODY)

```html
<p style="text-align: center; margin: 0; margin-bottom: 5px;"><strong><u>SURAT KETERANGAN TIDAK MAMPU</u></strong></p>
<p style="text-align: center; margin: 0; margin-bottom: 20px;">Nomor: {{nomor_surat}}</p>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5; margin-bottom: 15px;">
Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan Kalianda Kabupaten Lampung Selatan menerangkan bahwa:
</p>

<table style="margin-left: 50px; margin-bottom: 15px; border: none; border-collapse: collapse;">
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Nama</td>
    <td style="padding: 3px 0;">: <strong>{{nama}}</strong></td>
</tr>
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Tempat Tanggal Lahir</td>
    <td style="padding: 3px 0;">: {{tempat_lahir}}, {{tanggal_lahir}}</td>
</tr>
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">NIK</td>
    <td style="padding: 3px 0;">: {{nik}}</td>
</tr>
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Jenis Kelamin</td>
    <td style="padding: 3px 0;">: {{jenis_kelamin}}</td>
</tr>
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Agama</td>
    <td style="padding: 3px 0;">: {{agama}}</td>
</tr>
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Pekerjaan</td>
    <td style="padding: 3px 0;">: {{pekerjaan}}</td>
</tr>
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Alamat</td>
    <td style="padding: 3px 0;">: {{alamat}}</td>
</tr>
</table>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5; margin-bottom: 15px;">
Bahwa nama yang tercantum diatas adalah benar-benar berdomisili di Desa Sumberjaya, Kecamatan Kalianda. Sepanjang pengamatan kami dan sesuai data yang ada dalam catatan kependudukan orang tersebut diatas benar tergolong dalam keluarga prasejahtera (Keluarga Berpenghasilan Rendah). Surat Keterangan ini diberikan untuk mendapatkan bantuan berupa rehab/perbaikan rumah tempat tinggal.
</p>

<p style="text-align: justify; text-indent: 50px; line-height: 1.5; margin-bottom: 15px;">
Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya.
</p>
```

---

## ✍️ FOOTER (TANDA TANGAN)

```html
<table style="width: 100%; border: none; margin-top: 30px;">
<tr>
    <td style="width: 50%; border: none;"></td>
    <td style="width: 50%; text-align: center; border: none;">
        <p style="margin: 0; margin-bottom: 5px;">Sumberjaya, {{tanggal_surat}}</p>
        <p style="margin: 0; margin-bottom: 80px;"><strong>{{jabatan}}</strong></p>
        <p style="margin: 0; margin-bottom: 0;"><strong><u>{{penandatangan}}</u></strong></p>
        <p style="margin: 0;">NIP: {{nip}}</p>
    </td>
</tr>
</table>
```

---

## 📋 HEADER (OPTIONAL - Nomor, Lampiran, Perihal)

Kalau mau tambahkan header sebelum judul surat, paste ini ke field **"Header Tambahan (Optional)"**:

```html
<table style="width: 100%; border: none; margin-bottom: 20px;">
<tr>
    <td style="width: 100px; border: none; vertical-align: top;">Nomor</td>
    <td style="width: 20px; border: none; vertical-align: top;">:</td>
    <td style="border: none;">{{nomor_surat}}</td>
</tr>
<tr>
    <td style="width: 100px; border: none; vertical-align: top;">Lampiran</td>
    <td style="width: 20px; border: none; vertical-align: top;">:</td>
    <td style="border: none;">{{lampiran}}</td>
</tr>
<tr>
    <td style="width: 100px; border: none; vertical-align: top;">Perihal</td>
    <td style="width: 20px; border: none; vertical-align: top;">:</td>
    <td style="border: none;">{{perihal}}</td>
</tr>
</table>
```

---

## 🔧 VARIABLE YANG DIGUNAKAN

Setelah paste template di atas, jangan lupa buat **Form Isian** di tab "Form Isian":

### Variable yang Harus Dibuat:

1. **nama** (Text Input)
   - Label: "Nama Lengkap"
   - Placeholder: "Contoh: Ahmad Suherman"
   - Required: Yes

2. **tempat_lahir** (Text Input)
   - Label: "Tempat Lahir"
   - Placeholder: "Contoh: Lampung Selatan"
   - Required: Yes

3. **tanggal_lahir** (Text Input atau Date Picker)
   - Label: "Tanggal Lahir"
   - Placeholder: "Contoh: 15 Agustus 1980"
   - Required: Yes

4. **nik** (Text Input)
   - Label: "NIK (Nomor Induk Kependudukan)"
   - Placeholder: "Contoh: 1234567890123456"
   - Max Length: 16
   - Required: Yes

5. **jenis_kelamin** (Select)
   - Label: "Jenis Kelamin"
   - Options: Laki-laki, Perempuan
   - Required: Yes

6. **agama** (Select)
   - Label: "Agama"
   - Options: Islam, Kristen, Katolik, Hindu, Buddha, Konghucu
   - Required: Yes

7. **pekerjaan** (Text Input)
   - Label: "Pekerjaan"
   - Placeholder: "Contoh: Petani, Buruh, Wiraswasta"
   - Required: Yes

8. **alamat** (Textarea)
   - Label: "Alamat Lengkap"
   - Placeholder: "Contoh: Jl. Raya Sumberjaya No. 123 RT 001 RW 002"
   - Rows: 3
   - Required: Yes

---

## 📖 CARA PAKAI (STEP-BY-STEP)

### 1️⃣ Buat Template Baru

```
Master Data → Template Surat → Create
```

### 2️⃣ Tab "Umum"

- **Nama Template**: SKTM
- **Kategori**: Pilih "Surat Keluar" atau buat kategori baru "Surat Keterangan"
- **Ukuran Kertas**: F4
- **Orientasi**: Portrait
- **Is Active**: ✅ (centang)

### 3️⃣ Tab "Template"

#### Bagian "Isi Surat":
1. Scroll ke bawah
2. Copy script **ISI SURAT** di atas
3. Paste ke field "Tulis Template Isi Surat (HTML)"

#### Bagian "Footer":
1. Scroll ke bawah
2. Copy script **FOOTER** di atas
3. Paste ke field "Tulis Template Footer (HTML)"

#### Bagian "Header" (Optional):
1. Kalau mau pakai header Nomor/Lampiran/Perihal
2. Copy script **HEADER** di atas
3. Paste ke field "Header Tambahan (Optional)"

### 4️⃣ Tab "Form Isian"

Klik **"+ Add Variable"** dan buat 8 variable sesuai daftar di atas:

#### Variable 1:
- Name: `nama`
- Label: `Nama Lengkap`
- Type: `text`
- Required: ✅

#### Variable 2:
- Name: `tempat_lahir`
- Label: `Tempat Lahir`
- Type: `text`
- Required: ✅

#### Variable 3:
- Name: `tanggal_lahir`
- Label: `Tanggal Lahir`
- Type: `text`
- Placeholder: `Contoh: 15 Agustus 1980`
- Required: ✅

#### Variable 4:
- Name: `nik`
- Label: `NIK (Nomor Induk Kependudukan)`
- Type: `text`
- Placeholder: `16 digit`
- Required: ✅

#### Variable 5:
- Name: `jenis_kelamin`
- Label: `Jenis Kelamin`
- Type: `select`
- Options: `Laki-laki,Perempuan` (pisah pakai koma)
- Required: ✅

#### Variable 6:
- Name: `agama`
- Label: `Agama`
- Type: `select`
- Options: `Islam,Kristen,Katolik,Hindu,Buddha,Konghucu`
- Required: ✅

#### Variable 7:
- Name: `pekerjaan`
- Label: `Pekerjaan`
- Type: `text`
- Placeholder: `Contoh: Petani`
- Required: ✅

#### Variable 8:
- Name: `alamat`
- Label: `Alamat Lengkap`
- Type: `textarea`
- Rows: `3`
- Required: ✅

### 5️⃣ Save Template

Klik **"Create"** atau **"Save"**

---

## 🎨 HASIL AKHIR (PREVIEW)

Setelah generate surat, hasilnya akan seperti ini:

```
                    SURAT KETERANGAN TIDAK MAMPU
                          Nomor: 001/SKTM/2025

    Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan 
Kalianda Kabupaten Lampung Selatan menerangkan bahwa:

Nama                    : Ahmad Suherman
Tempat Tanggal Lahir    : Lampung Selatan, 15 Agustus 1980
NIK                     : 1234567890123456
Jenis Kelamin           : Laki-laki
Agama                   : Islam
Pekerjaan               : Petani
Alamat                  : Jl. Raya Sumberjaya No. 123 RT 001 RW 002

    Bahwa nama yang tercantum diatas adalah benar-benar berdomisili di 
Desa Sumberjaya, Kecamatan Kalianda. Sepanjang pengamatan kami dan sesuai 
data yang ada dalam catatan kependudukan orang tersebut diatas benar 
tergolong dalam keluarga prasejahtera (Keluarga Berpenghasilan Rendah). 
Surat Keterangan ini diberikan untuk mendapatkan bantuan berupa 
rehab/perbaikan rumah tempat tinggal.

    Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan 
kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya.


                                                Sumberjaya, 10 November 2025
                                                Kepala Desa Sumberjaya



                                                ___________________________
                                                        John Doe
                                                    NIP: 123456789012
```

---

## 💡 TIPS MODIFIKASI

### Ubah Tujuan Surat

Ganti bagian ini:
```html
Surat Keterangan ini diberikan untuk mendapatkan bantuan berupa rehab/perbaikan rumah tempat tinggal.
```

Dengan tujuan lain, misalnya:
- "untuk melengkapi persyaratan beasiswa pendidikan"
- "untuk keperluan pengajuan bantuan sosial"
- "untuk keperluan administrasi di instansi terkait"

### Tambah Field Baru

Kalau mau tambah data "Nama Ibu", tambahkan di tabel:
```html
<tr>
    <td style="width: 200px; padding: 3px 0; vertical-align: top;">Nama Ibu</td>
    <td style="padding: 3px 0;">: {{nama_ibu}}</td>
</tr>
```

Jangan lupa buat variable `nama_ibu` di tab "Form Isian"!

### Ganti Nama Desa/Kecamatan

Ganti bagian ini dengan data desa kamu:
```html
Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan Kalianda Kabupaten Lampung Selatan menerangkan bahwa:
```

Atau pakai variable dari Pengaturan Desa:
```html
Yang bertanda tangan di bawah ini Kepala Desa {{nama_desa}} Kecamatan {{nama_kecamatan}} Kabupaten {{nama_kabupaten}} menerangkan bahwa:
```

---

## 🚀 TEST TEMPLATE

Setelah save template:

1. **Klik "Gunakan Template"** di halaman view template
2. **Isi form** Data Surat (Nomor, Lampiran, Perihal)
3. **Isi form** Data Isian (8 variable yang sudah dibuat)
4. **Isi form** Penandatangan
5. **Klik "Generate PDF"**
6. **Download** dan lihat hasilnya!

---

## ❓ TROUBLESHOOTING

### Masalah: Variable tidak terganti

**Solusi**: Pastikan nama variable di HTML sama persis dengan name di Form Isian:
- HTML: `{{nama}}` → Form Isian name: `nama` ✅
- HTML: `{{nama}}` → Form Isian name: `nama_lengkap` ❌

### Masalah: Tabel terlalu rapat

**Solusi**: Tambahkan padding lebih besar:
```html
<td style="padding: 5px 0;">
```

### Masalah: Paragraf tidak indent

**Solusi**: Pastikan ada `text-indent: 50px;` di setiap paragraf:
```html
<p style="text-align: justify; text-indent: 50px;">
```

---

**Happy Generating! 🎉 Kalau ada yang perlu diubah, tinggal edit HTML-nya aja!**
