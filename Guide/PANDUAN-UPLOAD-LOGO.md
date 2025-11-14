# 📝 PANDUAN UPLOAD LOGO KOP SURAT

## 🎯 Langkah-langkah Upload Logo Lampung Selatan

### 1. **Persiapan Logo**
- Gunakan file logo yang sudah kamu kirim: `logo-lampung-selatan.png`
- Format: PNG atau JPG
- Ukuran disarankan: 500x500px (persegi)
- Maksimal file: 2MB

### 2. **Upload via Admin Panel**

1. Login ke admin panel: `http://127.0.0.1:8000/admin`
2. Klik menu **Master Data** → **Pengaturan Desa**
3. Klik tombol **Edit** (icon pensil)
4. Di section **Logo Desa**, klik area upload
5. Pilih file logo Lampung Selatan
6. Crop logo jika perlu (gunakan aspect ratio 1:1 / persegi)
7. Klik **Save**

### 3. **Verifikasi Logo Terupload**

Setelah save, logo akan tersimpan di:
```
storage/app/public/logo-desa/[nama-file].png
```

Dan bisa diakses via URL:
```
http://127.0.0.1:8000/storage/logo-desa/[nama-file].png
```

---

## 🔍 Cara Kerja Logo di Kop Surat

### Otomatis Muncul di PDF
Logo akan **otomatis muncul** di semua PDF yang digenerate dengan:

1. **Posisi**: Kiri atas kop surat
2. **Ukuran**: 80x80px (otomatis resize)
3. **Format**: Base64 embedded (tidak perlu akses file eksternal)

### Kontrol Tampilan Logo
Di form **Template Surat** → Tab **Umum**:

- Toggle **"Tampilkan Logo Garuda"**: 
  - ✅ ON = Logo tampil di PDF
  - ❌ OFF = Logo tidak tampil

---

## 📋 Template Kop Surat yang Akan Muncul

```
[LOGO]              KABUPATEN LAMPUNG SELATAN
                    KECAMATAN KALIANDA
                    DESA SUMBERJAYA
                    Jl. Way Urang No. 123 Sumberjaya Kode Pos 35551
                    Telp: 0727-123456 | Email: desa.sumberjaya@lampungselatan.go.id
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

---

## ✅ Checklist Setelah Upload

- [ ] Logo sudah terupload di Pengaturan Desa
- [ ] Preview logo terlihat di form edit
- [ ] Buat template surat baru dengan "Tampilkan Logo" = ON
- [ ] Generate surat test
- [ ] Download PDF dan cek logo muncul di kiri atas
- [ ] Logo terlihat jelas (tidak blur/pecah)

---

## 🚨 Troubleshooting

### Logo tidak muncul di PDF?
1. Pastikan toggle "Tampilkan Logo Garuda" = ON di template
2. Cek logo sudah terupload di Pengaturan Desa
3. Jalankan: `php artisan storage:link` (jika belum)
4. Clear cache: `php artisan cache:clear`

### Logo blur/pecah?
- Upload logo dengan resolusi lebih tinggi (min 500x500px)
- Gunakan format PNG (lebih bagus dari JPG)

### Logo terlalu besar/kecil?
- Ukuran di PDF fixed: 80x80px
- Pastikan logo upload berbentuk persegi (1:1)

---

## 📞 Quick Reference

**File Config:**
- Model: `app/Models/DesaSetting.php`
- Resource: `app/Filament/Resources/DesaSettingResource.php`
- PDF Template: `resources/views/pdf/template.blade.php`
- Service: `app/Services/PdfGeneratorService.php`

**Storage Path:**
```
storage/app/public/logo-desa/  ← Logo tersimpan di sini
public/storage/logo-desa/      ← Symlink (harus ada)
```

**Database:**
```sql
SELECT logo_path FROM desa_settings WHERE is_active = 1;
```

---

Selamat mencoba! 🎉
