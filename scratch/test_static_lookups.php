<?php
require_once __DIR__ . '/../includes/destinations-data.php';

$static_files = [
    'delhi-to-agra-urbania',
    'delhi-to-ajmer-urbania',
    'delhi-to-amritsar-urbania',
    'delhi-to-auli-urbania',
    'delhi-to-bikaner-urbania',
    'delhi-to-chandigarh-urbania',
    'delhi-to-dalhousie-urbania',
    'delhi-to-dehradun-urbania',
    'delhi-to-dharamshala-urbania',
    'delhi-to-haridwar-urbania',
    'delhi-to-jaipur-urbania',
    'delhi-to-jaisalmer-urbania',
    'delhi-to-jodhpur-urbania',
    'delhi-to-kasauli-urbania',
    'delhi-to-kedarnath-urbania',
    'delhi-to-lucknow-urbania',
    'delhi-to-manali-urbania',
    'delhi-to-mathura-urbania',
    'delhi-to-mussoorie-urbania',
    'delhi-to-nainital-urbania',
    'delhi-to-pushkar-urbania',
    'delhi-to-ranthambore-urbania',
    'delhi-to-rishikesh-urbania',
    'delhi-to-shimla-urbania',
    'delhi-to-udaipur-urbania',
    'delhi-to-varanasi-urbania'
];

foreach ($static_files as $f) {
    $d = get_destination_by_slug($f);
    echo $f . ': ' . ($d ? ($d['destination'] . ' - ' . $d['distance'] . ' km') : 'NOT FOUND') . PHP_EOL;
}
