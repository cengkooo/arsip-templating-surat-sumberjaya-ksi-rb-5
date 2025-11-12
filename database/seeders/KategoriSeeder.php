<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::updateOrCreate(
            ['kode' => 'UMUM'],
            [
                'nama' => 'Umum',
                'keterangan' => 'Kategori umum untuk berbagai jenis surat',
                'is_active' => true,
            ]
        );
    }
}
