<?php
// Reusable SEO content blocks for the homepage and Normal / Luxury landing pages.
// Prices are always read from $fleet in site-data.php — never hard-code them here.
require_once __DIR__ . '/site-data.php';

// All Normal / Luxury landing pages, for internal linking (homepage, footer, related links).
function landing_links() {
    return [
        'force-urbania-normal-on-rent-delhi.php'          => 'Normal Force Urbania on Rent Delhi',
        'force-urbania-luxury-maharaja-on-rent-delhi.php' => 'Luxury Maharaja Urbania Delhi',
        '9-seater-urbania-maharaja-delhi.php'             => '9 Seater Urbania Maharaja',
        '12-seater-urbania-luxury-delhi.php'              => '12 Seater Luxury Urbania',
        '16-seater-urbania-normal-delhi.php'              => '16 Seater Urbania Normal',
        'urbania-on-rent-gurgaon.php'                     => 'Urbania on Rent Gurgaon',
        'urbania-on-rent-noida.php'                       => 'Urbania on Rent Noida',
        'urbania-for-wedding-delhi.php'                   => 'Urbania for Wedding Delhi',
        'urbania-for-corporate-delhi-ncr.php'             => 'Urbania for Corporate Delhi NCR',
    ];
}

function fleet_by_slug($slug) {
    global $fleet;
    foreach ($fleet as $v) if ($v['slug'] === $slug) return $v;
    return null;
}

function render_fleet_card(array $v) {
    global $fleet_types;
    ?>
    <article class="hp-car reveal" data-category="<?php echo $v['slug']; ?>">
        <div class="hp-car-media">
            <img src="<?php echo $v['img']; ?>" alt="<?php echo htmlspecialchars($v['alt']); ?>" loading="lazy">
            <span class="hp-car-tag"><?php echo $v['tag']; ?></span>
        </div>
        <div class="hp-car-body">
            <div class="hp-car-title">
                <h3><?php echo htmlspecialchars($v['name']); ?></h3>
                <span class="hp-seats"><i class="fas fa-user-group"></i> <?php echo $v['seats']; ?> + 1</span>
            </div>
            <ul class="hp-car-feats">
                <?php foreach ($v['features'] as $f): ?>
                    <li><i class="fas fa-check"></i> <?php echo $f; ?></li>
                <?php endforeach; ?>
                    <li><i class="fas fa-road"></i> <strong>Minimum 250 km/day</strong> on outstation trips</li>
            </ul>
            <a href="<?php echo $v['url']; ?>" class="hp-car-type"><?php echo $fleet_types[$v['type']]['label']; ?> · View details <i class="fas fa-arrow-right"></i></a>
            <div class="hp-car-foot">
                <div class="hp-price"><small>Starting at</small><strong>₹<?php echo $v['price']; ?></strong><span>/km</span></div>
                <a href="<?php echo wa_link('Hi, I want to check availability of the ' . $v['name'] . '.'); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-dark hp-btn-sm">Check availability</a>
            </div>
        </div>
    </article>
    <?php
}

// Rate card table: one row per vehicle, grouped Normal vs Luxury Maharaja.
function render_rate_table(array $vehicles) {
    global $fleet_types;
    ?>
    <div class="pg-table-wrap reveal">
        <table class="pg-table pg-table-stack">
            <thead>
                <tr><th>Urbania model</th><th>Category</th><th>Seating</th><th>Price per km</th><th>Best for</th></tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $v): ?>
                <tr>
                    <td data-label="Urbania model"><strong><a href="<?php echo $v['url']; ?>"><?php echo htmlspecialchars($v['name']); ?></a></strong></td>
                    <td data-label="Category"><a href="<?php echo $fleet_types[$v['type']]['url']; ?>"><?php echo $fleet_types[$v['type']]['label']; ?></a></td>
                    <td data-label="Seating"><?php echo $v['seats']; ?> passengers + driver</td>
                    <td data-label="Price per km" class="pg-price">₹<?php echo $v['price']; ?>/km</td>
                    <td data-label="Best for"><?php echo $v['best']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="hp-note"><i class="fas fa-circle-info"></i> Fuel, toll tax, state tax and driver allowance included. Parking, GST and night charges (10 PM – 6 AM) extra. Outstation minimum 250 km/day.</p>
    <?php
}

