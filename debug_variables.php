<?php
require 'vendor/autoload.php';

use App\Models\TemplateSurat;
use App\Models\ArsipSurat;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$template = TemplateSurat::latest()->first();
$arsipSurat = ArsipSurat::latest()->first();

echo "=== TEMPLATE VARIABLES ===\n";
echo json_encode($template->variables, JSON_PRETTY_PRINT) . "\n\n";

echo "=== ARSIP SURAT DATA_VARIABLES ===\n";
echo json_encode($arsipSurat->data_variables, JSON_PRETTY_PRINT) . "\n\n";

echo "=== ARSIP SURAT ATTRIBUTES ===\n";
echo json_encode([
    'jenis_kelamin' => $arsipSurat->getAttribute('jenis_kelamin') ?? 'NOT SET IN ATTRIBUTES',
    'agama' => $arsipSurat->getAttribute('agama') ?? 'NOT SET IN ATTRIBUTES',
], JSON_PRETTY_PRINT) . "\n";
?>
