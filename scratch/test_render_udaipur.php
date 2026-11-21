<?php
$_SERVER['REQUEST_URI'] = '/delhi-to-udaipur-urbania.php';
$_SERVER['PHP_SELF'] = '/delhi-to-udaipur-urbania.php';
$_SERVER['HTTP_HOST'] = 'localhost';

ob_start();
include __DIR__ . '/../delhi-to-udaipur-urbania.php';
$html = ob_get_clean();

$pos = strpos($html, 'id="pricing"');
if ($pos !== false) {
    echo "Found #pricing section!\n";
    $section = substr($html, $pos, 4000);
    $gridPos = strpos($html, 'item-roundtrip');
    if ($gridPos !== false) {
        echo substr($html, $gridPos - 120, 500);
    }
}

echo "\n--- Delhi to Ajmer ---\n";
unset($dest);
$_SERVER['REQUEST_URI'] = '/delhi-to-ajmer-urbania.php';
$_SERVER['PHP_SELF'] = '/delhi-to-ajmer-urbania.php';
ob_start();
include __DIR__ . '/../delhi-to-ajmer-urbania.php';
$htmlAjmer = ob_get_clean();
$posAjmer = strpos($htmlAjmer, 'item-roundtrip');
if ($posAjmer !== false) {
    echo substr($htmlAjmer, $posAjmer - 120, 800);
}

