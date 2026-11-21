<?php
$file = __DIR__ . '/css/style.css';
$content = file_get_contents($file);

// Replace gradients
$content = str_replace('linear-gradient(135deg, #8B5CF6, #3B82F6)', 'linear-gradient(135deg, #D4AF37, #b08d27)', $content);
$content = str_replace('linear-gradient(to right, #FBBF24, #8B5CF6)', 'linear-gradient(to right, #D4AF37, #0f172a)', $content);
$content = str_replace('linear-gradient(135deg, #e0f2fe, #ffffff)', 'linear-gradient(135deg, #f8fafc, #ffffff)', $content);
$content = str_replace('linear-gradient(135deg, #1e293b, #8B5CF6)', 'linear-gradient(135deg, #0f172a, #D4AF37)', $content);
$content = str_replace('linear-gradient(135deg, #FBBF24, #F59E0B)', 'linear-gradient(135deg, #1e293b, #0f172a)', $content); // Secondary button to dark slate

// Replace solid colors
$content = str_replace('#8B5CF6', '#D4AF37', $content); // Primary to Gold
$content = str_replace('#3B82F6', '#b08d27', $content); // Blue to darker gold/bronze
$content = str_replace('#FBBF24', '#D4AF37', $content); // Yellow to Gold
$content = str_replace('#F59E0B', '#b08d27', $content);

// Some rgba replacements for shadows and highlights
$content = str_replace('rgba(139, 92, 246', 'rgba(212, 175, 55', $content); // #8B5CF6 in rgb is 139, 92, 246. #D4AF37 is 212, 175, 55
$content = str_replace('rgba(139,92,246', 'rgba(212,175,55', $content);

file_put_contents($file, $content);
echo "Theme updated to Clean Premium successfully.\n";
?>
