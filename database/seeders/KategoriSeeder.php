<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {

        // Kategori surat keterangan (dipakai semua template bawaan)
        Kategori::updateOrCreate(
            ['kode' => 'SK'],
            [
                'nama' => 'Surat Keterangan',
                'keterangan' => 'Kategori untuk berbagai surat keterangan',
                'is_active' => true,
            ]
        );
    }
}
