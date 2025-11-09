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
        Schema::table('desa_settings', function (Blueprint $table) {
            // Kode Identitas (seperti di OpenSID)
            $table->string('kode_desa', 20)->nullable()->after('nama_desa');
            $table->string('kode_pos_desa', 10)->nullable()->after('kode_pos');
            $table->string('nama_kepala_camat', 100)->nullable()->after('nip_kepala_desa');
            $table->string('nip_kepala_camat', 30)->nullable()->after('nama_kepala_camat');
            $table->string('nama_kepala_kabupaten', 100)->nullable()->after('nip_kepala_camat');
            $table->string('nip_kepala_kabupaten', 30)->nullable()->after('nama_kepala_kabupaten');
            
            // Koordinat & Wilayah
            $table->string('nama_provinsi', 100)->default('LAMPUNG')->after('nama_kabupaten');
            $table->string('kode_provinsi', 10)->nullable()->after('nama_provinsi');
            $table->string('kode_kabupaten', 10)->nullable()->after('kode_provinsi');
            $table->string('kode_kecamatan', 10)->nullable()->after('kode_kabupaten');
            $table->decimal('latitude', 10, 8)->nullable()->after('kode_kecamatan');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            
            // Informasi Tambahan
            $table->string('nama_pamong_ttd', 100)->nullable()->comment('Nama pamong default untuk TTD')->after('longitude');
            $table->string('jabatan_pamong_ttd', 100)->nullable()->comment('Jabatan pamong default')->after('nama_pamong_ttd');
            $table->string('nip_pamong_ttd', 30)->nullable()->after('jabatan_pamong_ttd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('desa_settings', function (Blueprint $table) {
            $table->dropColumn([
                'kode_desa',
                'kode_pos_desa',
                'nama_kepala_camat',
                'nip_kepala_camat',
                'nama_kepala_kabupaten',
                'nip_kepala_kabupaten',
                'nama_provinsi',
                'kode_provinsi',
                'kode_kabupaten',
                'kode_kecamatan',
                'latitude',
                'longitude',
                'nama_pamong_ttd',
                'jabatan_pamong_ttd',
                'nip_pamong_ttd',
            ]);
        });
    }
};
