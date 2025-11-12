<?php
require 'vendor/autoload.php';

use App\Models\ArsipSurat;
use App\Models\TemplateSurat;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Auth;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Get last template
$template = TemplateSurat::latest()->first();

// Create test surat manually dengan data_variables yang berisi jenis_kelamin
$surat = ArsipSurat::create([
    'kategori_id' => $template->kategori_id,
    'template_surat_id' => $template->id,
    'user_id' => 1,
    'nomor_surat' => 'TEST-' . time(),
    'tanggal_surat' => now()->toDateString(),
    'lampiran' => '- (tidak ada)',
    'perihal' => 'Test Surat dengan Jenis Kelamin',
    'jenis' => 'keluar',
    'status' => 'draft',
    'data_variables' => [
        'nama' => 'Test User',
        'nik' => '1234567890123456',
        'no_kk' => '1234567890123456',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '1990-01-15',
        'jenis_kelamin' => 'Pria',  // <-- DROPDOWN VALUE
        'alamat' => 'Jl. Test No. 1',
        'rt' => '001',
        'rw' => '002',
        'dusun' => 'Dusun Test',
        'kelurahan' => 'Test Kelurahan',
        'kecamatan' => 'Test Kecamatan',
        'kabupaten' => 'Test Kabupaten',
        'provinsi' => 'Test Provinsi',
        'agama' => 'Islam',  // <-- DROPDOWN VALUE
        'status_perkawinan' => 'Kawin',  // <-- DROPDOWN VALUE
        'pekerjaan' => 'Test Pekerjaan',
        'kewarganegaraan' => 'WNI',  // <-- DROPDOWN VALUE
        'berlaku_hingga' => '2026-01-15',
        'keperluan' => 'Keperluan Test',
        'keterangan' => 'Keterangan Test',
    ],
]);

echo "✅ Test Surat Created: " . $surat->id . "\n";
echo "   Nomor: " . $surat->nomor_surat . "\n";
echo "   Jenis Kelamin: " . $surat->data_variables['jenis_kelamin'] . "\n";
echo "   Agama: " . $surat->data_variables['agama'] . "\n\n";

// Now try to generate PDF
echo "🔄 Generating PDF...\n";
try {
    $pdfService = app(PdfGeneratorService::class);
    $pdfService->generate($surat);
    echo "✅ PDF Generated successfully!\n";
    echo "   File: " . $surat->file_path . "\n";
} catch (\Exception $e) {
    echo "❌ PDF Generation Failed!\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

// Check final content
$surat->refresh();
echo "\n=== CONTENT FINAL (BODY) ===\n";
echo $surat->content_final['body'] . "\n";
?>
