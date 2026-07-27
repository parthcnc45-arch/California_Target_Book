<?php

$dir = __DIR__ . '/../resources/views/admin/admin-settings';
$files = glob("$dir/*.blade.php");

$combinedCss = "/* Admin Settings Shared Styles */\n\n";

foreach ($files as $file) {
    $content = file_get_contents($file);
    preg_match('/<style>(.*?)<\/style>/s', $content, $matches);
    if (!empty($matches[1])) {
        $basename = basename($file);
        $combinedCss .= "/* ==========================================================================\n";
        $combinedCss .= "   Styles extracted from {$basename}\n";
        $combinedCss .= "   ========================================================================== */\n";
        $combinedCss .= trim($matches[1]) . "\n\n";
    }
}

file_put_contents(__DIR__ . '/../public/css/admin_settings.css', $combinedCss);
echo "Successfully extracted and combined styles to public/css/admin_settings.css\n";
