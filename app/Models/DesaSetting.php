<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesaSetting extends Model
{
    protected $fillable = [
        'logo_path',
        'nama_kabupaten',
        'nama_kecamatan',
        'nama_desa',
        'alamat_lengkap',
        'kode_pos',
        'no_telepon',
        'email',
        'website',
        'nama_kepala_desa',
        'nip_kepala_desa',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Singleton pattern: Get the single active desa setting
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::first();
    }

    /**
     * Get logo URL
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    /**
     * Get full identity text for header
     */
    public function getFullIdentityAttribute()
    {
        $identity = [];
        
        if ($this->nama_kabupaten) {
            $identity[] = strtoupper($this->nama_kabupaten);
        }
        
        if ($this->nama_kecamatan) {
            $identity[] = strtoupper($this->nama_kecamatan);
        }
        
        if ($this->nama_desa) {
            $identity[] = strtoupper($this->nama_desa);
        }
        
        return implode("\n", $identity);
    }

    /**
     * Get address with postal code
     */
    public function getFullAddressAttribute()
    {
        $address = $this->alamat_lengkap ?? '';
        
        if ($this->kode_pos) {
            $address .= ' Kode Pos ' . $this->kode_pos;
        }
        
        return $address;
    }
}
