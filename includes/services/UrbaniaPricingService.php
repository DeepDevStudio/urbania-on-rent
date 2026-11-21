<?php
/**
 * UrbaniaPricingService.php
 * Centralized Pricing Engine for Force Urbania Route Trips
 * Urbania on Rent Delhi (https://urbaniaonrentdelhi.co.in)
 *
 * FINAL APPROVED PRICING FORMULA:
 * Urbania vehicles are booked for round trips only.
 * The daily minimum distance is 250 km.
 * Number of days can be selected from 1 to 10.
 *
 * Calculate:
 * const roundTripKm = oneWayKm * 2;
 * const chargeableDistanceKm = 250 * selectedDays;
 * const billableKm = Math.max(roundTripKm, chargeableDistanceKm);
 * const totalFare = billableKm * vehicleRatePerKm;
 *
 * IMPORTANT:
 * The chargeableDistanceKm value is the minimum kilometres calculated according to selected days.
 * The actual billable kilometres are whichever is greater:
 * - Round-trip distance
 * - Chargeable distance (250 × selected days)
 * Never add these two distances together.
 * Never multiply the round-trip distance by the number of days.
 * Never multiply one-way distance by the number of days.
 */

class UrbaniaPricingService {
    const DAILY_MIN_KM = 250;
    const MIN_DAYS     = 1;
    const MAX_DAYS     = 10;

    /**
     * Calculate authoritative trip price and distance breakdown
     *
     * @param float|int $oneWayDistanceKm Positive distance in km
     * @param int $numberOfDays Integer between 1 and 10
     * @param float|int $vehicleRatePerKm Positive per-km rate from fleet configuration
     * @return array
     */
    public static function calculateTripPrice($oneWayDistanceKm, $numberOfDays = 1, $vehicleRatePerKm = 45) {
        $dist = (float)$oneWayDistanceKm;
        $days = (int)$numberOfDays;
        $rate = (float)$vehicleRatePerKm;

        // Validation: Positive verified distance required
        if ($dist <= 0) {
            return [
                'isValid'              => false,
                'isAvailable'          => false,
                'error'                => 'Distance unavailable or unverified',
                'oneWayDistanceKm'     => 0,
                'roundTripKm'          => 0,
                'chargeableDistanceKm' => 0,
                'minimumKm'            => 0,
                'billableKm'           => 0,
                'totalBillableKm'      => 0,
                'selectedDays'         => max(self::MIN_DAYS, min(self::MAX_DAYS, $days)),
                'days'                 => max(self::MIN_DAYS, min(self::MAX_DAYS, $days)),
                'ratePerKm'            => $rate > 0 ? (int)round($rate) : 0,
                'vehicleRatePerKm'     => $rate > 0 ? (int)round($rate) : 0,
                'totalFare'            => 0,
                'totalPrice'           => 0,
                'formattedPrice'       => 'Price available on request'
            ];
        }

        // Clamp days between 1 and 10
        if ($days < self::MIN_DAYS) {
            $days = self::MIN_DAYS;
        } elseif ($days > self::MAX_DAYS) {
            $days = self::MAX_DAYS;
        }

        // Validation: Positive rate required
        if ($rate <= 0) {
            return [
                'isValid'              => false,
                'isAvailable'          => false,
                'error'                => 'Invalid vehicle rate',
                'oneWayDistanceKm'     => (int)round($dist),
                'roundTripKm'          => (int)round($dist * 2),
                'chargeableDistanceKm' => (int)($days * self::DAILY_MIN_KM),
                'minimumKm'            => (int)($days * self::DAILY_MIN_KM),
                'billableKm'           => 0,
                'totalBillableKm'      => 0,
                'selectedDays'         => $days,
                'days'                 => $days,
                'ratePerKm'            => 0,
                'vehicleRatePerKm'     => 0,
                'totalFare'            => 0,
                'totalPrice'           => 0,
                'formattedPrice'       => 'Price available on request'
            ];
        }

        // Exact Approved Pricing Logic:
        // const roundTripKm = oneWayKm * 2;
        // const chargeableDistanceKm = 250 * selectedDays;
        // const billableKm = Math.max(roundTripKm, chargeableDistanceKm);
        // const totalFare = billableKm * vehicleRatePerKm;
        $roundTripKm          = (int)round($dist * 2);
        $chargeableDistanceKm = (int)($days * self::DAILY_MIN_KM);
        $billableKm           = (int)max($roundTripKm, $chargeableDistanceKm);
        $totalFare            = (int)round($billableKm * $rate);

        return [
            'isValid'              => true,
            'isAvailable'          => true,
            'error'                => null,
            'oneWayDistanceKm'     => (int)round($dist),
            'roundTripKm'          => $roundTripKm,
            'chargeableDistanceKm' => $chargeableDistanceKm,
            'minimumKm'            => $chargeableDistanceKm, // backward-compatibility alias
            'billableKm'           => $billableKm,
            'totalBillableKm'      => $billableKm,
            'selectedDays'         => $days,
            'days'                 => $days,
            'ratePerKm'            => (int)round($rate),
            'vehicleRatePerKm'     => (int)round($rate),
            'totalFare'            => $totalFare,
            'totalPrice'           => $totalFare,
            'formattedPrice'       => '₹' . number_format($totalFare)
        ];
    }

    /**
     * Authoritative backend price lookup based on route slug, vehicle slug, and days
     * Never trusts browser-submitted prices, distances or rates.
     *
     * @param string $routeSlug Route slug or identifier
     * @param string $vehicleSlug Vehicle slug (e.g. '9-seater', '12-seater', '16-seater')
     * @param int $days Number of days (1-10)
     * @return array
     */
    public static function getAuthoritativeQuote($routeSlug, $vehicleSlug, $days = 1) {
        require_once dirname(__DIR__) . '/site-data.php';
        require_once dirname(__DIR__) . '/destinations-data.php';
        $fleetList = $GLOBALS['fleet'] ?? (isset($fleet) ? $fleet : []);

        $dest = get_destination_by_slug($routeSlug);
        if (!$dest) {
            return [
                'isValid' => false,
                'error'   => 'Route not found in official route matrix',
                'formattedPrice' => 'Price available on request'
            ];
        }

        $oneWayDistanceKm = (isset($dest['distance']) && is_numeric($dest['distance'])) ? (int)$dest['distance'] : 0;
        
        // Find vehicle rate from centralized fleet config
        $vehicleRate = 0;
        $vehicleName = '';
        foreach ($fleetList as $v) {
            if ($v['slug'] === $vehicleSlug) {
                $vehicleRate = (int)$v['price'];
                $vehicleName = $v['name'];
                break;
            }
        }

        if ($vehicleRate <= 0) {
            return [
                'isValid' => false,
                'error'   => 'Vehicle not found or rate unconfigured in fleet database',
                'formattedPrice' => 'Price available on request'
            ];
        }

        $calc = self::calculateTripPrice($oneWayDistanceKm, $days, $vehicleRate);
        $calc['routeSlug'] = $routeSlug;
        $calc['origin'] = $dest['origin'] ?? 'Delhi';
        $calc['destination'] = $dest['destination'] ?? 'Outstation';
        $calc['vehicleSlug'] = $vehicleSlug;
        $calc['vehicleName'] = $vehicleName;

        return $calc;
    }
}
