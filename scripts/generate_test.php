<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\TemplateSurat;
use App\Models\ArsipSurat;
use App\Services\PdfGeneratorService;
use App\Models\Kategori;

echo "Starting PDF generation test...\n";

try {
    $ts = TemplateSurat::first();
    if (!$ts) {
        echo "No template found. Creating test template...\n";
        $ts = TemplateSurat::create([
            'nama_template' => 'TEST',
            'kode_template' => 'TEST',
            'content_body' => '<p>Test surat: {{nomor_surat}}</p>',
            'content_header' => '',
            'content_footer' => '',
            'variables' => [],
            'orientasi' => 'portrait',
            'ukuran_kertas' => 'A4',
            'margin_kiri' => 1,
            'margin_kanan' => 1,
            'margin_atas' => 1,
            'margin_bawah' => 1,
        ]);
    } else {
        echo "Using existing template id={$ts->id}\n";
    }

    echo "Ensuring kategori exists...\n";
    $kategori = Kategori::first();
    if (!$kategori) {
        $kategori = Kategori::create(['nama' => 'Umum', 'kode' => 'UMUM', 'keterangan' => 'Kategori test', 'is_active' => true]);
    }

    echo "Creating ArsipSurat record...\n";
    $ars = ArsipSurat::create([
        'kategori_id' => $kategori->id,
        'template_surat_id' => $ts->id,
        'user_id' => 1,
        'nomor_surat' => 'TEST/GEN/'.time(),
        'tanggal_surat' => now(),
        'perihal' => 'Test generate',
        'data_variables' => [],
    ]);

    echo "Calling PdfGeneratorService->generate()...\n";
    $svc = app(PdfGeneratorService::class);
    $res = $svc->generate($ars);

    echo "DONE. file_path=" . ($res->file_path ?? $res->file_pdf_path) . "\n";

} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    file_put_contents(storage_path('logs/gentest.log'), $e->getMessage() . "\n" . $e->getTraceAsString());
}

echo "Finished.\n";
