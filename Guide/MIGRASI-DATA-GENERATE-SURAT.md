# 🔄 Panduan Migrasi Data Generate Surat ke Arsip Surat

## ⚠️ Informasi Penting

Menu **Generate Surat** sudah **DEPRECATED** dan digabung ke **Arsip Surat**.

---

## 🎯 Yang Berubah

### ❌ Menu Lama (Deprecated):
- **Generate Surat** - Sudah disembunyikan dari navigasi
- Data lama masih ada di database tapi tidak bisa generate PDF lagi

### ✅ Menu Baru (Aktif):
- **Arsip Surat** - Sudah include fitur generate surat
- 2 Tombol:
  - 🟢 **Buat Surat dari Template** → Generate otomatis jadi PDF
  - ⚪ **Tambah Surat Manual** → Input surat existing

---

## 📊 Status Data Lama

Jika Anda punya data di tabel `surat_generates`:

### Opsi 1: Hapus Data Lama ✅ (Disarankan)
**Jika surat belum penting:**
1. Masuk ke menu Generate Surat (masih bisa diakses via URL langsung)
2. Klik tombol **Hapus Data Lama**
3. Buat ulang surat di menu **Arsip Surat → Buat dari Template**

**Keuntungan:**
- Database bersih
- Pakai sistem baru yang lebih baik
- PDF otomatis generate dengan kop surat

### Opsi 2: Migrasi Manual (Untuk Data Penting)
**Jika surat sudah penting dan perlu disimpan:**

1. **Export data lama** (via phpMyAdmin/Adminer):
   ```sql
   SELECT * FROM surat_generates WHERE status != 'draft';
   ```

2. **Buat ulang di Arsip Surat**:
   - Buka **Arsip Surat → Buat dari Template**
   - Pilih template yang sama
   - Copy data dari export
   - Paste ke form baru
   - Generate PDF baru

3. **Hapus data lama** setelah berhasil migrate

### Opsi 3: Biarkan Saja
**Jika tidak butuh akses:**
- Data lama akan tetap ada di database
- Tidak mengganggu sistem baru
- Bisa dihapus kapan saja nanti

---

## 🔧 Migrasi Otomatis (Developer)

Jika ingin migrate semua data secara otomatis, bisa run script:

```php
// Script migrasi otomatis (belum dibuat)
// File: database/migrations/migrate_surat_generates_to_arsip_surats.php

use App\Models\SuratGenerate;
use App\Models\ArsipSurat;

$oldSurats = SuratGenerate::all();

foreach ($oldSurats as $old) {
    ArsipSurat::create([
        'kategori_id' => $old->templateSurat->kategori_id,
        'nomor_surat' => $old->nomor_surat,
        'tanggal_surat' => $old->tanggal_surat,
        'perihal' => $old->templateSurat->nama_template,
        'jenis' => 'keluar',
        'status' => $old->status === 'final' ? 'selesai' : 'draft',
        'template_surat_id' => $old->template_surat_id,
        'user_id' => $old->user_id,
        'data_variables' => $old->data_variables,
        'content_final' => $old->content_final,
        'nama_penandatangan' => $old->nama_penandatangan,
        'jabatan_penandatangan' => $old->jabatan_penandatangan,
        'nip_penandatangan' => $old->nip_penandatangan,
        'generated_at' => $old->generated_at,
        'catatan' => $old->catatan,
        'created_at' => $old->created_at,
        'updated_at' => $old->updated_at,
    ]);
    
    // Generate ulang PDF dengan sistem baru
    $pdfService = app(\App\Services\PdfGeneratorService::class);
    $pdfService->generate($arsipSurat);
}
```

**Catatan:**
- Script ini akan migrate semua data lama ke tabel baru
- PDF akan digenerate ulang dengan kop surat
- Data lama tidak dihapus otomatis (manual delete)

---

## 🗑️ Hapus Tabel Lama (Setelah Migrasi)

**⚠️ Hanya lakukan setelah yakin semua data sudah dimigrate!**

```sql
-- Backup dulu sebelum drop!
DROP TABLE IF EXISTS surat_generates;
```

Atau via migration:
```bash
php artisan make:migration drop_surat_generates_table
```

```php
public function up()
{
    Schema::dropIfExists('surat_generates');
}
```

---

## ❓ FAQ

### Q: Apakah data lama akan hilang?
**A:** Tidak, data tetap ada di database. Hanya tidak bisa generate PDF dari menu lama.

### Q: Bagaimana cara akses menu Generate Surat lama?
**A:** Via URL langsung: `http://your-domain/admin/surat-generates`
Menu ini hidden dari navigasi tapi masih bisa diakses.

### Q: Apakah PDF lama masih bisa didownload?
**A:** Ya, jika sudah pernah digenerate. File PDF tetap ada di storage.

### Q: Harus migrate semua data?
**A:** Tidak wajib. Bisa buat surat baru langsung di menu baru. Data lama biarkan saja atau hapus.

### Q: Kenapa fiturnya digabung?
**A:** Untuk menyederhanakan workflow. Lebih masuk akal jika generate surat langsung tersimpan ke arsip, bukan tabel terpisah.

---

## 📞 Bantuan

Jika ada kesulitan migrasi data:
1. Backup database dulu
2. Export data penting dari tabel `surat_generates`
3. Buat ulang di menu **Arsip Surat**
4. Hapus data lama setelah berhasil

---

**Versi:** 1.0  
**Terakhir Update:** November 2025
