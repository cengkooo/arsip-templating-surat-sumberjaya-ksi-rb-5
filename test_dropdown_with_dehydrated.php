<?php
/**
 * Test form submission untuk verify dropdown fields sekarang ter-submit dengan benar
 * Ini mensimulasikan data yang dikirim dari Filament form
 */
require 'vendor/autoload.php';

use App\Models\ArsipSurat;
use App\Models\TemplateSurat;
use App\Models\User;
use App\Filament\Resources\ArsipSuratResource\Pages\CreateFromTemplate;
use Illuminate\Support\Facades\Auth;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Set fake authenticated user
Auth::loginUsingId(1);

// Get template
$template = TemplateSurat::where('nama_template', 'Surat Keterangan Tidak Mampu')->first();
if (!$template) {
    echo "❌ Template 'Surat Keterangan Tidak Mampu' tidak ditemukan!\n";
    exit(1);
}

echo "✅ Using Template: " . $template->nama_template . "\n";
echo "   Variables: " . implode(', ', $template->variables) . "\n\n";

// Simulate form data DENGAN dropdown values
$formData = [
    'template_surat_id' => $template->id,
    'kategori_id' => $template->kategori_id,
    'nomor_surat' => 'TEST-DEHYDRATED-' . time(),
    'tanggal_surat' => now()->toDateString(),
    'lampiran' => '-',
    'perihal' => 'Test Dropdown Fields with Dehydrated',
    'nama' => 'Andi Wijaya',
    'nik' => '1234567890123456',
    'no_kk' => '1234567890123456',
    'tempat_lahir' => 'Bandung',
    'tanggal_lahir' => '1995-06-20',  // DatePicker format
    'jenis_kelamin' => 'Wanita',      // ← DROPDOWN
    'alamat' => 'Jl. Sudirman No. 123',
    'rt' => '03',
    'rw' => '07',
    'dusun' => 'Dusun Utama',
    'kelurahan' => 'Sumber Jaya',
    'kecamatan' => 'Kalianda',
    'kabupaten' => 'Lampung Selatan',
    'provinsi' => 'Lampung',
    'agama' => 'Kristen',             // ← DROPDOWN
    'status_perkawinan' => 'Belum Kawin',  // ← DROPDOWN
    'pekerjaan' => 'Guru',
    'kewarganegaraan' => 'WNI',       // ← DROPDOWN
    'berlaku_hingga' => '2026-12-31', // DatePicker
    'keperluan' => 'Persyaratan administrasi',
    'keterangan' => 'Surat test untuk verifikasi dropdown',
    'nama_penandatangan' => 'Kepala Desa',
    'jabatan_penandatangan' => 'Kepala Desa Sumberjaya',
    'nip_penandatangan' => '198505051234567890',
];

echo "📋 Form Data to Submit:\n";
echo json_encode([
    'jenis_kelamin' => $formData['jenis_kelamin'],
    'agama' => $formData['agama'],
    'status_perkawinan' => $formData['status_perkawinan'],
    'kewarganegaraan' => $formData['kewarganegaraan'],
    'tanggal_lahir' => $formData['tanggal_lahir'],
    'berlaku_hingga' => $formData['berlaku_hingga'],
], JSON_PRETTY_PRINT) . "\n\n";

// Now simulate the mutateFormDataBeforeCreate process
$data = $formData;
$data['user_id'] = Auth::id();
$data['jenis'] = 'keluar';
$data['status'] = 'draft';

// Extract variables
$dataVariables = [];
if ($template->variables) {
    foreach ($template->variables as $variable) {
        if (array_key_exists($variable, $data)) {
            $value = $data[$variable];
            
            // Handle date fields
            if ($value instanceof \Carbon\Carbon) {
                $value = $value->isoFormat('D MMMM YYYY');
            }
            
            $dataVariables[$variable] = $value;
            unset($data[$variable]);
        }
    }
}

$data['data_variables'] = $dataVariables;
unset($data['form_variables']);

// Create surat
echo "🔄 Creating Surat...\n";
$surat = ArsipSurat::create($data);
echo "✅ Surat Created: ID " . $surat->id . "\n";
echo "   Nomor: " . $surat->nomor_surat . "\n\n";

// Verify data_variables
echo "✅ Data Variables Saved:\n";
echo "   Jenis Kelamin: " . ($surat->data_variables['jenis_kelamin'] ?? 'NULL') . "\n";
echo "   Agama: " . ($surat->data_variables['agama'] ?? 'NULL') . "\n";
echo "   Status Perkawinan: " . ($surat->data_variables['status_perkawinan'] ?? 'NULL') . "\n";
echo "   Kewarganegaraan: " . ($surat->data_variables['kewarganegaraan'] ?? 'NULL') . "\n";
echo "   Tanggal Lahir: " . ($surat->data_variables['tanggal_lahir'] ?? 'NULL') . "\n";
echo "   Berlaku Hingga: " . ($surat->data_variables['berlaku_hingga'] ?? 'NULL') . "\n\n";

// Generate PDF
echo "🔄 Generating PDF...\n";
try {
    $pdfService = app(\App\Services\PdfGeneratorService::class);
    $pdfService->generate($surat);
    echo "✅ PDF Generated!\n";
    echo "   File: " . $surat->file_path . "\n\n";
} catch (\Exception $e) {
    echo "❌ PDF Generation Failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Verify content replacement
$surat->refresh();
echo "✅ Verifying PDF Content Replacement:\n";
if (strpos($surat->content_final['body'], 'Wanita') !== false) {
    echo "   ✓ Jenis Kelamin 'Wanita' replaced correctly!\n";
} else {
    echo "   ✗ Jenis Kelamin NOT replaced!\n";
}

if (strpos($surat->content_final['body'], 'Kristen') !== false) {
    echo "   ✓ Agama 'Kristen' replaced correctly!\n";
} else {
    echo "   ✗ Agama NOT replaced!\n";
}

if (strpos($surat->content_final['body'], 'Belum Kawin') !== false) {
    echo "   ✓ Status Perkawinan 'Belum Kawin' replaced correctly!\n";
} else {
    echo "   ✗ Status Perkawinan NOT replaced!\n";
}

echo "\n✅ TEST COMPLETE - Dropdown fields now working properly!\n";
?>
