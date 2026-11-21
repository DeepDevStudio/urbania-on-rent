<?php
require_once __DIR__ . '/includes/services/RoutePricingService.php';
require_once __DIR__ . '/includes/destinations-data.php';
require_once __DIR__ . '/includes/site-data.php';

echo "========================================================================\n";
echo "AUTOMATED VERIFICATION SUITE — DYNAMIC ROUTE PRICING CALCULATOR\n";
echo "========================================================================\n\n";

$passCount = 0;
$failCount = 0;

function assertTest($condition, $description) {
    global $passCount, $failCount;
    if ($condition) {
        $passCount++;
        echo " [PASS] $description\n";
    } else {
        $failCount++;
        echo " [FAIL] $description\n";
    }
}

// -------------------------------------------------------------
// TEST 1: Phase 5 Examples
// -------------------------------------------------------------
echo "1. VERIFYING PHASE 5 EXAMPLES:\n";

// Example 1: D=100, N=1, R=45 => Total: 11250
$res1 = RoutePricingService::calculateTripPrice(100, 1, 45);
assertTest($res1['roundTripKm'] === 200 && $res1['minimumBillableKm'] === 250 && $res1['billableKm'] === 250 && $res1['totalPrice'] === 11250,
    "Example 1: D=100km, N=1 day, R=45 => RoundTrip=200km, Min=250km, Billable=250km, Total=Rs 11,250");

// Example 2: D=200, N=1, R=45 => Total: 18000
$res2 = RoutePricingService::calculateTripPrice(200, 1, 45);
assertTest($res2['roundTripKm'] === 400 && $res2['minimumBillableKm'] === 250 && $res2['billableKm'] === 400 && $res2['totalPrice'] === 18000,
    "Example 2: D=200km, N=1 day, R=45 => RoundTrip=400km, Min=250km, Billable=400km, Total=Rs 18,000");

// Example 3: D=200, N=2, R=45 => Total: 22500
$res3 = RoutePricingService::calculateTripPrice(200, 2, 45);
assertTest($res3['roundTripKm'] === 400 && $res3['minimumBillableKm'] === 500 && $res3['billableKm'] === 500 && $res3['totalPrice'] === 22500,
    "Example 3: D=200km, N=2 days, R=45 => RoundTrip=400km, Min=500km, Billable=500km, Total=Rs 22,500");

// Example 4: D=400, N=3, R=45 => Total: 36000
$res4 = RoutePricingService::calculateTripPrice(400, 3, 45);
assertTest($res4['roundTripKm'] === 800 && $res4['minimumBillableKm'] === 750 && $res4['billableKm'] === 800 && $res4['totalPrice'] === 36000,
    "Example 4: D=400km, N=3 days, R=45 => RoundTrip=800km, Min=750km, Billable=800km, Total=Rs 36,000");

// Example 5: D=200, N=10, R=40 => Total: 100000
$res5 = RoutePricingService::calculateTripPrice(200, 10, 40);
assertTest($res5['roundTripKm'] === 400 && $res5['minimumBillableKm'] === 2500 && $res5['billableKm'] === 2500 && $res5['totalPrice'] === 100000,
    "Example 5: D=200km, N=10 days, R=40 => RoundTrip=400km, Min=2500km, Billable=2500km, Total=Rs 1,00,000");

// -------------------------------------------------------------
// TEST 2: All Days 1 to 10 for a standard 220 km route (e.g. Haridwar)
// -------------------------------------------------------------
echo "\n2. VERIFYING ALL DAYS 1 THROUGH 10 (D=220 km, R=45/km):\n";
for ($d = 1; $d <= 10; $d++) {
    $r = RoutePricingService::calculateTripPrice(220, $d, 45);
    $expMin = $d * 250;
    $expBillable = max(440, $expMin);
    $expTotal = $expBillable * 45;
    assertTest($r['billableKm'] === $expBillable && $r['totalPrice'] === $expTotal,
        "Day $d: Min={$expMin}km, Billable={$expBillable}km, Total=Rs " . number_format($expTotal));
}

