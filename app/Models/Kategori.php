<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship: 1 kategori punya banyak arsip
    public function arsipSurats(): HasMany
    {
        return $this->hasMany(ArsipSurat::class);
    }

    // Relationship: 1 kategori punya banyak template
    public function templateSurats(): HasMany
    {
        return $this->hasMany(TemplateSurat::class);
    }
}