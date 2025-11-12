<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Get surat dari PDF user (nomor 011/12/1223/12zzzzzz)
$surat = \App\Models\ArsipSurat::where('nomor_surat', '011/12/1223/12zzzzzz')->first();

if (!$surat) {
    echo "❌ Surat tidak ditemukan!\n";
    $latest = \App\Models\ArsipSurat::latest()->first();
    echo "Latest surat: " . $latest->nomor_surat . "\n";
    exit(1);
}

echo "=== ANALYZING SURAT: " . $surat->nomor_surat . " ===\n\n";

echo "📋 DATA VARIABLES IN DATABASE:\n";
echo json_encode($surat->data_variables, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

echo "📝 TEMPLATE VARIABLES:\n";
echo json_encode($surat->templateSurat->variables, JSON_PRETTY_PRINT) . "\n\n";

echo "🔍 ANALYZING EACH FIELD:\n";
foreach ($surat->templateSurat->variables as $var) {
    $value = $surat->data_variables[$var] ?? 'NULL';
    $type = gettype($value);
    
    if (is_object($value)) {
        $type = get_class($value);
    }
    
    echo sprintf("  %-20s | Value: %-20s | Type: %s\n", $var, 
        (is_string($value) ? $value : json_encode($value)), 
        $type
    );
}

echo "\n📄 CHECKING CONTENT_FINAL:\n";
$body = $surat->content_final['body'] ?? '';
echo "jenis_kelamin in content: " . (strpos($body, 'Jenis Kelamin') !== false ? '✓ FOUND' : '✗ NOT FOUND') . "\n";
echo "agama in content: " . (strpos($body, 'Agama') !== false ? '✓ FOUND' : '✗ NOT FOUND') . "\n";
echo "tanggal_lahir in content: " . (strpos($body, 'Tempat Tanggal Lahir') !== false ? '✓ FOUND' : '✗ NOT FOUND') . "\n";
?>