// -------------------------------------------------------------
// TEST 3: Edge Cases (Missing distance, clamping, zero rate)
// -------------------------------------------------------------
echo "\n3. VERIFYING EDGE CASES & INPUT VALIDATION:\n";
$eZeroDist = RoutePricingService::calculateTripPrice(0, 2, 45);
assertTest($eZeroDist['isValid'] === false && $eZeroDist['formattedPrice'] === 'Price available on request',
    "Distance 0: Handled safely, isValid=false, 'Price available on request'");

$eNegDist = RoutePricingService::calculateTripPrice(-50, 1, 45);
assertTest($eNegDist['isValid'] === false, "Negative distance: Handled safely, isValid=false");

$eClampLow = RoutePricingService::calculateTripPrice(200, 0, 45);
assertTest($eClampLow['selectedDays'] === 1, "Days=0 clamped to minimum 1 day");

$eClampHigh = RoutePricingService::calculateTripPrice(200, 15, 45);
assertTest($eClampHigh['selectedDays'] === 10, "Days=15 clamped to maximum 10 days");

$eZeroRate = RoutePricingService::calculateTripPrice(200, 1, 0);
assertTest($eZeroRate['isValid'] === false, "Zero rate: Handled safely, isValid=false");

// -------------------------------------------------------------
// TEST 4: Representative Routes from ALL 5 Origin Cities
// -------------------------------------------------------------
echo "\n4. VERIFYING MULTI-ORIGIN ROUTES (5 Origins):\n";
$origins = [
    'delhi'     => 'delhi-to-agra-urbania-on-rent',
    'gurgaon'   => 'gurgaon-to-jaipur-urbania-on-rent',
    'noida'     => 'noida-to-rishikesh-urbania-on-rent',
    'ghaziabad' => 'ghaziabad-to-haridwar-urbania-on-rent',
    'faridabad' => 'faridabad-to-manali-urbania-on-rent'
];

foreach ($origins as $org => $slug) {
    $routeData = get_destination_by_slug($slug);
    assertTest(!empty($routeData) && $routeData['distance'] > 0,
        "Origin '$org' lookup for '$slug' resolved with distance {$routeData['distance']} km");

    foreach ($fleet as $v) {
        $calcRes = RoutePricingService::calculateTripPrice($routeData['distance'], 1, $v['price']);
        assertTest($calcRes['isValid'] && $calcRes['totalPrice'] > 0,
            "   -> {$v['name']} (₹{$v['price']}/km): 1-Day Total = {$calcRes['formattedPrice']}");
    }
}

// -------------------------------------------------------------
// TEST 5: Frontend JS formula equivalence check
// -------------------------------------------------------------
echo "\n5. FRONTEND VS BACKEND PRICING FORMULA PARITY:\n";
// Frontend JS formula:
// const roundTripKm = onewayKm * 2;
// const minimumBillableKm = selectedDays * 250;
// const billableKm = Math.max(roundTripKm, minimumBillableKm);
// const totalPrice = billableKm * ratePerKm;
$distances = [75, 125, 210, 275, 340, 530, 820];
$daysArr = [1, 2, 3, 4, 5, 7, 10];
$ratesArr = [40, 45];
$parityPassed = true;

foreach ($distances as $dist) {
    foreach ($daysArr as $days) {
        foreach ($ratesArr as $rate) {
            $backend = RoutePricingService::calculateTripPrice($dist, $days, $rate)['totalPrice'];
            // Simulate JS exactly
            $js_roundTrip = $dist * 2;
            $js_min = $days * 250;
            $js_billable = max($js_roundTrip, $js_min);
            $js_total = $js_billable * $rate;
            if ($backend !== $js_total) {
                $parityPassed = false;
                echo "   Mismatch for D=$dist, N=$days, R=$rate: Backend=$backend, JS=$js_total\n";
            }
        }
    }
}
assertTest($parityPassed, "98 distinct parameter combinations tested: 100% exact parity between Frontend JS & Backend PHP");

echo "\n========================================================================\n";
echo "SUMMARY: " . $passCount . " PASSED, " . $failCount . " FAILED\n";
echo "========================================================================\n";
