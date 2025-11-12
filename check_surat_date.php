<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$surat = \App\Models\ArsipSurat::where('nomor_surat', '011/12/1223/12zzzzzz')->first();
if ($surat) {
    echo "Created At: " . $surat->created_at . "\n";
    echo "Today is: " . now() . "\n";
    echo "\n" . ($surat->created_at->toDateString() === now()->toDateString() ? "✓ Created TODAY" : "✗ Created BEFORE");
}
?>
