<?php
/**
 * route-pricing-component.php
 * Reusable Dynamic Force Urbania Pricing Calculator Component
 * Urbania on Rent Delhi (https://urbaniaonrentdelhi.co.in)
 *
 * FINAL APPROVED PRICING FORMULA:
 * Urbania vehicles are booked for round trips only.
 * The daily minimum distance is 250 km.
 * Number of days can be selected from 1 to 10.
 *
 * const roundTripKm = oneWayKm * 2;
 * const chargeableDistanceKm = 250 * selectedDays;
 * const billableKm = Math.max(roundTripKm, chargeableDistanceKm);
 * const totalFare = billableKm * vehicleRatePerKm;
 *
 * Applicable for all ~3,055 destination routes across Delhi, Gurgaon, Noida, Ghaziabad, Faridabad
 */

require_once __DIR__ . '/site-data.php';
require_once __DIR__ . '/services/UrbaniaPricingService.php';
require_once __DIR__ . '/destinations-data.php';

// Detect and verify route context if not supplied
if (!isset($dest) || empty($dest)) {
    $cur_slug = isset($_GET['slug']) ? trim($_GET['slug']) : basename($_SERVER['PHP_SELF'], '.php');
    $dest = get_destination_by_slug($cur_slug);
}

$origin_name = !empty($dest['origin']) ? $dest['origin'] : (isset($origin_name) ? $origin_name : 'Delhi');
$destination_name = !empty($dest['destination']) ? $dest['destination'] : (isset($dest['destination']) ? $dest['destination'] : 'Outstation');
$one_way_distance = (isset($dest['distance']) && is_numeric($dest['distance'])) ? (int)$dest['distance'] : 0;
$distance_str = !empty($dest['distance_str']) ? $dest['distance_str'] : ($one_way_distance > 0 ? (number_format($one_way_distance) . ' km') : 'On request');
$travel_time = !empty($dest['estimated_travel_time']) ? $dest['estimated_travel_time'] : 'Flexible';
$has_verified_distance = ($one_way_distance > 0);
$wa_contact_phone = !empty($site_whatsapp) ? $site_whatsapp : '917290885949';
?>

