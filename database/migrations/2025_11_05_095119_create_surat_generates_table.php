<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_generates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_surat_id')->constrained('template_surats')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Siapa yang generate
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->json('data_variables'); // Data variable yang diisi
            // Contoh: {"nama": "Budi", "nip": "123", "jabatan": "Kepala Desa"}
            $table->longText('content_final')->nullable(); // HTML hasil replace variable
            $table->string('file_pdf_path')->nullable(); // Path PDF hasil generate
            $table->string('status')->default('draft'); // draft/final/terkirim
            $table->text('catatan')->nullable();
            $table->timestamp('generated_at')->nullable(); // Kapan di-generate
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('nomor_surat');
            $table->index('tanggal_surat');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_generates');
    }
};