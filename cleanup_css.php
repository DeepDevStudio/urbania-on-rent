<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');
$all_styles = "";

// Ensure css directory exists
if (!is_dir($dir . '/css')) {
    mkdir($dir . '/css', 0777, true);
}

foreach ($files as $file) {
    if (basename($file) === 'cleanup_css.php') continue;
    
    $content = file_get_contents($file);
    preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $content, $matches);
    
    if (!empty($matches[1])) {
        foreach ($matches[1] as $style_content) {
            $all_styles .= "\n/* Styles from " . basename($file) . " */\n";
            $all_styles .= trim($style_content) . "\n";
        }
        $new_content = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $content);
        file_put_contents($file, $new_content);
        echo "Cleaned styles from " . basename($file) . "\n";
    }
}

if (!empty($all_styles)) {
    file_put_contents($dir . '/css/style.css', $all_styles);
    echo "Wrote all styles to css/style.css\n";
} else {
    echo "No styles found to extract.\n";
}
?>
