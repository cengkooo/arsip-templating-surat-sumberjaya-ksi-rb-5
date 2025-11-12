<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed minimal user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed konfigurasi dasar agar repo langsung siap pakai
        $this->call([
            KategoriSeeder::class,
            TemplateSuratSeeder::class,
            // Opsional: DesaSettingSeeder::class, // aktifkan jika ingin default setting desa
        ]);
    }
}