<!-- Dynamic Route Pricing Calculator Section -->
<section class="premium-pricing" id="pricing" style="scroll-margin-top: 70px; padding: 45px 0 55px; background: #ffffff;">
    <style>
        .pricing-calc-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .pricing-calc-kicker {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #b0851e;
            background: #fbf7ec;
            border: 1px solid rgba(212, 175, 55, 0.4);
            padding: 4px 14px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .pricing-calc-title {
            font-size: clamp(1.6rem, 3vw, 2.1rem);
            color: #0f172a;
            font-weight: 900;
            margin: 4px 0 8px;
            line-height: 1.25;
        }
        .pricing-calc-title span {
            color: #c9a23a;
        }
        .pricing-calc-subtitle {
            color: #64748b;
            font-size: 0.98rem;
            max-width: 680px;
            margin: 0 auto;
            line-height: 1.5;
        }
        .route-distance-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 18px;
            border-radius: 30px;
            margin-top: 14px;
            font-size: 0.86rem;
            color: #334155;
            font-weight: 600;
        }
        .route-distance-chip i {
            color: #c9a23a;
        }

        /* Compact Grid Layout */
        .pricing-compact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 24px;
        }
        .pricing-calc-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        }
        .pricing-calc-card:hover {
            transform: translateY(-4px);
            border-color: #c9a23a;
            box-shadow: 0 12px 28px -8px rgba(15, 23, 42, 0.14);
        }

        /* Compact Vehicle Media */
        .pricing-card-media {
            position: relative;
            height: 175px;
            background: #0f172a;
            overflow: hidden;
        }
        .pricing-card-media img {
            width: 100%;
            height: 100% !important;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .pricing-calc-card:hover .pricing-card-media img {
            transform: scale(1.04);
        }
        .pricing-card-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(11, 19, 36, 0.85);
            color: #e2c46b;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.70rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 2;
            border: 1px solid rgba(226, 196, 107, 0.25);
        }

        /* Compact Vehicle Body */
        .pricing-card-body {
            padding: 15px 16px 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        /* Title & Meta Bar */
        .pricing-card-head {
            margin-bottom: 8px;
        }
        .pricing-card-title {
            font-size: 1.08rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 6px;
            font-family: 'Montserrat', sans-serif;
            line-height: 1.3;
        }
        .pricing-meta-pills {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .meta-pill-rate {
            background: #fffcf0;
            color: #926c09;
            border: 1px solid rgba(212, 175, 55, 0.4);
            font-size: 0.78rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 6px;
        }
        .meta-pill-seats {
            background: #f1f5f9;
            color: #1e293b;
            font-size: 0.74rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Compact 2-Column Features */
        .pricing-card-feats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 6px;
            margin: 8px 0 12px;
            padding: 0;
            list-style: none;
        }
        .pricing-card-feats li {
            font-size: 0.74rem;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.35;
        }
        .pricing-card-feats i {
            color: #16a34a;
            font-size: 0.68rem;
            flex-shrink: 0;
        }

        /* SECTION A: Number of Days Selector */
        .calc-days-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .calc-days-label {
            font-size: 0.75rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }
        .calc-days-label i {
            color: #c9a23a;
        }
        .calc-days-select {
            padding: 5px 26px 5px 10px;
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #0f172a;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%230f172a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 13px;
        }
        .calc-days-select:hover,
        .calc-days-select:focus {
            border-color: #c9a23a;
            box-shadow: 0 0 0 2px rgba(201, 162, 58, 0.2);
        }

        /* SECTION B: Simplified Trip Price Panel */
        .calc-compact-panel {
            background: #fffdf8;
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }
        .calc-compact-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed rgba(212, 175, 55, 0.25);
        }
        .calc-compact-title {
            font-size: 0.74rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .calc-compact-title i {
            color: #c9a23a;
        }
        .calc-meta-rate {
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
        }
        .calc-meta-rate strong {
            color: #0f172a;
        }

        /* Simplified Key-Value Breakdown List (Only 2 rows) */
        .calc-breakdown-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 10px;
        }
        .calc-breakdown-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: #475569;
            padding: 2px 0;
            line-height: 1.4;
        }
        .calc-breakdown-row .val {
            font-weight: 800;
            color: #0f172a;
        }

        /* Prominent Total Price Bar */
        .calc-total-bar {
            background: #ffffff;
            border: 1.5px solid rgba(212, 175, 55, 0.45);
            border-radius: 8px;
            padding: 9px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }
        .calc-total-left {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .calc-total-label {
            font-size: 0.72rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .calc-total-note {
            font-size: 0.65rem;
            color: #16a34a;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .calc-total-price {
            font-size: 1.35rem;
            font-weight: 900;
            color: #0f172a;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: -0.5px;
        }

        /* Compact Action Button */
        .calc-book-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            color: #ffffff !important;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.86rem;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.12);
            margin-top: auto;
        }
        .calc-book-btn i {
            color: #25D366;
            font-size: 1.05rem;
            transition: transform 0.2s ease;
        }
        .calc-book-btn:hover {
            background: linear-gradient(135deg, #e2c46b, #c9a23a);
            color: #0f172a !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(201, 162, 58, 0.35);
        }
        .calc-book-btn:hover i {
            color: #0f172a;
            transform: scale(1.1);
        }

        .calc-unavailable-notice {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #9a3412;
            padding: 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        /* Compact Inclusions Bar */
        .calc-inclusions-banner {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
        }
        .calc-inclusion-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.82rem;
            color: #334155;
            font-weight: 600;
        }
        .calc-inclusion-item i {
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        @media (max-width: 992px) {
            .pricing-compact-grid { grid-template-columns: 1fr; max-width: 440px; margin-left: auto; margin-right: auto; }
            .pricing-card-media { height: 200px; }
            .pricing-calc-header { margin-bottom: 20px; }
            .calc-inclusions-banner { padding: 14px; gap: 12px; grid-template-columns: 1fr; }
        }
    </style>

    <div class="container">
        <!-- Section Header -->
        <div class="pricing-calc-header">
            <span class="pricing-calc-kicker"><i class="fas fa-calculator"></i> Confirmed Round-Trip Pricing Engine</span>
            <h2 class="pricing-calc-title"><?php echo htmlspecialchars($origin_name); ?> to <?php echo htmlspecialchars($destination_name); ?> Urbania <span>Pricing &amp; Fares</span></h2>
            <p class="pricing-calc-subtitle">Urbania vehicles are booked for round trips. Select your trip duration (1–10 days) below to calculate the exact estimated fare based on verified road distance.</p>
            
            <div class="route-distance-chip">
                <span><i class="fas fa-route"></i> One-Way: <strong><?php echo htmlspecialchars($distance_str); ?></strong></span>
                <span>•</span>
                <span><i class="fas fa-arrows-split-up-and-left"></i> Round Trip: <strong><?php echo $has_verified_distance ? (number_format($one_way_distance * 2) . ' km') : 'On request'; ?></strong></span>
                <span>•</span>
                <span><i class="fas fa-gauge-high"></i> Min Daily: <strong>250 km/day</strong></span>
                <span>•</span>
                <span><i class="fas fa-calendar-check"></i> 1 to 10 Days Booking</span>
            </div>
        </div>

        <!-- Vehicle Cards with Live Pricing Calculator -->
        <div class="pricing-compact-grid" id="pricingGrid">
            <?php 
            foreach ($fleet as $idx => $v): 
                $vehicleRate = (int)$v['price'];
                $vehicleSlug = $v['slug'];
                $vehicleName = $v['name'];
                
                // Authoritative initial calculation (Day 1) using confirmed formula:
                // billableKm = MAX(roundTripKm, 250 * selectedDays)
                // totalFare = billableKm * vehicleRate
                $initial = UrbaniaPricingService::calculateTripPrice($one_way_distance, 1, $vehicleRate);
                
                // Generate WhatsApp enquiry link for Day 1 initial state
                if ($has_verified_distance && $initial['isValid']) {
                    $wa_msg = "Hello, I want to check availability for " . $vehicleName . " for " . $origin_name . " to " . $destination_name . " round-trip tour.\n"
                            . "• Trip Type: Round Trip (Mandatory)\n"
                            . "• Origin: " . $origin_name . "\n"
                            . "• Destination: " . $destination_name . "\n"
                            . "• Vehicle: " . $vehicleName . " (ID: " . $vehicleSlug . ")\n"
                            . "• Round-Trip Distance: " . number_format($initial['roundTripKm']) . " km\n"
                            . "• Selected Duration: 1 Day\n"
                            . "• Chargeable Distance (250 × 1 Day): " . number_format($initial['chargeableDistanceKm']) . " km\n"
                            . "• Billable Distance: " . number_format($initial['billableKm']) . " km\n"
                            . "• Vehicle Rate: ₹" . $vehicleRate . "/km\n"
                            . "• Total Estimated Fare: " . $initial['formattedPrice'] . "\n"
                            . "Please confirm chauffeur availability and final booking quote.";
                } else {
                    $wa_msg = "Hello, I want to check availability and price quote for " . $vehicleName . " (ID: " . $vehicleSlug . ") for " . $origin_name . " to " . $destination_name . " round-trip tour. Please share price quote.";
                }
                $initial_wa_link = "https://wa.me/" . $wa_contact_phone . "?text=" . rawurlencode($wa_msg);
            ?>
            <article class="pricing-calc-card" 
                     data-vehicle-id="<?php echo htmlspecialchars($vehicleSlug); ?>"
                     data-vehicle-name="<?php echo htmlspecialchars($vehicleName); ?>"
                     data-vehicle-rate="<?php echo $vehicleRate; ?>"
                     data-oneway-km="<?php echo $one_way_distance; ?>"
                     data-origin="<?php echo htmlspecialchars($origin_name); ?>"
                     data-destination="<?php echo htmlspecialchars($destination_name); ?>"
                     data-whatsapp-number="<?php echo htmlspecialchars($wa_contact_phone); ?>">
                
                <!-- Vehicle Media -->
                <div class="pricing-card-media">
                    <img src="<?php echo htmlspecialchars($v['img']); ?>" alt="<?php echo htmlspecialchars($v['alt']); ?>" loading="lazy">
                    <span class="pricing-card-tag"><?php echo htmlspecialchars($v['tag']); ?></span>
                </div>

                <!-- Vehicle Body -->
                <div class="pricing-card-body">
                    <!-- Title & Meta Bar -->
                    <div class="pricing-card-head">
                        <h3 class="pricing-card-title"><?php echo htmlspecialchars($vehicleName); ?></h3>
                        <div class="pricing-meta-pills">
                            <span class="meta-pill-rate">₹<?php echo $vehicleRate; ?> / km</span>
                            <span class="meta-pill-seats"><i class="fas fa-users"></i> <?php echo htmlspecialchars($v['seats']); ?> + 1</span>
                        </div>
                    </div>

                    <!-- Compact Features List -->
                    <ul class="pricing-card-feats">
                        <?php foreach ($v['features'] as $f): ?>
                            <li><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($f); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- SECTION A: Number of Days Selector -->
                    <div class="calc-days-box">
                        <label for="days-<?php echo htmlspecialchars($vehicleSlug); ?>" class="calc-days-label">
                            <i class="fas fa-calendar-day"></i> Number of Days:
                        </label>
                        <select id="days-<?php echo htmlspecialchars($vehicleSlug); ?>" 
                                class="calc-days-select" 
                                aria-label="Select Number of Days for <?php echo htmlspecialchars($vehicleName); ?>"
                                <?php echo !$has_verified_distance ? 'disabled' : ''; ?>>
                            <?php for ($d = 1; $d <= 10; $d++): ?>
                                <option value="<?php echo $d; ?>" <?php echo ($d === 1) ? 'selected' : ''; ?>>
                                    <?php echo $d; ?> <?php echo ($d === 1) ? 'Day' : 'Days'; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- SECTION B: Simplified Trip Price Panel (Only 2 Distance Rows + Total Fare) -->
                    <div class="calc-compact-panel">
                        <div class="calc-compact-header">
                            <span class="calc-compact-title"><i class="fas fa-calculator"></i> Estimated Trip Price</span>
                            <span class="calc-meta-rate">Rate: <strong class="item-rate">₹<?php echo $vehicleRate; ?>/km</strong></span>
                        </div>

                        <?php if ($has_verified_distance && $initial['isValid']): ?>
                            <div class="calc-breakdown-list">
                                <div class="calc-breakdown-row">
                                    <span>Round Trip Distance:</span>
                                    <span class="val item-roundtrip"><?php echo number_format($initial['roundTripKm']); ?> km</span>
                                </div>
                                <div class="calc-breakdown-row">
                                    <span class="item-chargeable-label">Chargeable Distance:</span>
                                    <span class="val item-chargeable"><?php echo number_format($initial['billableKm']); ?> km</span>
                                </div>
                            </div>

                            <div class="calc-total-bar">
                                <div class="calc-total-left">
                                    <span class="calc-total-label">CALCULATED TOTAL FARE</span>
                                    <span class="calc-total-note"><i class="fas fa-check-circle"></i> Driver &amp; Fuel Included</span>
                                </div>
                                <div class="calc-total-price item-totalprice"><?php echo $initial['formattedPrice']; ?></div>
                            </div>
                        <?php else: ?>
                            <div class="calc-unavailable-notice">
                                <i class="fas fa-circle-info"></i> Distance unverified for this custom route.<br>
                                <strong>Price available on request</strong>
                            </div>
                            <div class="calc-total-bar">
                                <div class="calc-total-left">
                                    <span class="calc-total-label">CALCULATED TOTAL FARE</span>
                                    <span class="calc-total-note">Custom Route Quote</span>
                                </div>
                                <div class="calc-total-price item-totalprice" style="font-size: 1rem; color: #b0851e;">Get Quote</div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- SECTION C: Action / Booking Button -->
                    <a href="<?php echo htmlspecialchars($initial_wa_link); ?>" 
                       class="calc-book-btn" 
                       target="_blank" 
                       rel="noopener"
                       data-action="book-urbania">
                        <i class="fab fa-whatsapp"></i> Check Availability / Book Now
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Inclusions & Service Guarantee Banner -->
        <div class="calc-inclusions-banner">
            <div class="calc-inclusion-item">
                <i class="fas fa-gas-pump" style="color: #10b981;"></i>
                <span>Clean Chauffeur-Driven Van &amp; Fuel Included</span>
            </div>
            <div class="calc-inclusion-item">
                <i class="fas fa-receipt" style="color: #D4AF37;"></i>
                <span>Transparent Per-KM Billing (Round-Trip Only)</span>
            </div>
            <div class="calc-inclusion-item">
                <i class="fas fa-shield-halved" style="color: #38bdf8;"></i>
                <span>GPS Tracked, Sanitized Fleet &amp; Safe Drivers</span>
            </div>
            <div class="calc-inclusion-item">
                <i class="fas fa-headset" style="color: #8b5cf6;"></i>
                <span>24/7 Interstate Tour &amp; Route Assistance</span>
            </div>
        </div>
    </div>

    <!-- Client-Side Exact Dynamic Calculation & WhatsApp Message Sync Engine -->
    <script>
    (function() {
        function formatINR(number) {
            return '₹' + Math.round(number).toLocaleString('en-IN');
        }

        function formatKm(km) {
            return Math.round(km).toLocaleString('en-IN') + ' km';
        }

        /**
         * FINAL APPROVED PRICING FORMULA:
         * const roundTripKm = oneWayKm * 2;
         * const chargeableDistanceKm = 250 * selectedDays;
         * const billableKm = Math.max(roundTripKm, chargeableDistanceKm);
         * const totalFare = billableKm * vehicleRatePerKm;
         */
        function calculateUrbaniaFare({ oneWayKm, days, ratePerKm }) {
            if (
                !Number.isFinite(oneWayKm) || oneWayKm <= 0 ||
                !Number.isInteger(days) || days < 1 || days > 10 ||
                !Number.isFinite(ratePerKm) || ratePerKm <= 0
            ) {
                throw new Error("Invalid pricing inputs");
            }
            const roundTripKm = Math.round(oneWayKm * 2);
            const chargeableDistanceKm = Math.round(250 * days);
            const billableKm = Math.max(roundTripKm, chargeableDistanceKm);
            const totalFare = Math.round(billableKm * ratePerKm);
            return {
                oneWayKm,
                roundTripKm,
                days,
                chargeableDistanceKm,
                billableKm,
                ratePerKm,
                totalFare,
                formattedPrice: formatINR(totalFare)
            };
        }

        function updateCardPricing(card) {
            const onewayKm = parseFloat(card.getAttribute('data-oneway-km')) || 0;
            const ratePerKm = parseFloat(card.getAttribute('data-vehicle-rate')) || 45;
            const vehicleId = card.getAttribute('data-vehicle-id') || 'urbania';
            const vehicleName = card.getAttribute('data-vehicle-name') || 'Force Urbania';
            const originCity = card.getAttribute('data-origin') || 'Delhi';
            const destCity = card.getAttribute('data-destination') || 'Outstation';
            const waNumber = card.getAttribute('data-whatsapp-number') || '917290885949';

            const select = card.querySelector('.calc-days-select');
            const selectedDays = select ? parseInt(select.value, 10) : 1;

            let calc;
            try {
                calc = calculateUrbaniaFare({ oneWayKm: onewayKm, days: selectedDays, ratePerKm: ratePerKm });
            } catch (e) {
                calc = null;
            }

            // Update DOM Elements
            const elRoundtrip = card.querySelector('.item-roundtrip');
            const elChargeable = card.querySelector('.item-chargeable');
            const elChargeableLabel = card.querySelector('.item-chargeable-label');
            const elTotalPrice = card.querySelector('.item-totalprice');
            const btnBook = card.querySelector('.calc-book-btn');

            if (calc) {
                const dayWord = calc.days === 1 ? 'Day' : 'Days';
                if (elRoundtrip) elRoundtrip.textContent = formatKm(calc.roundTripKm);
                if (elChargeable) elChargeable.textContent = formatKm(calc.billableKm);
                if (elChargeableLabel) {
                    elChargeableLabel.textContent = 'Chargeable Distance:';
                }
                if (elTotalPrice) elTotalPrice.textContent = calc.formattedPrice;

                // Sync WhatsApp Message with exact required parameters
                const daysText = `${calc.days} ${dayWord}`;
                const waMessage = `Hello, I want to check availability for ${vehicleName} for ${originCity} to ${destCity} round-trip tour.\n`
                                + `• Trip Type: Round Trip (Mandatory)\n`
                                + `• Origin: ${originCity}\n`
                                + `• Destination: ${destCity}\n`
                                + `• Vehicle: ${vehicleName} (ID: ${vehicleId})\n`
                                + `• Round-Trip Distance: ${formatKm(calc.roundTripKm)}\n`
                                + `• Selected Duration: ${daysText}\n`
                                + `• Chargeable Distance (250 × ${daysText}): ${formatKm(calc.chargeableDistanceKm)}\n`
                                + `• Billable Distance: ${formatKm(calc.billableKm)}\n`
                                + `• Vehicle Rate: ₹${calc.ratePerKm}/km\n`
                                + `• Total Estimated Fare: ${calc.formattedPrice}\n`
                                + `Please confirm chauffeur availability and final booking quote.`;

                if (btnBook) {
                    btnBook.href = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMessage)}`;
                }
            } else {
                if (elTotalPrice) elTotalPrice.textContent = 'Get Quote';
                if (btnBook) {
                    const reqMessage = `Hello, I want to check availability and price quote for ${vehicleName} (ID: ${vehicleId}) from ${originCity} to ${destCity} round-trip. Please share details.`;
                    btnBook.href = `https://wa.me/${waNumber}?text=${encodeURIComponent(reqMessage)}`;
                }
            }
        }

        function initPricingCalculators() {
            const cards = document.querySelectorAll('.pricing-calc-card');
            cards.forEach(card => {
                const select = card.querySelector('.calc-days-select');
                if (select) {
                    select.addEventListener('change', () => {
                        updateCardPricing(card);
                    });
                }
                // Initial calculation
                updateCardPricing(card);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPricingCalculators);
        } else {
            initPricingCalculators();
        }
    })();
    </script>
</section>
