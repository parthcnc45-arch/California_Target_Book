<?php

$dir = __DIR__ . '/../resources/views/admin/admin-settings';
$files = glob("$dir/*.blade.php");

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // We want to replace the style tags and everything inside them with empty string
    // but keep the section tags if needed (empty section) or just remove the whole section if it becomes empty.
    $newContent = preg_replace('/@section\(\'portal_styles\'\)\s*<style>.*?<\/style>\s*@endsection/s', '', $content);
    
    // Fallback if the layout is slightly different (e.g. style tags inside portal_styles section but with whitespaces)
    if ($newContent === $content) {
        $newContent = preg_replace('/<style>.*?<\/style>/s', '', $content);
    }
    
    if ($newContent !== $content) {
        file_put_contents($file, $newContent);
        echo "Cleaned styles from " . basename($file) . "\n";
    }
}
