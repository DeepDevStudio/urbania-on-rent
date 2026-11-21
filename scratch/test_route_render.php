<?php
$routes_to_test = [
    'delhi-to-manali-urbania-on-rent',
    'gurgaon-to-jaipur-urbania-on-rent',
    'noida-to-agra-urbania-on-rent',
    'ghaziabad-to-haridwar-urbania-on-rent',
    'faridabad-to-shimla-urbania-on-rent'
];

echo "TESTING DYNAMIC ROUTE RENDERING ACROSS 5 ORIGIN CITIES\n";
echo str_repeat("=", 60) . "\n";

foreach ($routes_to_test as $r) {
    $_GET['slug'] = $r;
    ob_start();
    require 'route.php';
    $html = ob_get_clean();

    preg_match_all('/<img\s+[^>]+>/i', $html, $matches);
    echo "\nROUTE: $r\n";
    echo "Found " . count($matches[0]) . " rendered <img> tags:\n";
    foreach ($matches[0] as $tag) {
        preg_match('/src=([\'"][^\'"]+[\'"])/i', $tag, $sm);
        preg_match('/alt=([\'"][^\'"]*[\'"])/i', $tag, $am);
        $s = $sm[1] ?? 'NO_SRC';
        $a = $am[1] ?? 'NO_ALT';
        echo "  src=" . $s . "\n       alt=" . $a . "\n";
    }
}
