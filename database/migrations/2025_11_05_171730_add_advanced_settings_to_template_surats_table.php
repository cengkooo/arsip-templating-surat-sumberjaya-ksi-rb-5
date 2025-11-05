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
        Schema::table('template_surats', function (Blueprint $table) {
            // Margin settings (dalam cm)
            $table->decimal('margin_kiri', 5, 2)->default(1.78)->after('orientasi');
            $table->decimal('margin_kanan', 5, 2)->default(1.78)->after('margin_kiri');
            $table->decimal('margin_atas', 5, 2)->default(0.63)->after('margin_kanan');
            $table->decimal('margin_bawah', 5, 2)->default(1.37)->after('margin_atas');
            
            // Header & Footer settings
            $table->boolean('tampilkan_qrcode')->default(false)->after('margin_bawah');
            $table->boolean('tampilkan_header')->default(true)->after('tampilkan_qrcode');
            $table->enum('header_type', ['semua_halaman', 'hanya_halaman_awal', 'tidak'])->default('semua_halaman')->after('tampilkan_header');
            $table->boolean('tampilkan_footer')->default(false)->after('header_type');
            $table->boolean('tampilkan_logo')->default(false)->after('tampilkan_footer');
            
            // Penomoran
            $table->text('format_nomor')->nullable()->after('tampilkan_logo');
            $table->boolean('sediakan_layanan_mandiri')->default(false)->after('format_nomor');
            
            // Lampiran
            $table->string('lampiran_template')->nullable()->after('sediakan_layanan_mandiri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_surats', function (Blueprint $table) {
            $table->dropColumn([
                'margin_kiri',
                'margin_kanan', 
                'margin_atas',
                'margin_bawah',
                'tampilkan_qrcode',
                'tampilkan_header',
                'header_type',
                'tampilkan_footer',
                'tampilkan_logo',
                'format_nomor',
                'sediakan_layanan_mandiri',
                'lampiran_template'
            ]);
        });
    }
};
