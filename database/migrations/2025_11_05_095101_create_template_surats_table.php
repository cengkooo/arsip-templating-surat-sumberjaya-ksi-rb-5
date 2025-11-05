<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('nama_template'); // Nama template
            $table->string('kode_template')->unique(); // Kode unik template
            $table->text('keterangan')->nullable();
            $table->longText('content_header')->nullable(); // Kop surat HTML
            $table->longText('content_body'); // Isi template dengan placeholder
            $table->longText('content_footer')->nullable(); // Footer (TTD, dll)
            $table->json('variables')->nullable(); // List variable yang dipakai
            // Contoh: ["nama", "nip", "jabatan", "alamat", "tanggal"]
            $table->string('orientasi', 20)->default('portrait'); // portrait/landscape
            $table->string('ukuran_kertas', 20)->default('A4'); // A4, F4, Letter
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->default(0); // Berapa kali dipakai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_surats');
    }
};
