<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$template = \App\Models\TemplateSurat::first();

echo "=== TEMPLATE BODY ===\n";
echo $template->content_body . "\n\n";

echo "=== TEMPLATE FOOTER ===\n";
echo $template->content_footer . "\n\n";

echo "=== TEMPLATE HEADER ===\n";
echo $template->content_header . "\n\n";

// Find all {{variable}} placeholders
$pattern = '/\{\{([a-z_]+)\}\}/i';
preg_match_all($pattern, $template->content_body . $template->content_footer . $template->content_header, $matches);

echo "=== PLACEHOLDERS FOUND IN TEMPLATE ===\n";
$placeholders = array_unique($matches[1]);
sort($placeholders);
foreach ($placeholders as $p) {
    echo "  - {{" . $p . "}}\n";
}

echo "\n=== VARIABLES IN TEMPLATE VARIABLES ARRAY ===\n";
foreach ($template->variables as $v) {
    echo "  - " . $v . "\n";
}

echo "\n=== MISSING PLACEHOLDERS ===\n";
$missing = array_diff($template->variables, $placeholders);
if (count($missing) > 0) {
    foreach ($missing as $m) {
        echo "  ✗ " . $m . " (defined in variables but NOT in template HTML)\n";
    }
} else {
    echo "  ✓ All variables have placeholders\n";
}
?>
