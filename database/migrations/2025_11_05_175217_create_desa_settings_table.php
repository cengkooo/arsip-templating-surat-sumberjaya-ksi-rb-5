<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('desa_settings', function (Blueprint $table) {
            $table->id();
            
            // Logo
            $table->string('logo_path')->nullable()->comment('Path logo desa/kabupaten');
            
            // Identitas Pemerintahan
            $table->string('nama_kabupaten', 100)->default('KABUPATEN LAMPUNG SELATAN');
            $table->string('nama_kecamatan', 100)->default('KECAMATAN KALIANDA');
            $table->string('nama_desa', 100)->default('DESA SUMBERJAYA');
            
            // Alamat & Kontak
            $table->text('alamat_lengkap')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 100)->nullable();
            
            // Pejabat Default (untuk referensi)
            $table->string('nama_kepala_desa', 100)->nullable();
            $table->string('nip_kepala_desa', 30)->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa_settings');
    }
};