// Worked outstation fare examples showing how the per-km rate, the 250 km/day minimum and the extras add up.
function render_fare_example() {
    $v = fleet_by_slug('16-seater');
    $trips = [
        ['route' => 'Delhi → Jaipur → Delhi', 'days' => 2, 'km' => 560],
        ['route' => 'Delhi → Agra → Delhi',   'days' => 2, 'km' => 460],
    ];
    ?>
    <div class="hp-seo-copy reveal" style="margin-top:48px">
        <h3>How your Urbania fare is calculated</h3>
        <p>Outstation trips are billed on the higher of the kilometres actually driven or the minimum of 250 km per day. Two worked examples for the <a href="<?php echo $v['url']; ?>"><?php echo htmlspecialchars($v['name']); ?></a> at ₹<?php echo $v['price']; ?>/km:</p>
    </div>
    <div class="pg-table-wrap reveal">
        <table class="pg-table pg-table-stack">
            <thead>
                <tr><th>Trip</th><th>Km driven</th><th>Minimum (250 km × days)</th><th>Km billed</th><th>Estimated fare</th></tr>
            </thead>
            <tbody>
                <?php foreach ($trips as $t):
                    $min = 250 * $t['days'];
                    $billed = max($t['km'], $min); ?>
                <tr>
                    <td data-label="Trip"><strong><?php echo $t['route']; ?></strong> (<?php echo $t['days']; ?> days)</td>
                    <td data-label="Km driven"><?php echo $t['km']; ?> km</td>
                    <td data-label="Minimum (250 km × days)"><?php echo $min; ?> km</td>
                    <td data-label="Km billed"><?php echo $billed; ?> km</td>
                    <td data-label="Estimated fare" class="pg-price">₹<?php echo number_format($billed * $v['price']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="hp-note"><i class="fas fa-circle-info"></i> Estimated fare includes fuel, toll tax, state tax and driver allowance. Add parking at actuals, GST as applicable and night charges if the van runs between 10 PM and 6 AM. Your exact quote is shared before you book.</p>
    <?php
}

// "Normal vs Luxury Maharaja — which to choose?" comparison.
function render_type_compare($heading_tag = 'h2') {
    global $fleet_types;
    $luxury = fleet_by_type('luxury');
    $normal = fleet_by_type('normal');
    ?>
    <div class="hp-head reveal">
        <span class="hp-kicker">Compare</span>
        <<?php echo $heading_tag; ?>>Force Urbania Normal vs Luxury Maharaja — which to choose?</<?php echo $heading_tag; ?>>
    </div>
    <div class="hp-seo-copy reveal">
        <p>We run two kinds of Force Urbania in Delhi NCR. The <strong>Normal Urbania</strong> is our <?php echo implode(' / ', array_column($normal, 'seats')); ?> seater with 2x1 pushback seats — the value pick for big groups on long road trips. The <strong>Luxury Maharaja Urbania</strong> comes in <?php echo implode(' and ', array_column($luxury, 'seats')); ?> seater layouts with extra-wide Maharaja or captain seats and a designer cabin — the premium pick for weddings, corporate guests and VIP family travel. Both come with a verified chauffeur, full AC and all-India tourist permits.</p>
    </div>
    <div class="pg-vs reveal">
        <div>
            <h3><i class="fas fa-crown" style="color:var(--hp-gold-2)"></i> <a href="<?php echo $fleet_types['luxury']['url']; ?>">Luxury Maharaja Urbania</a> — from ₹<?php echo fleet_min_price($luxury); ?>/km</h3>
            <ul>
                <li><?php echo implode(' &amp; ', array_column($luxury, 'seats')); ?> seater Maharaja layouts</li>
                <li>Extra-wide Maharaja seats, reclining captain seats with armrests</li>
                <li>Privacy partition, Smart TV, premium WiFi and entertainment</li>
                <li>Mini bar, mood lighting and designer interiors</li>
                <li>Best for weddings, corporate executives, VIP guests and premium family tours</li>
            </ul>
        </div>
        <div>
            <h3><i class="fas fa-van-shuttle" style="color:var(--hp-gold-dark)"></i> <a href="<?php echo $fleet_types['normal']['url']; ?>">Normal Urbania</a> — from ₹<?php echo fleet_min_price($normal); ?>/km</h3>
            <ul>
                <li><?php echo implode(' / ', array_column($normal, 'seats')); ?> seater with 2x1 pushback seats</li>
                <li>Walk-through aisle — easy for senior citizens</li>
                <li>Entertainment system and charging points at every seat</li>
                <li>Lowest per-person cost for large groups</li>
                <li>Best for group tours, Char Dham, Manali / Shimla trips and corporate delegations</li>
            </ul>
        </div>
    </div>
    <?php
}

// Delhi NCR pickup areas block.
function render_ncr_areas($heading_tag = 'h2') {
    global $ncr_areas;
    ?>
    <div class="hp-head reveal">
        <span class="hp-kicker">Pickup Areas</span>
        <<?php echo $heading_tag; ?>>Urbania on rent across Delhi NCR — doorstep pickup</<?php echo $heading_tag; ?>>
    </div>
    <div class="hp-seo-copy reveal">
        <?php foreach ($ncr_areas as $city => $c): ?>
        <p><strong><?php echo $c['url'] ? '<a href="' . $c['url'] . '">Force Urbania on rent in ' . $city . '</a>' : 'Force Urbania on rent in ' . $city; ?>:</strong> <?php echo $c['areas']; ?>.</p>
        <?php endforeach; ?>
        <p>Free doorstep pickup anywhere in Delhi, Gurgaon, Noida, Greater Noida, Ghaziabad and Faridabad — for local use, airport transfers and outstation trips.</p>
    </div>
    <?php
}
