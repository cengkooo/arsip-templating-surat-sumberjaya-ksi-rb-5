<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update ENUM status untuk tambah 'selesai'
        DB::statement("ALTER TABLE arsip_surats MODIFY COLUMN status ENUM('draft', 'terkirim', 'diarsipkan', 'selesai') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke ENUM lama (tanpa 'selesai')
        // Update dulu data yang 'selesai' ke 'diarsipkan'
        DB::table('arsip_surats')->where('status', 'selesai')->update(['status' => 'diarsipkan']);
        
        DB::statement("ALTER TABLE arsip_surats MODIFY COLUMN status ENUM('draft', 'terkirim', 'diarsipkan') DEFAULT 'draft'");
    }
};
