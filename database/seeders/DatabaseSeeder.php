<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@sumberjaya.com'],
            [
                'name' => 'Admin Desa',
                'password' => Hash::make('password'), // GANTI INI DI PRODUCTION!
            ]
        );

        // Seed semua data
        $this->call([
            KategoriSeeder::class,
            TemplateSKTMLengkapSeeder::class,
            TemplateSuratDomisiliSeeder::class,
            TemplateSuratUsahaSeeder::class,
            TemplateSuratKematianSeeder::class,
            DesaSettingSeeder::class, // Optional, tapi recommended
        ]);
    }
}
