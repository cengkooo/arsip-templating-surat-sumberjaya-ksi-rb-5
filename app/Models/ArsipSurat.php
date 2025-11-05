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
        'nomor_surat',
        'tanggal_surat',
        'tanggal_terima',
        'perihal',
        'isi_ringkas',
        'pengirim',
        'penerima',
        'file_path',
        'status',
        'jenis',
        'catatan',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima' => 'date',
    ];

    // Relationship: Arsip milik 1 kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    // Helper: Get full file URL
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}