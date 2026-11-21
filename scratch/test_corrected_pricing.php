<?php
require_once __DIR__ . '/../includes/services/RoutePricingService.php';

$tests = [
    ['rt' => 200, 'days' => 1, 'rate' => 45, 'expected' => 11250],
    ['rt' => 200, 'days' => 2, 'rate' => 45, 'expected' => 22500],
    ['rt' => 250, 'days' => 1, 'rate' => 45, 'expected' => 11250],
    ['rt' => 300, 'days' => 1, 'rate' => 45, 'expected' => 13500],
    ['rt' => 300, 'days' => 2, 'rate' => 45, 'expected' => 27000],
    ['rt' => 400, 'days' => 3, 'rate' => 45, 'expected' => 54000],
    ['rt' => 600, 'days' => 5, 'rate' => 45, 'expected' => 135000],
    ['rt' => 600, 'days' => 10, 'rate' => 45, 'expected' => 270000],
];

$failed = 0;
foreach ($tests as $idx => $t) {
    // One-way distance is RT / 2
    $oneWay = $t['rt'] / 2;
    $res = RoutePricingService::calculateTripPrice($oneWay, $t['days'], $t['rate']);
    $pass = ($res['totalPrice'] === $t['expected']);
    if ($pass) {
        echo "✓ Test #" . ($idx + 1) . ": RT={$t['rt']}km, Days={$t['days']}, Rate={$t['rate']} => {$res['formattedPrice']} (Chargeable/day: {$res['chargeableKmPerDay']}km)" . PHP_EOL;
    } else {
        $failed++;
        echo "✗ FAIL Test #" . ($idx + 1) . ": got {$res['totalPrice']}, expected {$t['expected']}" . PHP_EOL;
    }
}

if ($failed === 0) {
    echo PHP_EOL . "ALL 8 USER TEST CASES PASSED WITH 100% ACCURACY!" . PHP_EOL;
}
