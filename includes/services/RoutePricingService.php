<?php
/**
 * RoutePricingService.php
 * Compatibility wrapper delegating to UrbaniaPricingService
 * Ensures 100% unified pricing across all entrypoints.
 */

require_once __DIR__ . '/UrbaniaPricingService.php';

class RoutePricingService {
    const DAILY_MIN_KM = UrbaniaPricingService::DAILY_MIN_KM;
    const MIN_DAYS     = UrbaniaPricingService::MIN_DAYS;
    const MAX_DAYS     = UrbaniaPricingService::MAX_DAYS;

    public static function calculateTripPrice($oneWayDistanceKm, $numberOfDays = 1, $vehicleRatePerKm = 45) {
        return UrbaniaPricingService::calculateTripPrice($oneWayDistanceKm, $numberOfDays, $vehicleRatePerKm);
    }

    public static function getAuthoritativeQuote($routeSlug, $vehicleSlug, $days = 1) {
        return UrbaniaPricingService::getAuthoritativeQuote($routeSlug, $vehicleSlug, $days);
    }
}
