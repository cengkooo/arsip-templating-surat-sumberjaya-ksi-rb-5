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
    ];

    protected $casts = [
        'variables' => 'array', // Auto convert JSON to array
        'is_active' => 'boolean',
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