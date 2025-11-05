<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('nomor_surat')->unique(); // Nomor surat
            $table->date('tanggal_surat'); // Tanggal surat dibuat
            $table->date('tanggal_terima')->nullable(); // Tanggal diterima (surat masuk)
            $table->string('perihal'); // Perihal/judul surat
            $table->text('isi_ringkas')->nullable(); // Ringkasan isi surat
            $table->string('pengirim')->nullable(); // Pengirim (surat masuk)
            $table->string('penerima')->nullable(); // Penerima (surat keluar)
            $table->string('file_path')->nullable(); // Path file surat (PDF/DOC/Image)
            $table->enum('status', ['draft', 'terkirim', 'diarsipkan'])->default('draft');
            $table->enum('jenis', ['masuk', 'keluar']); // Surat masuk/keluar
            $table->text('catatan')->nullable();
            $table->softDeletes(); // Soft delete (bisa restore)
            $table->timestamps();
            
            // Index untuk search & filter cepat
            $table->index('nomor_surat');
            $table->index('tanggal_surat');
            $table->index('status');
            $table->index('jenis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_surats');
    }
};