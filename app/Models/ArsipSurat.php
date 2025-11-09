<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArsipSurat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id',
        'template_surat_id',
        'user_id',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_terima',
        'perihal',
        'isi_ringkas',
        'pengirim',
        'penerima',
        'data_variables',
        'content_final',
        'nama_penandatangan',
        'jabatan_penandatangan',
        'nip_penandatangan',
        'file_path',
        'status',
        'jenis',
        'catatan',
        'generated_at',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima' => 'date',
        'data_variables' => 'array',
        'content_final' => 'array',
        'generated_at' => 'datetime',
    ];

    // Relationship: Arsip milik 1 kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    
    // Relationship: Arsip dari template surat
    public function templateSurat(): BelongsTo
    {
        return $this->belongsTo(TemplateSurat::class);
    }
    
    // Relationship: Arsip dibuat oleh user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Get full file URL
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}