<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1) Izinkan dulu semua status lama + baru
        DB::statement("
            ALTER TABLE arsip_surats
            MODIFY COLUMN status ENUM(
                'draft',
                'terkirim',
                'diarsipkan',
                'selesai',
                'belum_lengkap',
                'menunggu_ttd',
                'siap_dicetak'
            ) DEFAULT 'draft'
        ");

        // 2) Peta status lama ke status baru
        DB::table('arsip_surats')
            ->whereIn('status', ['terkirim', 'diarsipkan', 'selesai'])
            ->update(['status' => 'siap_dicetak']);

        // 3) Kunci ke set baru saja
        DB::statement("
            ALTER TABLE arsip_surats
            MODIFY COLUMN status ENUM(
                'draft',
                'belum_lengkap',
                'menunggu_ttd',
                'siap_dicetak'
            ) DEFAULT 'draft'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1) Izinkan status lama + baru
        DB::statement("
            ALTER TABLE arsip_surats
            MODIFY COLUMN status ENUM(
                'draft',
                'terkirim',
                'diarsipkan',
                'selesai',
                'belum_lengkap',
                'menunggu_ttd',
                'siap_dicetak'
            ) DEFAULT 'draft'
        ");

        // 2) Peta kembali ke status lama terdekat
        DB::table('arsip_surats')
            ->where('status', 'siap_dicetak')
            ->update(['status' => 'diarsipkan']);

        DB::table('arsip_surats')
            ->where('status', 'menunggu_ttd')
            ->update(['status' => 'terkirim']);

        DB::table('arsip_surats')
            ->where('status', 'belum_lengkap')
            ->update(['status' => 'draft']);

        // 3) Kunci ulang ke set lama
        DB::statement("
            ALTER TABLE arsip_surats
            MODIFY COLUMN status ENUM(
                'draft',
                'terkirim',
                'diarsipkan',
                'selesai'
            ) DEFAULT 'draft'
        ");
    }
};
