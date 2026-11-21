<?php
/**
 * api/calculate-price.php
 * Authoritative Backend Price Calculation Endpoint
 * Urbania on Rent Delhi (https://urbaniaonrentdelhi.co.in)
 *
 * Uses UrbaniaPricingService to recalculate all pricing authoritatively.
 * Formula: roundTripKm = oneWayKm * 2;
 *          chargeableDistanceKm = 250 * selectedDays;
 *          billableKm = Math.max(roundTripKm, chargeableDistanceKm);
 *          totalFare = billableKm * vehicleRatePerKm;
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/services/UrbaniaPricingService.php';

$slug = isset($_REQUEST['slug']) ? trim($_REQUEST['slug']) : (isset($_REQUEST['route']) ? trim($_REQUEST['route']) : '');
$vehicle = isset($_REQUEST['vehicle']) ? trim($_REQUEST['vehicle']) : (isset($_REQUEST['vehicle_id']) ? trim($_REQUEST['vehicle_id']) : '9-seater');
$days = isset($_REQUEST['days']) ? (int)$_REQUEST['days'] : 1;

if (empty($slug)) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Missing route slug parameter'
    ]);
    exit;
}

$quote = UrbaniaPricingService::getAuthoritativeQuote($slug, $vehicle, $days);

if (!$quote['isValid']) {
    http_response_code(200);
    echo json_encode([
        'status'  => 'unavailable',
        'message' => $quote['error'] ?? 'Distance unavailable or unverified',
        'data'    => $quote
    ]);
    exit;
}

echo json_encode([
    'status' => 'success',
    'data'   => $quote
]);
