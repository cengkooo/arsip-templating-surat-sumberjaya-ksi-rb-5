<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$surat = \App\Models\ArsipSurat::find(15);
echo "=== FULL PDF CONTENT ===\n";
echo $surat->content_final['body'];
?>
