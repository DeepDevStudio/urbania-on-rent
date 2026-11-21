<?php
require_once __DIR__ . '/includes/seo-blocks.php';

$page_title = 'Urbania Fleet & Price per KM | Normal & Luxury Maharaja 9, 12, 16 Seater Delhi';
$page_description = 'Compare our luxury Force Urbania fleet in Delhi: 9, 12 & 16 seater Urbania on rent from ₹40/km with driver, pushback seats, WiFi & AC. See prices, features and what is included.';
$page_keywords = 'urbania fleet delhi, 9 seater urbania on rent delhi, 12 seater urbania on rent delhi, 16 seater urbania on rent delhi, urbania rent per km delhi, urbania price in delhi, force urbania hire with driver, urbania vs tempo traveller';
$extra_css = ['css/home.css', 'css/pages.css'];
$hide_breadcrumb = true;
include 'header.php';

$fleet_faqs = [
    ['q' => 'What is the Urbania on rent price per km in Delhi?',
     'a' => 'Our Force Urbania rental starts at ₹' . fleet_by_slug('16-seater')['price'] . '/km for the 16 Seater Normal Urbania and ₹' . fleet_by_slug('9-seater')['price'] . '/km for the 9 Seater Urbania (Maharaja) and ₹' . fleet_by_slug('12-seater')['price'] . '/km for the 12 Seater Urbania (Maharaja). Fuel, toll tax, state tax and driver allowance are included.'],
    ['q' => 'How many passengers can travel in a Force Urbania?',
     'a' => 'We offer 9, 12 and 16 seater Urbania configurations (plus the driver). For groups larger than 16, we can arrange two or more Urbanias travelling together.'],
    ['q' => 'What is the difference between Urbania and Tempo Traveller?',
     'a' => 'The Force Urbania is a newer, more premium van with a monocoque body, independent front suspension, better soundproofing and a car-like cabin. It gives a smoother, quieter ride than a regular Tempo Traveller, especially on long highway and hill journeys.'],
    ['q' => 'Is the Urbania suitable for hill stations like Manali and Shimla?',
     'a' => 'Yes. Our chauffeurs are experienced on hill roads, and the Urbania\'s suspension and power make it comfortable on routes to Manali, Shimla, Mussoorie, Nainital and the Char Dham circuit.'],
    ['q' => 'Can I book an Urbania for a wedding in Delhi?',
     'a' => 'Absolutely. We provide Urbanias for baraat, guest shuttles and hotel-to-venue transfers in Delhi, Gurgaon and Noida, and can arrange decoration on request.'],
];
?>
<main class="hp">

    <section class="pg-hero" style="background-image:url('images/urbania-1.webp')">
        <div class="container">
            <div class="pg-hero-copy">
                <?php render_crumbs([['Our Fleet', null]]); ?>
                <span class="hp-eyebrow"><i class="fas fa-van-shuttle"></i> Force Urbania Fleet</span>
                <h1>Force Urbania fleet in Delhi — <em>Normal &amp; Luxury Maharaja</em></h1>
                <p class="pg-lead">9, 12 and 16 seater Force Urbania vans with Maharaja &amp; 2x1 pushback seats, WiFi and experienced chauffeurs — from ₹40 per km, fuel and tolls included.</p>
                <ul class="pg-hero-meta">
                    <li><i class="fas fa-user-group"></i> 9 to 16 seats</li>
                    <li><i class="fas fa-indian-rupee-sign"></i> From ₹40/km</li>
                    <li><i class="fas fa-gas-pump"></i> Fuel &amp; tolls included</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Fleet grid -->
    <section class="hp-section" id="fleet">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">The Fleet</span>
                <h2>Urbania on rent for every group size</h2>
            </div>
            <div class="pg-tabs" role="tablist">
                <button class="is-active" data-filter="all">All Urbania</button>
                <button data-filter="9-seater">9 Seater</button>
                <button data-filter="12-seater">12 Seater</button>
                <button data-filter="16-seater">16 Seater</button>
            </div>
            <div class="hp-fleet" id="fleetGrid">
                <?php foreach ($fleet as $v) render_fleet_card($v); ?>
            </div>
        </div>
    </section>

    <!-- Price comparison -->
    <section class="hp-section hp-soft">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">Rate Card</span>
                <h2>Urbania on rent price list, Delhi</h2>
            </div>
            <?php render_rate_table($fleet); ?>

            <div class="pg-incl" style="margin-top:28px">
                <div class="reveal yes">
                    <h3><i class="fas fa-circle-check" style="color:#16a34a"></i> Included in the fare</h3>
                    <ul>
                        <li><i class="fas fa-check"></i> Fuel for the entire trip</li>
                        <li><i class="fas fa-check"></i> Toll tax and state tax</li>
                        <li><i class="fas fa-check"></i> Driver allowance</li>
                        <li><i class="fas fa-check"></i> 250 km per day (outstation)</li>
                        <li><i class="fas fa-check"></i> Experienced, uniformed chauffeur</li>
                    </ul>
                </div>
                <div class="reveal no">
                    <h3><i class="fas fa-circle-info" style="color:var(--hp-gold-dark)"></i> Charged extra</h3>
                    <ul>
                        <li><i class="fas fa-minus"></i> Parking charges</li>
                        <li><i class="fas fa-minus"></i> GST as applicable</li>
                        <li><i class="fas fa-minus"></i> Night charge for driving between 10 PM and 6 AM</li>
                        <li><i class="fas fa-minus"></i> Extra km beyond the daily limit, at the per-km rate</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Normal vs Luxury Maharaja -->
    <section class="hp-section">
        <div class="container">
            <?php render_type_compare(); ?>
        </div>
    </section>

    <!-- Urbania vs Tempo Traveller -->
    <section class="hp-section">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">Compare</span>
                <h2>Force Urbania vs Tempo Traveller</h2>
                <p class="pg-lede" style="margin-top:16px">Why more groups in Delhi now choose a luxury Urbania over a regular tempo traveller.</p>
            </div>
            <div class="pg-vs reveal">
                <div>
                    <h3><i class="fas fa-crown" style="color:var(--hp-gold-2)"></i> Force Urbania</h3>
                    <ul>
                        <li>Modern monocoque body with a car-like, quieter cabin</li>
                        <li>Independent front suspension for a smoother highway and hill ride</li>
                        <li>Large panoramic windows and premium interiors</li>
                        <li>Pushback or captain seats with more legroom</li>
                        <li>Better suited for weddings, corporate and premium family tours</li>
                    </ul>
                </div>
                <div>
                    <h3>Regular Tempo Traveller</h3>
                    <ul>
                        <li>Older ladder-frame design with more cabin noise</li>
                        <li>Firmer ride on long journeys</li>
                        <li>Smaller windows and basic interiors</li>
                        <li>Tighter seating in most configurations</li>
                        <li>Lower rate, but less comfort per rupee on long trips</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="hp-section hp-soft" id="faq">
        <div class="container hp-faq-wrap">
            <div class="hp-faq-intro reveal">
                <span class="hp-kicker">FAQ</span>
                <h2>Urbania rental questions</h2>
                <p>Need a custom seating layout or several vans for a big event? Talk to us.</p>
                <a href="tel:<?php echo $site_phone_tel; ?>" class="hp-btn hp-btn-dark"><i class="fas fa-phone"></i> <?php echo $site_phone_display; ?></a>
            </div>
            <div class="hp-faq">
                <?php foreach ($fleet_faqs as $i => $f): ?>
                <details class="reveal" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary><?php echo $f['q']; ?><i class="fas fa-plus"></i></summary>
                    <p><?php echo $f['a']; ?></p>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php echo faq_schema($fleet_faqs); ?>
    <?php echo fleet_offer_schema($fleet, 'Force Urbania Fleet on Rent in Delhi NCR'); ?>

    <!-- CTA -->
    <section class="hp-section">
        <div class="container">
            <div class="pg-cta reveal">
                <div>
                    <h2>Not sure which Urbania <em>fits your group?</em></h2>
                    <p>Share your group size and route — we'll recommend the right van and send an all-inclusive quote.</p>
                </div>
                <div class="hp-hero-ctas">
                    <a href="<?php echo wa_link('Hi, I need help choosing the right Urbania for my trip.'); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-gold"><i class="fab fa-whatsapp"></i> Ask on WhatsApp</a>
                    <a href="tel:<?php echo $site_phone_tel; ?>" class="hp-btn hp-btn-glass"><i class="fas fa-phone"></i> Call Now</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    (function () {
        var tabs = document.querySelectorAll('.pg-tabs button');
        var cars = document.querySelectorAll('#fleetGrid .hp-car');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('is-active'); });
                tab.classList.add('is-active');
                var f = tab.getAttribute('data-filter');
                cars.forEach(function (car) {
                    var show = f === 'all' || car.getAttribute('data-category') === f;
                    car.classList.toggle('is-hidden', !show);
                    if (show) car.classList.add('is-in');
                });
            });
        });
    })();
</script>
<?php include 'footer.php'; ?>
