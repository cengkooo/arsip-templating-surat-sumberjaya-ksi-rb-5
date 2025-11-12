<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$templates = \App\Models\TemplateSurat::all();
echo "Total templates: " . count($templates) . "\n";
foreach($templates as $t) {
    echo "- " . $t->nama_template . " (ID: " . $t->id . ")\n";
}
?>
