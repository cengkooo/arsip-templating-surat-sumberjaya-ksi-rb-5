<?php

namespace Database\Seeders;

use App\Models\DesaSetting;
use Illuminate\Database\Seeder;

class DesaSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DesaSetting::updateOrCreate(
            ['id' => 1],
            [
                // Provinsi
                'nama_provinsi' => 'LAMPUNG',
                'kode_provinsi' => '18',
                
                // Kabupaten
                'nama_kabupaten' => 'KABUPATEN LAMPUNG SELATAN',
                'kode_kabupaten' => '18.04',
                'nama_kepala_kabupaten' => 'Dr. H. Nanang Ermanto, M.M.',
                'nip_kepala_kabupaten' => '19650101 199001 1 001',
                
                // Kecamatan
                'nama_kecamatan' => 'KECAMATAN KALIANDA',
                'kode_kecamatan' => '18.04.01',
                'nama_kepala_camat' => 'Drs. Ahmad Fauzi, M.Si',
                'nip_kepala_camat' => '19700101 199501 1 001',
                
                // Desa
                'nama_desa' => 'DESA SUMBERJAYA',
                'kode_desa' => '18.04.01.2003',
                'kode_pos_desa' => '35551',
                'nama_kepala_desa' => 'Budi Santoso, S.STP',
                'nip_kepala_desa' => '19800101 200801 1 001',
                
                // Alamat & Kontak
                'alamat_lengkap' => 'Jl. Way Urang No. 123 Sumberjaya, Kec. Kalianda, Kab. Lampung Selatan',
                'kode_pos' => '35551',
                'no_telepon' => '0727-123456',
                'email' => 'desa.sumberjaya@lampungselatan.go.id',
                'website' => 'www.sumberjaya-kalianda.desa.id',
                
                // Koordinat (example)
                'latitude' => -5.7309,
                'longitude' => 105.5598,
                
                // Pamong TTD Default
                'nama_pamong_ttd' => 'Budi Santoso, S.STP',
                'jabatan_pamong_ttd' => 'Kepala Desa',
                'nip_pamong_ttd' => '19800101 200801 1 001',
                
                'is_active' => true,
            ]
        );
    }
}
