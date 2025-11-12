# 📋 SPESIFIKASI VARIABLE FORM - Surat Desa

## Daftar Lengkap Variable dengan Input Type & Format

| No | Variabel            | Jenis Data        | Input Type (Filament)                                                                            | Format Tampilan di Surat         | Catatan / Tips                          |
| -- | ------------------- | ----------------- | ------------------------------------------------------------------------------------------------ | -------------------------------- | --------------------------------------- |
| 1  | `nama`              | String            | `TextInput::make('nama')->required()`                                                            | Huruf kapital awal (`ucwords()`) | Gunakan untuk nama penerima/pemohon     |
| 2  | `nik`               | String (16 digit) | `TextInput::make('nik')->mask('9999999999999999')`                                               | Tanpa spasi                      | Validasi panjang 16                     |
| 3  | `no_kk`             | String (16 digit) | `TextInput::make('no_kk')->mask('9999999999999999')`                                             | Tanpa spasi                      | Opsional sesuai surat                   |
| 4  | `tempat_lahir`      | String            | `TextInput::make('tempat_lahir')`                                                                | Huruf kapital awal               | Dikombinasi dengan `tanggal_lahir`      |
| 5  | `tanggal_lahir`     | Date              | `DatePicker::make('tanggal_lahir')->displayFormat('d F Y')`                                      | Format: *20 Juli 2001*           | Bisa juga tampil `SDK, 20 Juli 2001`    |
| 6  | `jenis_kelamin`     | Enum              | `Select::make('jenis_kelamin')->options(['Pria'=>'Pria','Wanita'=>'Wanita'])`                    | Teks langsung                    | Untuk template bisa `{{jenis_kelamin}}` |
| 7  | `alamat`            | Text              | `Textarea::make('alamat')->rows(2)`                                                              | Langsung teks multiline          | Pastikan trim spasi                     |
| 8  | `rt`                | Integer/String    | `TextInput::make('rt')`                                                                          | RT 01                            |                                         |
| 9  | `rw`                | Integer/String    | `TextInput::make('rw')`                                                                          | RW 05                            |                                         |
| 10 | `dusun`             | String            | `TextInput::make('dusun')`                                                                       | Dusun I / Dusun Melati           | Optional                                |
| 11 | `kelurahan`         | String            | `TextInput::make('kelurahan')`                                                                   | Kelurahan Sumberjaya             | Bisa auto dari data desa                |
| 12 | `kecamatan`         | String            | `TextInput::make('kecamatan')`                                                                   | Kecamatan Kalianda               | Bisa auto dari pengaturan desa          |
| 13 | `kabupaten`         | String            | `TextInput::make('kabupaten')`                                                                   | Kabupaten Lampung Selatan        | Bisa auto dari pengaturan desa          |
| 14 | `provinsi`          | String            | `TextInput::make('provinsi')`                                                                    | Provinsi Lampung                 | Auto dari pengaturan desa               |
| 15 | `agama`             | Enum              | `Select::make('agama')->options(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'])`      | Huruf kapital awal               |                                         |
| 16 | `status_perkawinan` | Enum              | `Select::make('status_perkawinan')->options(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'])` | Huruf kapital awal               |                                         |
| 17 | `pekerjaan`         | String            | `TextInput::make('pekerjaan')`                                                                   | Huruf kapital awal               |                                         |
| 18 | `kewarganegaraan`   | Enum              | `Select::make('kewarganegaraan')->options(['WNI'=>'WNI','WNA'=>'WNA'])`                          | Huruf kapital                    | Default: WNI                            |
| 19 | `berlaku_hingga`    | Date              | `DatePicker::make('berlaku_hingga')->displayFormat('d F Y')`                                     | Format *s.d. 31 Desember 2025*   | Tambah teks otomatis "s.d."             |
| 20 | `keperluan`         | Text              | `Textarea::make('keperluan')->rows(2)`                                                           | Langsung teks                    | Bisa juga gunakan autocomplete          |
| 21 | `keterangan`        | Text              | `Textarea::make('keterangan')->rows(3)`                                                          | Langsung teks                    | Untuk catatan tambahan                  |

---

## 📝 Implementasi di CreateFromTemplate.php

Semua variable di atas sudah **fully implemented** di file:
- **Path**: `app/Filament/Resources/ArsipSuratResource/Pages/CreateFromTemplate.php`
- **Method**: `getFormFieldForVariable($variable)`
- **Behavior**: Otomatis detect variable name dan render form field yang sesuai

### Contoh Penggunaan:

