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
        Schema::table('arsip_surats', function (Blueprint $table) {
            // Relasi ke template
            $table->foreignId('template_surat_id')->nullable()->after('kategori_id')->constrained('template_surats')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->after('template_surat_id')->constrained('users')->nullOnDelete();
            
            // Data dari generate/form
            $table->json('data_variables')->nullable()->after('isi_ringkas')->comment('Data isian dari form');
            $table->json('content_final')->nullable()->after('data_variables')->comment('Content final yang sudah dimerge');
            
            // Data penandatangan
            $table->string('nama_penandatangan', 100)->nullable()->after('penerima');
            $table->string('jabatan_penandatangan', 100)->nullable()->after('nama_penandatangan');
            $table->string('nip_penandatangan', 30)->nullable()->after('jabatan_penandatangan');
            
            // Timestamp generate
            $table->timestamp('generated_at')->nullable()->after('nip_penandatangan')->comment('Waktu surat digenerate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip_surats', function (Blueprint $table) {
            $table->dropForeign(['template_surat_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'template_surat_id',
                'user_id',
                'data_variables',
                'content_final',
                'nama_penandatangan',
                'jabatan_penandatangan',
                'nip_penandatangan',
                'generated_at',
            ]);
        });
    }
};
