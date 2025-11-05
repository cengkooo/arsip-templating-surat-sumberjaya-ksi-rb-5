<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratGenerate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_surat_id',
        'user_id',
        'nomor_surat',
        'tanggal_surat',
        'data_variables',
        'content_final',
        'file_pdf_path',
        'status',
        'catatan',
        'generated_at',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'data_variables' => 'array',
        'generated_at' => 'datetime',
    ];

    // Relationship
    public function templateSurat(): BelongsTo
    {
        return $this->belongsTo(TemplateSurat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Get PDF URL
    public function getPdfUrlAttribute()
    {
        return $this->file_pdf_path ? asset('storage/' . $this->file_pdf_path) : null;
    }
}