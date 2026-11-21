<?php
$_REQUEST['slug'] = 'delhi-to-udaipur-urbania';
$_REQUEST['vehicle'] = '9-seater';
$_REQUEST['days'] = 4;

ob_start();
include __DIR__ . '/../api/calculate-price.php';
$output = ob_get_clean();

echo "API Response for 4 Days Delhi to Udaipur (9-seater):\n";
echo $output . "\n";

$json = json_decode($output, true);
if ($json && $json['status'] === 'success' && $json['data']['totalFare'] === 59400 && $json['data']['billableKm'] === 1320) {
    echo "API TEST PASSED!\n";
} else {
    echo "API TEST FAILED!\n";
    exit(1);
}
