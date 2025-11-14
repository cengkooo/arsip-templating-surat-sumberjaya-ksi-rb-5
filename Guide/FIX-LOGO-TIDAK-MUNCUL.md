# 🚨 FIX: Logo Tidak Muncul - SOLUSI CEPAT

## Masalah:
`logo_path` di database masih `NULL` → Logo belum diupload

## ✅ Solusi 1: Upload via Admin Panel (REKOMENDASI)

1. **Download logo** dari attachment chat (logo Lampung Selatan yang bulat)
2. Save sebagai: `logo-lampung-selatan.png`
3. Buka browser: `http://127.0.0.1:8000/admin`
4. Menu: **Master Data** → **Pengaturan Desa**
5. Klik tombol **Edit** (icon pensil kuning)
6. Section **Logo Desa** → Klik area upload
7. Pilih file `logo-lampung-selatan.png`
8. **Crop** jadi persegi (1:1) jika diminta
9. Klik **Save**
10. **SELESAI!** Logo otomatis tersimpan

---

## ⚡ Solusi 2: Manual Copy File (QUICK FIX)

Jika upload via admin error, pakai cara ini:

### Step 1: Copy Logo ke Storage
```powershell
# 1. Download logo dari attachment
# 2. Rename jadi: logo-lampung-selatan.png
# 3. Copy ke folder:
Copy-Item "C:\Downloads\logo-lampung-selatan.png" "D:\arsip-templating-surat-sumberjaya-ksi-rb-5\storage\app\public\logo-desa\logo-lampung-selatan.png"
```

### Step 2: Update Database
```powershell
php artisan tinker
```

Lalu di tinker ketik:
```php
$desa = App\Models\DesaSetting::first();
$desa->logo_path = 'logo-desa/logo-lampung-selatan.png';
$desa->save();
exit
```

### Step 3: Verify
```powershell
php artisan tinker --execute="echo App\Models\DesaSetting::first()->logo_path;"
```

Harus keluar: `logo-desa/logo-lampung-selatan.png`

---

## 🔍 Cek Logo Bisa Diakses

Test URL ini di browser:
```
http://127.0.0.1:8000/storage/logo-desa/logo-lampung-selatan.png
```

Jika muncul gambar → **BERHASIL!** ✅

---

## 🎯 Testing Generate PDF

Setelah logo terupload:

1. Buka **Template Surats** → Edit template yang sudah ada
2. Tab **Umum** → Cek toggle **"Tampilkan Logo Garuda"** = **ON** ✅
3. Tab **Umum** → Cek **"Tampilkan Header"** = **ON** ✅
4. Save template
5. Generate Surat baru
6. Download PDF
7. **LOGO HARUS MUNCUL!** 🎉

---

## ⚠️ Troubleshooting

### Logo masih tidak muncul?

**Cek 1: Logo path di database**
```bash
php artisan tinker --execute="dd(App\Models\DesaSetting::first()->logo_path);"
```
Harus: `"logo-desa/logo-lampung-selatan.png"`

**Cek 2: File fisik ada**
```bash
Test-Path "storage\app\public\logo-desa\logo-lampung-selatan.png"
```
Harus: `True`

**Cek 3: Template setting**
```bash
php artisan tinker --execute="dd(App\Models\TemplateSurat::first()->only(['tampilkan_logo', 'tampilkan_header']));"
```
Harus: 
```
array:2 [
  "tampilkan_logo" => true
  "tampilkan_header" => true
]
```

**Cek 4: Symlink storage**
```bash
php artisan storage:link
```

---

## 📝 Quick Reference

**Storage Path:**
```
storage/app/public/logo-desa/logo-lampung-selatan.png  ← File fisik
public/storage/logo-desa/logo-lampung-selatan.png      ← Symlink (akses web)
```

**Database:**
```sql
UPDATE desa_settings 
SET logo_path = 'logo-desa/logo-lampung-selatan.png' 
WHERE id = 1;
```

---

Pilih **Solusi 1** (via admin) atau **Solusi 2** (manual), lalu test lagi! 🚀
