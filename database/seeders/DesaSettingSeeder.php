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
                'kode_kabupaten' => '18.01',
                'nama_kepala_kabupaten' => 'Radityo Egi Pratama, S.T., M.B.A.',
                'nip_kepala_kabupaten' => '-',
                
                // Kecamatan
                'nama_kecamatan' => 'KECAMATAN JATI AGUNG',
                'kode_kecamatan' => '18.01.13',
                'nama_kepala_camat' => 'Rizwan Effendi, S.K.M., M.M.',
                'nip_kepala_camat' => '19810816 200901 1 006',
                
                // Desa
                'nama_desa' => 'DESA SUMBER JAYA',
                'kode_desa' => '18.01.13.2013',
                'kode_pos_desa' => '35365',
                'nama_kepala_desa' => 'Idham',
                'nip_kepala_desa' => '-',
                
                // Alamat & Kontak
                'alamat_lengkap' => 'Jalan poros, Sumber Jaya, Kec. Jati Agung, Kabupaten Lampung Selatan, Lampung',
                'kode_pos' => '35365',
                'no_telepon' => '0727-123456',
                'email' => 'desa.sumberjaya@lampungselatan.go.id',
                'website' => 'www.sumberjaya-jatiagung.desa.id',
                
                // Koordinat (example)
                'latitude' => -5.284976501955912,
                'longitude' => 105.3769607460262,
                
                // Pamong TTD Default
                'nama_pamong_ttd' => 'Idham',
                'jabatan_pamong_ttd' => 'Kepala Desa',
                'nip_pamong_ttd' => '-',
                
                'is_active' => true,
            ]
        );
    }
}
