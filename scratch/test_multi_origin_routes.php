<?php
require_once __DIR__ . '/../includes/destinations-data.php';
require_once __DIR__ . '/../includes/services/UrbaniaPricingService.php';

$origins = ['delhi', 'gurgaon', 'noida', 'ghaziabad', 'faridabad'];
echo "=== TESTING MULTI-ORIGIN ROUTES PRICING ===\n";

foreach ($origins as $orig) {
    $routes = get_all_destinations($orig);
    echo "Origin '{$orig}': " . count($routes) . " routes found.\n";
    if (!empty($routes)) {
        $firstRoute = $routes[0];
        $slug = $firstRoute['slug'];
        $dist = $firstRoute['distance'];
        $calc = UrbaniaPricingService::calculateTripPrice($dist, 4, 45);
        $expectedRoundTrip = $dist * 2;
        $expectedChargeable = 1000;
        $expectedBillable = max($expectedRoundTrip, $expectedChargeable);
        $expectedFare = $expectedBillable * 45;
        
        $match = ($calc['roundTripKm'] === $expectedRoundTrip && 
                  $calc['chargeableDistanceKm'] === $expectedChargeable && 
                  $calc['billableKm'] === $expectedBillable &&
                  $calc['totalFare'] === $expectedFare);
        
        echo "  Sample: {$firstRoute['origin']} to {$firstRoute['destination']} ({$dist} km one-way) -> 4 Days: {$calc['formattedPrice']} [" . ($match ? "PASS" : "FAIL") . "]\n";
    }
}
