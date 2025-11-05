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
                'nama_kabupaten' => 'KABUPATEN LAMPUNG SELATAN',
                'nama_kecamatan' => 'KECAMATAN KALIANDA',
                'nama_desa' => 'DESA SUMBERJAYA',
                'alamat_lengkap' => 'Jl. Way Urang No. 123 Sumberjaya',
                'kode_pos' => '35551',
                'no_telepon' => '0727-123456',
                'email' => 'desa.sumberjaya@lampungselatan.go.id',
                'website' => 'www.sumberjaya-kalianda.desa.id',
                'nama_kepala_desa' => 'Budi Santoso, S.STP',
                'nip_kepala_desa' => '19800101 200801 1 001',
                'is_active' => true,
            ]
        );
    }
}
