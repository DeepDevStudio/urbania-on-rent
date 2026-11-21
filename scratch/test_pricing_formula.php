<?php
require_once __DIR__ . '/../includes/services/UrbaniaPricingService.php';
require_once __DIR__ . '/../includes/site-data.php';

$testCases = [
    1  => ['min' => 250,  'expected' => 59400],
    2  => ['min' => 500,  'expected' => 59400],
    3  => ['min' => 750,  'expected' => 59400],
    4  => ['min' => 1000, 'expected' => 59400],
    5  => ['min' => 1250, 'expected' => 59400],
    6  => ['min' => 1500, 'expected' => 67500],
    7  => ['min' => 1750, 'expected' => 78750],
    8  => ['min' => 2000, 'expected' => 90000],
    9  => ['min' => 2250, 'expected' => 101250],
    10 => ['min' => 2500, 'expected' => 112500],
];

echo "=== TEST SUITE 1: 1,320 km Round Trip (Delhi to Udaipur, 660 km one-way) at ₹45/km ===\n";
$allPassed = true;

foreach ($testCases as $days => $expected) {
    $result = UrbaniaPricingService::calculateTripPrice(660, $days, 45);
    $passMin = ($result['chargeableDistanceKm'] === $expected['min']);
    $passFare = ($result['totalFare'] === $expected['expected']);
    
    $status = ($passMin && $passFare) ? "PASS" : "FAIL";
    if ($status === "FAIL") $allPassed = false;
    
    echo sprintf(
        "Day %2d | Chargeable: %4d km (exp %4d) | Billable: %4d km | Fare: %s (exp ₹%s) | [%s]\n",
        $days,
        $result['chargeableDistanceKm'],
        $expected['min'],
        $result['billableKm'],
        $result['formattedPrice'],
        number_format($expected['expected']),
        $status
    );
}

echo "\n=== TEST SUITE 2: Short Route (Delhi to Agra, 210 km one-way, 420 km round-trip) at ₹45/km ===\n";
// Day 1: max(420, 250) = 420 -> 420 * 45 = 18,900
// Day 2: max(420, 500) = 500 -> 500 * 45 = 22,500
// Day 3: max(420, 750) = 750 -> 750 * 45 = 33,750
$shortTests = [
    1 => ['chargeable' => 250, 'billable' => 420, 'fare' => 18900],
    2 => ['chargeable' => 500, 'billable' => 500, 'fare' => 22500],
    3 => ['chargeable' => 750, 'billable' => 750, 'fare' => 33750],
];
foreach ($shortTests as $days => $exp) {
    $res = UrbaniaPricingService::calculateTripPrice(210, $days, 45);
    $pass = ($res['chargeableDistanceKm'] === $exp['chargeable'] && $res['billableKm'] === $exp['billable'] && $res['totalFare'] === $exp['fare']);
    if (!$pass) $allPassed = false;
    echo sprintf(
        "Day %d | Chargeable: %d km | Billable: %d km | Fare: %s | [%s]\n",
        $days,
        $res['chargeableDistanceKm'],
        $res['billableKm'],
        $res['formattedPrice'],
        $pass ? "PASS" : "FAIL"
    );
}

echo "\n=== TEST SUITE 3: Authoritative Backend Quote via getAuthoritativeQuote ===\n";
$quote = UrbaniaPricingService::getAuthoritativeQuote('delhi-to-udaipur-urbania', '9-seater', 4);
echo "Delhi to Udaipur (9-seater, 4 days):\n";
echo "Origin: {$quote['origin']}, Destination: {$quote['destination']}\n";
echo "RoundTrip: {$quote['roundTripKm']} km\n";
echo "Chargeable: {$quote['chargeableDistanceKm']} km\n";
echo "Billable: {$quote['billableKm']} km\n";
echo "Vehicle Rate: ₹{$quote['vehicleRatePerKm']}/km\n";
echo "Fare: {$quote['formattedPrice']}\n";
if ($quote['formattedPrice'] === '₹59,400' && $quote['billableKm'] === 1320) {
    echo "Quote Test: [PASS]\n";
} else {
    echo "Quote Test: [FAIL]\n";
    $allPassed = false;
}

echo "\n=== TEST SUITE 4: 16 Seater Rate (₹40/km) for 4 days Udaipur ===\n";
$quote16 = UrbaniaPricingService::getAuthoritativeQuote('delhi-to-udaipur-urbania', '16-seater', 4);
echo "Fare: {$quote16['formattedPrice']} (expected 1320 * 40 = ₹52,800)\n";
if ($quote16['formattedPrice'] === '₹52,800') {
    echo "16 Seater Test: [PASS]\n";
} else {
    echo "16 Seater Test: [FAIL]\n";
    $allPassed = false;
}

echo "\n=========================================\n";
if ($allPassed) {
    echo "ALL MANDATORY PRICING TESTS PASSED 100%!\n";
} else {
    echo "SOME TESTS FAILED!\n";
    exit(1);
}
