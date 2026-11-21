<?php
require_once __DIR__ . '/../includes/services/RoutePricingService.php';

$testCases = [
    [
        'name' => 'Example 1',
        'dist' => 100, 'days' => 1, 'rate' => 45,
        'expected' => ['roundTrip' => 200, 'min' => 250, 'billable' => 250, 'total' => 11250]
    ],
    [
        'name' => 'Example 2',
        'dist' => 200, 'days' => 1, 'rate' => 45,
        'expected' => ['roundTrip' => 400, 'min' => 250, 'billable' => 400, 'total' => 18000]
    ],
    [
        'name' => 'Example 3',
        'dist' => 200, 'days' => 2, 'rate' => 45,
        'expected' => ['roundTrip' => 400, 'min' => 500, 'billable' => 500, 'total' => 22500]
    ],
    [
        'name' => 'Example 4',
        'dist' => 400, 'days' => 3, 'rate' => 45,
        'expected' => ['roundTrip' => 800, 'min' => 750, 'billable' => 800, 'total' => 36000]
    ],
    [
        'name' => 'Example 5',
        'dist' => 200, 'days' => 10, 'rate' => 40,
        'expected' => ['roundTrip' => 400, 'min' => 2500, 'billable' => 2500, 'total' => 100000]
    ],
];

$failed = 0;
foreach ($testCases as $tc) {
    $res = RoutePricingService::calculateTripPrice($tc['dist'], $tc['days'], $tc['rate']);
    $exp = $tc['expected'];
    $ok = ($res['roundTripKm'] === $exp['roundTrip'] &&
           $res['minimumBillableKm'] === $exp['min'] &&
           $res['billableKm'] === $exp['billable'] &&
           $res['totalPrice'] === $exp['total']);
    
    if ($ok) {
        echo "[PASS] " . $tc['name'] . ": dist={$tc['dist']}, days={$tc['days']}, rate={$tc['rate']} => total={$res['formattedPrice']}" . PHP_EOL;
    } else {
        $failed++;
        echo "[FAIL] " . $tc['name'] . ": got " . json_encode($res) . " expected " . json_encode($exp) . PHP_EOL;
    }
}

// Edge Cases:
// Missing distance:
$resZero = RoutePricingService::calculateTripPrice(0, 1, 45);
echo "Zero distance: isValid=" . ($resZero['isValid'] ? 'true' : 'false') . ", formatted=" . $resZero['formattedPrice'] . PHP_EOL;

// Invalid days:
$resDaysLow = RoutePricingService::calculateTripPrice(100, 0, 45);
echo "Days low clamped (0 -> 1): selectedDays=" . $resDaysLow['selectedDays'] . ", billable=" . $resDaysLow['billableKm'] . PHP_EOL;
$resDaysHigh = RoutePricingService::calculateTripPrice(100, 15, 45);
echo "Days high clamped (15 -> 10): selectedDays=" . $resDaysHigh['selectedDays'] . ", minLimit=" . $resDaysHigh['minimumBillableKm'] . PHP_EOL;

// Invalid rate:
$resRateZero = RoutePricingService::calculateTripPrice(100, 1, 0);
echo "Zero rate: isValid=" . ($resRateZero['isValid'] ? 'true' : 'false') . ", formatted=" . $resRateZero['formattedPrice'] . PHP_EOL;

if ($failed === 0) {
    echo "ALL 5 EXAMPLES PASSED PERFECTLY!" . PHP_EOL;
}
