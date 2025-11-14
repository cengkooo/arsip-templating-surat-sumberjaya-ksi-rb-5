# 🎨 CUSTOMIZATION KOP SURAT

## Perubahan yang Dilakukan

Kop surat PDF sekarang di-customize dengan format:

```
[LOGO 100x100]  PEMERINTAH KABUPATEN LAMPUNG SELATAN
(Kiri)          KECAMATAN JATI AGUNG
                DESA SUMBER JAYA
                
                Alamat lengkap & Contact
```

### Layout: **Flexbox Horizontal**
- Logo di sebelah **KIRI** (100x100px)
- Teks identitas di sebelah **KANAN** (center-aligned)
- Garis border bawah 3px solid hitam

---

## 📁 File yang Diubah

**File:** `resources/views/pdf/template.blade.php`

### Perubahan CSS:

```css
/* SEBELUM: Layout dengan posisi absolute */
.kop-surat {
    text-align: center;
    position: relative;
    min-height: 100px;
}

.kop-surat .logo {
    width: 110px;
    height: 110px;
    position: absolute;
    left: 10px;
    top: 25px;
}

/* SESUDAH: Layout dengan flexbox */
.kop-surat {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    min-height: 120px;
}

.kop-surat .logo {
    width: 100px;
    height: 100px;
    flex-shrink: 0;
    object-fit: contain;
}

.kop-surat .identitas {
    flex: 1;
    text-align: center;
}
```

### Perubahan HTML:

```html
<!-- SEBELUM: Logo di absolut, text di center padding -->
<div class="kop-surat">
    <img src="..." class="logo">
    <div class="identitas">
        <div class="nama-pemerintahan">
            <div>{{ strtoupper($desaSetting->nama_kabupaten) }}</div>
            ...
        </div>
    </div>
</div>

<!-- SESUDAH: Logo + Text di flex container -->
<div class="kop-surat">
    <!-- LOGO KIRI -->
    <img src="..." class="logo">
    
    <!-- IDENTITAS KANAN -->
    <div class="identitas">
        <div class="nama-pemerintahan">
            <div>PEMERINTAH KABUPATEN {{ strtoupper($desaSetting->nama_kabupaten) }}</div>
            <div>{{ strtoupper($desaSetting->nama_kecamatan) }}</div>
            <div>{{ strtoupper($desaSetting->nama_desa) }}</div>
        </div>
        ...
    </div>
</div>
```

**Perubahan Teks:**
- Tambah prefix "PEMERINTAH KABUPATEN" di baris pertama
- Setiap line dalam uppercase dan terpisah (flexbox auto-wrap)

---

## 🎯 Cara Menggunakan

### 1. Pastikan Pengaturan Desa Sudah Diisi:
- **Master Data → Pengaturan Desa → Tab DESA**
- Isi field:
  - Nama Kabupaten: `Lampung Selatan`
  - Nama Kecamatan: `Jati Agung`
  - Nama Desa: `Sumber Jaya`
  - Alamat Lengkap: `...`
  - Email, Telepon, Website (optional)

### 2. Upload Logo:
- **Master Data → Pengaturan Desa → Tab DESA → Logo Desa**
- Upload file PNG/JPG (ideal: 500x500px atau 100x100px)
- Save

### 3. Generate Surat:
- **Arsip Surat → Create from Template**
- Isi form
- Klik **Create**
- PDF di-generate otomatis

### 4. Download PDF:
- Klik tombol download PDF
- Logo + Kop surat sudah sesuai format

---

## 🔧 Cara Customize Lebih Lanjut

Jika mau ubah styling kop surat, edit file: `resources/views/pdf/template.blade.php`

### Contoh Customization:

**1. Ubah ukuran logo:**
```css
.kop-surat .logo {
    width: 80px;      /* Ubah dari 100px ke 80px */
    height: 80px;
}
```

**2. Ubah jarak antara logo dan text:**
```css
.kop-surat {
    gap: 30px;        /* Ubah dari 20px ke 30px */
}
```

**3. Ubah ukuran font:**
```css
.kop-surat .nama-pemerintahan {
    font-size: 14pt;  /* Ubah dari 16pt ke 14pt */
}
```

**4. Ubah ketebalan garis bawah:**
```css
.kop-surat {
    border-bottom: 2px solid #000;  /* Ubah dari 3px ke 2px */
}
```

---

## 📋 TIPS

1. **Logo tidak muncul?**
   - Pastikan file logo sudah diupload di Pengaturan Desa
   - Pastikan format file: PNG atau JPG
   - Cek ukuran file tidak terlalu besar (< 2MB)

2. **Text kop surat tidak sesuai?**
   - Pastikan data di Pengaturan Desa sudah benar
   - Setiap field akan ditampilkan dalam baris terpisah
   - Jika field kosong, baris itu tidak muncul

3. **Ingin layout vertikal (text di bawah logo)?**
   - Ubah `.kop-surat { flex-direction: column; }` di CSS
   - Tapi sesuaikan ukuran margin dan padding

4. **Ingin template berbeda per kategori?**
   - Buat template file terpisah di folder `resources/views/pdf/`
   - Gunakan conditional di blade untuk select template
   - Contoh: `@if($template->kategori_id === 1) ... @endif`

---

## ✅ Status

Kop surat sudah di-customize sesuai format gambar:
- ✅ Logo di kiri (100x100)
- ✅ Text di kanan (center)
- ✅ Format: PEMERINTAH KABUPATEN ... / KECAMATAN ... / DESA ...
- ✅ Garis bawah hitam
- ✅ Layout responsive

Server sudah running dengan kop surat baru. Silakan test dengan membuat surat dan download PDF! 🎉

