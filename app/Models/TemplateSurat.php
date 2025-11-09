<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateSurat extends Model
{
    protected $fillable = [
        'kategori_id',
        'nama_template',
        'kode_template',
        'keterangan',
        'content_header',
        'content_body',
        'content_footer',
        'variables',
        'orientasi',
        'ukuran_kertas',
        'is_active',
        'usage_count',
        // Advanced settings
        'margin_kiri',
        'margin_kanan',
        'margin_atas',
        'margin_bawah',
        'tampilkan_qrcode',
        'tampilkan_header',
        'header_type',
        'tampilkan_footer',
        'tampilkan_logo',
        'format_nomor',
        'lampiran_template',
    ];

    protected $casts = [
        'variables' => 'array', // Auto convert JSON to array
        'is_active' => 'boolean',
        'tampilkan_qrcode' => 'boolean',
        'tampilkan_header' => 'boolean',
        'tampilkan_footer' => 'boolean',
        'tampilkan_logo' => 'boolean',
        'margin_kiri' => 'decimal:2',
        'margin_kanan' => 'decimal:2',
        'margin_atas' => 'decimal:2',
        'margin_bawah' => 'decimal:2',
    ];

    // Relationship
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function suratGenerates(): HasMany
    {
        return $this->hasMany(SuratGenerate::class);
    }

    // Helper: Increment usage count
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}