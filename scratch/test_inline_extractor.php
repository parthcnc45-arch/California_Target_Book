<?php

function extractStylesFromContent($content, $filePrefix, &$stylesMap, &$cssOutput) {
    // We will do a backwards and forwards tag boundary check for each style=" ... "
    $offset = 0;
    $count = 0;
    
    while (true) {
        // Find style=" or style='
        if (!preg_match('/\bstyle=(["\'])(.*?)\1/i', $content, $match, PREG_OFFSET_CAPTURE, $offset)) {
            break;
        }
        
        $fullMatch = $match[0][0]; // style="..."
        $styleOffset = $match[0][1];
        $styleVal = trim($match[2][0]); // style value
        $quoteChar = $match[1][0];
        
        // Find the start of the tag '<' by looking backwards
        $tagStart = strrpos(substr($content, 0, $styleOffset), '<');
        if ($tagStart === false) {
            $offset = $styleOffset + strlen($fullMatch);
            continue;
        }
        
        // Find the end of the tag '>' by looking forwards from styleOffset
        $tagEnd = strpos($content, '>', $styleOffset);
        if ($tagEnd === false) {
            $offset = $styleOffset + strlen($fullMatch);
            continue;
        }
        
        // Extract tag content
        $tagContent = substr($content, $tagStart, $tagEnd - $tagStart + 1);
        
        // Skip if style contains blade/php echo braces inside it (too complex/dynamic)
        if (strpos($styleVal, '{{') !== false || strpos($styleVal, '<?') !== false || empty($styleVal)) {
            $offset = $styleOffset + strlen($fullMatch);
            continue;
        }
        
        // Check if we already have this style normalized in our stylesMap
        $normStyle = strtolower(preg_replace('/\s+/', ' ', $styleVal));
        $normStyle = rtrim($normStyle, ';') . ';';
        
        if (!isset($stylesMap[$normStyle])) {
            $count++;
            $className = "ads-{$filePrefix}-{$count}";
            $stylesMap[$normStyle] = $className;
            
            // Format style block for CSS
            $cssRules = "";
            $rules = explode(';', rtrim($styleVal, ';'));
            foreach ($rules as $rule) {
                if (trim($rule)) {
                    $cssRules .= "    " . trim($rule) . ";\n";
                }
            }
            $cssOutput .= ".{$className} {\n{$cssRules}}\n";
        } else {
            $className = $stylesMap[$normStyle];
        }
        
        // Modify tagContent: replace style attribute with class
        // Check if class=" ... " exists in tagContent
        $newTagContent = $tagContent;
        if (preg_match('/class=(["\'])(.*?)\1/i', $tagContent, $classMatch)) {
            $existingClasses = trim($classMatch[2]);
            $quote = $classMatch[1];
            
            // If class name is not already present, add it
            if (strpos($existingClasses, $className) === false) {
                $newClasses = $existingClasses ? "{$existingClasses} {$className}" : $className;
                // Replace class attribute
                $newTagContent = preg_replace('/class=(["\'])(.*?)\1/i', "class={$quote}{$newClasses}{$quote}", $newTagContent);
            }
            
            // Remove style attribute
            $newTagContent = preg_replace('/\bstyle=(["\'])(.*?)\1/i', '', $newTagContent);
        } else {
            // No class attribute, replace style with class
            $newTagContent = preg_replace('/\bstyle=(["\'])(.*?)\1/i', "class=\"{$className}\"", $newTagContent);
        }
        
        // Clean up double spaces created in tag
        $newTagContent = preg_replace('/\s+/', ' ', $newTagContent);
        // Put back closing bracket space if needed
        $newTagContent = str_replace(' />', '/>', $newTagContent);
        $newTagContent = str_replace(' >', '>', $newTagContent);
        
        // Replace in content
        $content = substr_replace($content, $newTagContent, $tagStart, $tagEnd - $tagStart + 1);
        
        // Move offset
        $offset = $tagStart + strlen($newTagContent);
    }
    
    return $content;
}

// Test with digital_addon_orders.blade.php
$file = __DIR__ . '/../resources/views/admin/admin-settings/digital_addon_orders.blade.php';
$content = file_get_contents($file);
$stylesMap = [];
$cssOutput = "";
$newContent = extractStylesFromContent($content, 'digital', $stylesMap, $cssOutput);

echo "--- CSS OUTPUT ---\n";
echo $cssOutput;
echo "\n--- FILE CHANGES LENGTH ---\n";
echo "Original: " . strlen($content) . " bytes\n";
echo "New: " . strlen($newContent) . " bytes\n";
