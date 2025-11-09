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
            $table->dropColumn('sediakan_layanan_mandiri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_surats', function (Blueprint $table) {
            $table->boolean('sediakan_layanan_mandiri')->default(false)->after('format_nomor');
        });
    }
};
