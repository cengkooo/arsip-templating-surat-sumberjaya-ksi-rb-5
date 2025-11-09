<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesaSetting extends Model
{
    protected $fillable = [
        'logo_path',
        'nama_provinsi',
        'kode_provinsi',
        'nama_kabupaten',
        'kode_kabupaten',
        'nama_kecamatan',
        'kode_kecamatan',
        'nama_desa',
        'kode_desa',
        'kode_pos_desa',
        'alamat_lengkap',
        'kode_pos',
        'no_telepon',
        'email',
        'website',
        'latitude',
        'longitude',
        'nama_kepala_desa',
        'nip_kepala_desa',
        'nama_kepala_camat',
        'nip_kepala_camat',
        'nama_kepala_kabupaten',
        'nip_kepala_kabupaten',
        'nama_pamong_ttd',
        'jabatan_pamong_ttd',
        'nip_pamong_ttd',
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

    /**
     * Get variables for template replacement
     * This method provides all desa data as variables that can be used in templates
     */
    public function getTemplateVariables(): array
    {
        return [
            // Identitas Desa
            'nama_desa' => $this->nama_desa,
            'kode_desa' => $this->kode_desa,
            'nama_kecamatan' => $this->nama_kecamatan,
            'kode_kecamatan' => $this->kode_kecamatan,
            'nama_kabupaten' => $this->nama_kabupaten,
            'kode_kabupaten' => $this->kode_kabupaten,
            'nama_provinsi' => $this->nama_provinsi,
            'kode_provinsi' => $this->kode_provinsi,
            
            // Alamat & Kontak
            'alamat_desa' => $this->alamat_lengkap,
            'kode_pos' => $this->kode_pos,
            'kode_pos_desa' => $this->kode_pos_desa,
            'telepon_desa' => $this->no_telepon,
            'email_desa' => $this->email,
            'website_desa' => $this->website,
            
            // Koordinat
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            
            // Pejabat
            'nama_kepala_desa' => $this->nama_kepala_desa,
            'nip_kepala_desa' => $this->nip_kepala_desa,
            'nama_kepala_camat' => $this->nama_kepala_camat,
            'nip_kepala_camat' => $this->nip_kepala_camat,
            'nama_kepala_kabupaten' => $this->nama_kepala_kabupaten,
            'nip_kepala_kabupaten' => $this->nip_kepala_kabupaten,
            
            // Pamong TTD Default
            'nama_pamong_ttd' => $this->nama_pamong_ttd,
            'jabatan_pamong_ttd' => $this->jabatan_pamong_ttd,
            'nip_pamong_ttd' => $this->nip_pamong_ttd,
            
            // Helper untuk KOP Surat
            'identitas_pemerintahan' => $this->full_identity,
            'alamat_lengkap' => $this->full_address,
        ];
    }
}
