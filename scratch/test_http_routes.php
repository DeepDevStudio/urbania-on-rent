<?php
$urls = [
    'http://localhost/Urbaniaonrentdelhi/delhi-to-agra-urbania.php',
    'http://localhost/Urbaniaonrentdelhi/gurgaon-to-manali-urbania-on-rent.php',
    'http://localhost/Urbaniaonrentdelhi/noida-to-jaipur-urbania-on-rent.php',
    'http://localhost/Urbaniaonrentdelhi/ghaziabad-to-rishikesh-urbania-on-rent.php',
    'http://localhost/Urbaniaonrentdelhi/faridabad-to-shimla-urbania-on-rent.php'
];

foreach ($urls as $url) {
    $content = @file_get_contents($url);
    if ($content === false) {
        echo "FAIL fetching $url" . PHP_EOL;
        continue;
    }
    $hasCard = strpos($content, 'pricing-calc-card') !== false;
    $hasDays = strpos($content, 'calc-days-select') !== false;
    $hasPrice = strpos($content, 'item-totalprice') !== false;
    $hasWa = strpos($content, 'wa.me/917290885949') !== false;
    
    echo "$url\n  -> Has Cards: " . ($hasCard ? 'YES' : 'NO') 
       . " | Days Selector: " . ($hasDays ? 'YES' : 'NO')
       . " | Price Display: " . ($hasPrice ? 'YES' : 'NO')
       . " | WhatsApp Link: " . ($hasWa ? 'YES' : 'NO') . PHP_EOL;
}