```php
$field = $this->getFormFieldForVariable('nik');
// Output: TextInput dengan mask 9999999999999999

$field = $this->getFormFieldForVariable('jenis_kelamin');
// Output: Select dropdown dengan pilihan Pria/Wanita

$field = $this->getFormFieldForVariable('tanggal_lahir');
// Output: DatePicker dengan format d F Y
```

---

## 🎯 Cara Menambah Variable Baru ke Template

1. **Edit Template SKTM** → Tab "FORM ISIAN"
2. **Tambah Variable** dengan nama sesuai tabel di atas
3. **Save Template**
4. **Generate Surat** → Form field otomatis muncul dengan input type yang tepat

### Contoh:
Jika ingin tambah variable `agama`:
```
Variables: nama, nik, tanggal_lahir, agama
```

Maka form akan muncul dengan:
- ✅ nama → TextInput required
- ✅ nik → TextInput dengan mask 16 digit
- ✅ tanggal_lahir → DatePicker
- ✅ agama → Select dropdown (Islam, Kristen, dll)

---

## ✅ Format Tampilan di PDF

Setiap variable akan di-replace di HTML template dengan format yang sesuai:

### Text Variables:
```html
<!-- Input: Andryano -->
Nama: {{nama}}
<!-- Output: Nama: Andryano -->
```

### Date Variables:
```html
<!-- Input: 20 Juli 2001 -->
Tanggal Lahir: {{tanggal_lahir}}
<!-- Output: Tanggal Lahir: 20 Juli 2001 -->
```

### Enum Variables:
```html
<!-- Input: Pria (dari dropdown) -->
Jenis Kelamin: {{jenis_kelamin}}
<!-- Output: Jenis Kelamin: Pria -->
```

### Special Format (Berlaku Hingga):
```html
<!-- Input: 31 Desember 2025 -->
Berlaku: {{berlaku_hingga}}
<!-- Output: Berlaku: s.d. 31 Desember 2025 -->
```

---

## 🔧 Modifikasi Input Type

Jika perlu mengubah input type untuk variable tertentu, edit method `getFormFieldForVariable()`:

### Contoh Penambahan Validasi:
```php
'nik' => Forms\Components\TextInput::make($fieldKey)
    ->label('NIK')
    ->required()
    ->mask('9999999999999999')
    ->validate('digits:16')  // Tambah validasi
    ->placeholder('1234567890123456')
    ->helperText($helperText . ' (16 digit)'),
```

### Contoh Ubah Input Type Agama ke Autocomplete:
```php
'agama' => Forms\Components\Autocomplete::make($fieldKey)
    ->label('Agama')
    ->options([/* options */])
    ->searchable()
    ->helperText($helperText),
```

---

## 📊 Variable Grouping (Rekomendasi untuk Form Layout)

Untuk membuat form lebih terstruktur, rekomendasi grouping variable:

### **Identitas Pribadi:**
- nama
- nik
- no_kk
- jenis_kelamin

### **Tempat Tanggal Lahir:**
- tempat_lahir
- tanggal_lahir

### **Alamat:**
- alamat
- rt
- rw
- dusun
- kelurahan
- kecamatan
- kabupaten
- provinsi

### **Lainnya:**
- agama
- status_perkawinan
- pekerjaan
- kewarganegaraan
- keperluan
- keterangan

### **Valid Hingga:**
- berlaku_hingga

---

## 🚀 Testing Variable Form

### Test Case: Buat Surat dengan Semua Variable

1. **Create Template SKTM** dengan variables:
   ```
   nama, nik, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, 
   rt, rw, dusun, kelurahan, kecamatan, kabupaten, provinsi, status_perkawinan, 
   pekerjaan, kewarganegaraan, berlaku_hingga, keperluan, keterangan
   ```

2. **Generate Surat** dari template
3. **Verify** setiap field muncul dengan input type yang tepat:
   - ✅ nama → TextInput
   - ✅ nik → TextInput dengan mask
   - ✅ tanggal_lahir → DatePicker
   - ✅ jenis_kelamin → Dropdown (Pria/Wanita)
   - ✅ agama → Dropdown (6 pilihan)
   - ✅ dst...

4. **Download PDF** dan verify format tampilan sesuai spesifikasi

---

## 📌 Notes

- Semua field dengan `required()` harus diisi sebelum submit
- Field tanpa `required()` adalah opsional
- DatePicker menggunakan format Indonesia (d F Y = 20 Juli 2001)
- Dropdown menggunakan native: false (styled Filament)
- Textarea fields auto-column full width untuk readability
- Mask input untuk NIK dan No KK membantu user input format yang benar

---

**Last Updated:** 12 November 2025  
**Version:** 1.0 - Complete Implementation
