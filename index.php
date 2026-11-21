<?php
require_once __DIR__ . '/includes/site-data.php';
require_once __DIR__ . '/includes/destinations-data.php';
require_once __DIR__ . '/includes/seo-blocks.php';
require_once __DIR__ . '/includes/home-seo-content.php';

// Route search redirection handler (supports progressive enhancement / direct submit)
$search_error = '';
if ((isset($_GET['search_route']) || isset($_GET['dest_slug'])) && !empty($_GET['dest_slug'])) {
    $pickup = strtolower(trim((string)($_GET['pickup_city'] ?? 'delhi')));
    $valid_origins = ['delhi', 'noida', 'ghaziabad', 'faridabad', 'gurgaon'];
    if (!in_array($pickup, $valid_origins, true)) {
        $pickup = 'delhi';
    }
    $raw_slug = strtolower(trim((string)$_GET['dest_slug']));
    $clean_slug = preg_replace('/[^a-z0-9\-]/', '', $raw_slug);

    if (!empty($clean_slug)) {
        $target_route_slug = $pickup . '-to-' . $clean_slug . '-urbania-on-rent';
        $route_info = get_destination_by_slug($target_route_slug);

        if ($route_info) {
            // Every origin has a physical <slug>.php stub that loads route.php (no .htaccess needed)
            $target_url = $route_info['slug'] . '.php';
            header('Location: ' . $target_url);
            exit;
        } else {
            $search_error = 'Route from ' . ucfirst($pickup) . ' to ' . htmlspecialchars($raw_slug) . ' not found. Please select a valid destination from the suggestions.';
        }
    }
}

// Fetch all 611 destinations from existing destination data source
$all_raw_destinations = get_all_destinations('delhi');
$hp_destinations = [];
foreach ($all_raw_destinations as $d) {
    $hp_destinations[] = [
        'name'     => $d['destination'],
        'slug'     => $d['base_slug'],
        'state'    => $d['state'] ?? '',
        'category' => $d['category'] ?? ''
    ];
}
// Alphabetical sorting by destination name
usort($hp_destinations, function($a, $b) {
    return strcasecmp($a['name'], $b['name']);
});

$luxury_fleet = fleet_by_type('luxury');
$normal_fleet = fleet_by_type('normal');

$og_image_url = 'https://urbaniaonrentdelhi.co.in/images/urbania-rent.webp';
$custom_primary_meta = <<<HTML
    <title>Force Urbania on Rent in Delhi NCR | 9 to 20 Seater Luxury Van Hire</title>
    <meta name="title" content="Force Urbania on Rent in Delhi | 9 to 20 Seater Luxury Van Hire">
    <meta name="description" content="Book luxury Force Urbania on rent in Delhi NCR directly from fleet service provider. 9, 10, 11, 12, 16, 17, 20 &amp; Maharaja seater with verified drivers for outstation &amp; local trips.">
    <meta name="keywords" content="Urbania on rent in Delhi, Force Urbania on rent in Delhi, Force Urbania luxury van rental Delhi, Urbania hire in Delhi NCR, Urbania booking in Delhi, Luxury Force Urbania rental Delhi, Best Urbania rental service in Delhi, 9 seater Force Urbania on rent in Delhi, 12 seater luxury Urbania on rent in Delhi, 16 seater Urbania on rent in Delhi, 20 seater Urbania rental in Delhi, Maharaja seater Urbania on rent in Delhi, Outstation Urbania on rent from Delhi, Force Urbania per km rate in Delhi">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Urbania on Rent Delhi">
    <link rel="canonical" href="https://urbaniaonrentdelhi.co.in/">
HTML;
$custom_social_meta = <<<HTML
    <!-- Open Graph / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_IN">
    <meta property="og:url" content="https://urbaniaonrentdelhi.co.in/">
    <meta property="og:site_name" content="Urbania on Rent Delhi">
    <meta property="og:title" content="Force Urbania on Rent in Delhi | Luxury Van Hire Service">
    <meta property="og:description" content="Direct service provider for Force Urbania on rent in Delhi NCR. Book 9, 12, 16, 20 &amp; Maharaja seater luxury vans for local and outstation tours.">
    <meta property="og:image" content="{$og_image_url}">
    <meta property="og:image:secure_url" content="{$og_image_url}">
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="683">
    <meta property="og:image:alt" content="Luxury Force Urbania on Rent in Delhi">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://urbaniaonrentdelhi.co.in/">
    <meta name="twitter:title" content="Force Urbania on Rent in Delhi | 9 to 20 Seater Van Hire">
    <meta name="twitter:description" content="Luxury Force Urbania van rental service provider in Delhi NCR. Reclining captain seats, verified drivers, transparent per km rates.">
    <meta name="twitter:image" content="{$og_image_url}">
    <meta name="twitter:image:alt" content="Luxury Force Urbania on Rent in Delhi">
HTML;
$extra_css = ['css/home.css', 'css/pages.css'];
include 'header.php';


$routes = [
    ['to' => 'Jaipur',      'km' => 280, 'time' => '4.5 hrs', 'img' => 'jaipur.jpg',                 'url' => 'delhi-to-jaipur-urbania.php#pricing',      'alt' => 'Hawa Mahal palace in Jaipur, Rajasthan – Delhi to Jaipur Urbania on rent for family & group tours'],
    ['to' => 'Agra',        'km' => 230, 'time' => '3.5 hrs', 'img' => 'agra.jpg',                   'url' => 'delhi-to-agra-urbania.php#pricing',        'alt' => 'Taj Mahal marble monument in Agra, Uttar Pradesh – Delhi to Agra Urbania on rent for family & group tours'],
    ['to' => 'Manali',      'km' => 540, 'time' => '11 hrs',  'img' => 'manali.jpg',                 'url' => 'delhi-to-manali-urbania.php#pricing',      'alt' => 'Snow-covered mountains in Manali, Himachal Pradesh – Delhi to Manali Urbania on rent for family & group tours'],
    ['to' => 'Mussoorie',   'km' => 290, 'time' => '6.5 hrs', 'img' => 'mussoorie.jpg',              'url' => 'delhi-to-mussoorie-urbania.php#pricing',   'alt' => 'Scenic mountain valley view in Mussoorie, Uttarakhand – Delhi to Mussoorie Urbania on rent for family & group tours'],
    ['to' => 'Dharamshala', 'km' => 480, 'time' => '10 hrs',  'img' => 'dharamshala_landscape.jpg', 'url' => 'delhi-to-dharamshala-urbania.php#pricing', 'alt' => 'Dhauladhar mountain range in Dharamshala, Himachal Pradesh – Delhi to Dharamshala Urbania on rent for family & group tours'],
    ['to' => 'Amritsar',    'km' => 450, 'time' => '7.5 hrs', 'img' => 'amritsar.jpg',               'url' => 'delhi-to-amritsar-urbania.php#pricing',    'alt' => 'Golden Temple sanctum and holy sarovar in Amritsar, Punjab – Delhi to Amritsar Urbania on rent for family & group tours'],
    ['to' => 'Udaipur',     'km' => 660, 'time' => '10 hrs',  'img' => 'udaipur.jpg',                'url' => 'delhi-to-udaipur-urbania.php#pricing',     'alt' => 'City Palace and Lake Pichola in Udaipur, Rajasthan – Delhi to Udaipur Urbania on rent for family & group tours'],
    ['to' => 'Dehradun',    'km' => 250, 'time' => '5.5 hrs', 'img' => 'dehradun.jpg',               'url' => 'delhi-to-dehradun-urbania.php#pricing',    'alt' => 'Forest Research Institute architecture in Dehradun, Uttarakhand – Delhi to Dehradun Urbania on rent for family & group tours'],
];

$faqs = [
    ['q' => 'What is the per-km rate for Urbania on rent in Delhi?',
     'a' => 'Our rates start at ₹' . fleet_by_slug('16-seater')['price'] . '/km for the 16 Seater Normal Urbania and ₹' . fleet_by_slug('9-seater')['price'] . '/km for the 9 Seater Urbania (Maharaja) and ₹' . fleet_by_slug('12-seater')['price'] . '/km for the 12 Seater Urbania (Maharaja). Fuel, toll tax, state tax and driver allowance are included; parking, GST and night charges (10 PM – 6 AM) are extra. We share the full estimate before you book.'],
    ['q' => 'What is the difference between Normal and Luxury Maharaja Urbania?',
     'a' => 'The Normal Urbania is our 16 seater with 2x1 pushback seats — the best value for big group tours, pilgrimages and hill trips. The Luxury Maharaja Urbania (9 and 12 seater) has extra-wide Maharaja or reclining captain seats, Smart TV, premium WiFi, mood lighting and designer interiors — ideal for weddings, corporate guests and VIP family travel.'],
    ['q' => 'Is there a minimum km limit per day for outstation trips?',
     'a' => 'Yes. Outstation bookings carry a minimum of 250 km per day, which is standard for tempo travellers and Urbania vans across Delhi NCR.'],
    ['q' => 'Do you provide the Urbania with a driver?',
     'a' => 'Every booking comes with an experienced, verified and uniformed chauffeur who knows Delhi NCR and all major outstation routes. Self-drive is not offered.'],
    ['q' => 'How far in advance should I book?',
     'a' => 'We recommend booking 3–7 days ahead, and 2–3 weeks ahead for weddings, long weekends and the Char Dham season. Same-day bookings are possible subject to availability.'],
    ['q' => 'Can I book an Urbania for airport transfers or local city use?',
     'a' => 'Absolutely. We offer IGI Airport pickups and drops, 8 hr / 80 km local packages, wedding transfers and corporate shuttles in Delhi, Gurgaon, Noida and Faridabad.'],
    ['q' => 'How do I confirm my booking?',
     'a' => 'Send us an inquiry through the form or WhatsApp. We share a written quote, and a small advance confirms the vehicle. The balance is paid at the end of the trip.'],
    ['q' => 'Is Urbania on rent available in Gurgaon, Noida, Ghaziabad and Faridabad?',
     'a' => 'Yes. We provide Urbania on rent in Gurgaon, Noida, Ghaziabad and Faridabad with free doorstep pickup anywhere in Delhi NCR, for local use as well as outstation trips.'],
    ['q' => 'Can I book an Urbania from Delhi to Kedarnath, Badrinath or Chardham?',
     'a' => 'Yes. Our Delhi to Kedarnath, Delhi to Badrinath and Delhi to Chardham Urbania packages use hill-trained drivers and elder-friendly pushback seats. We also run Delhi to Haridwar, Rishikesh, Manali, Shimla, Chandigarh, Jaipur and Udaipur Urbania trips.'],
];
$faqs = array_merge($faqs, home_seo_faqs());
?>
<main class="hp hp-home">

    <!-- ============ HERO ============ -->
    <section class="hp-hero">
        <div class="hp-hero-bg">
            <img src="images/urbania-rent.webp" alt="Force Urbania Normal and Luxury Maharaja on rent in Delhi NCR – 9, 12 & 16 seater Urbania with driver for group travel" fetchpriority="high">
        </div>
        <div class="container hp-hero-inner">
            <div class="hp-hero-copy">
                <span class="hp-eyebrow"><i class="fas fa-crown"></i> Urbania on Rent Delhi NCR</span>
                <h1>Force Urbania on Rent in Delhi<br><em>Normal &amp; Luxury Maharaja.</em></h1>
                <p class="hp-hero-lead">Book <strong>16 seater Normal</strong> &amp; <strong>9 / 12 seater Luxury Maharaja Urbania on rent in Delhi NCR</strong> with driver — for family trips, group tours, weddings, corporate tours and outstation travel from Delhi, Gurgaon, Noida, Ghaziabad &amp; Faridabad at transparent per-km rates.</p>
                <div class="hp-hero-ctas">
                    <a href="#booking" class="hp-btn hp-btn-gold"><i class="fas fa-calendar-check"></i> Get Instant Quote</a>
                    <a href="https://wa.me/917290885949?text=Hi,%20I%20want%20to%20book%20a%20luxury%20Urbania%20in%20Delhi" target="_blank" rel="noopener" class="hp-btn hp-btn-glass"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
                </div>
                <ul class="hp-hero-trust">
                    <li><span class="hp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span> <strong>4.9/5</strong> from 1,480+ Google reviews</li>
                    <li><i class="fas fa-shield-halved"></i> Verified chauffeurs</li>
                    <li><i class="fas fa-headset"></i> 24/7 support</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ============ FIND YOUR DESTINATION SEARCH BAR ============ -->
    <section class="hp-booking-wrap" id="booking">
        <div class="container">
            <div class="hp-booking">
                <div class="hp-booking-head">
                    <h2>Find Your Destination</h2>
                    <p>Choose your pickup city and explore Urbania routes across India.</p>
                </div>

                <?php if (!empty($search_error)): ?>
                    <div class="hp-search-feedback" role="alert" style="display: flex; margin-bottom: 16px;">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?php echo htmlspecialchars($search_error); ?></span>
                    </div>
                <?php endif; ?>

                <form id="hpRouteSearchForm" class="hp-route-search-form" method="GET" action="index.php" autocomplete="off">
                    <input type="hidden" name="search_route" value="1">
                    <div class="hp-route-search-grid">
                        <!-- Control 1: Pickup City Dropdown -->
                        <div class="hp-field hp-field-pickup">
                            <span>Pickup City</span>
                            <div class="hp-input-control">
                                <i class="fas fa-location-dot hp-lead-icon" aria-hidden="true"></i>
                                <select name="pickup_city" id="hpPickupCity" class="hp-search-select" aria-label="Pickup City">
                                    <option value="delhi" selected>Delhi</option>
                                    <option value="noida">Noida</option>
                                    <option value="ghaziabad">Ghaziabad</option>
                                    <option value="faridabad">Faridabad</option>
                                    <option value="gurgaon">Gurgaon</option>
                                </select>
                            </div>
                        </div>

                        <!-- Control 2: Searchable Destination Dropdown -->
                        <div class="hp-field hp-field-dest" id="hpDestField">
                            <span>Destination</span>
                            <div class="hp-input-control">
                                <i class="fas fa-flag-checkered hp-lead-icon" aria-hidden="true"></i>
                                <input 
                                    type="text" 
                                    id="hpDestInput" 
                                    name="dest_query" 
                                    class="hp-search-input" 
                                    placeholder="Search destination (e.g. Manali, Jaipur, Agra...)" 
                                    autocomplete="off" 
                                    spellcheck="false" 
                                    role="combobox" 
                                    aria-autocomplete="list" 
                                    aria-expanded="false" 
                                    aria-controls="hpDestDropdown" 
                                    aria-label="Destination"
                                >
                                <button type="button" id="hpDestClearBtn" class="hp-clear-btn" aria-label="Clear destination" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <input type="hidden" name="dest_slug" id="hpDestSlug" value="">

                            <!-- Custom Searchable Dropdown Popup -->
                            <div id="hpDestDropdown" class="hp-dest-dropdown" role="listbox" style="display: none;"></div>
                        </div>

                        <!-- Control 3: Search Routes Button -->
                        <div class="hp-field hp-field-action">
                            <span>&nbsp;</span>
                            <button type="submit" id="hpSearchRoutesBtn" class="hp-btn hp-btn-gold hp-search-submit" disabled>
                                <i class="fas fa-magnifying-glass"></i> Search Routes
                            </button>
                        </div>
                    </div>

                    <!-- Client-side Feedback Alert -->
                    <div id="hpSearchFeedback" class="hp-search-feedback" role="alert" style="display: none;">
                        <i class="fas fa-circle-exclamation"></i>
                        <span id="hpFeedbackMsg">Please select a valid destination from the suggestions.</span>
                    </div>
                </form>

                <div class="hp-stats">
                    <div><strong>5+</strong><span>Years on the road</span></div>
                    <div><strong>1,500+</strong><span>Group trips completed</span></div>
                    <div><strong>600+</strong><span>Destinations covered</span></div>
                    <div><strong>₹<?php echo fleet_min_price($fleet); ?></strong><span>Per km, starting price</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FLEET ============ -->
    <section class="hp-section" id="fleet">
        <div class="container">
            <div class="hp-head hp-head-split reveal">
                <div>
                    <span class="hp-kicker">Our Fleet</span>
                    <h2>9, 12 &amp; 16 Seater Urbania Rental Options</h2>
                </div>
                <p>Every Force Urbania is deep-cleaned before every trip, regularly serviced, and fully insured with all-India tourist permits.</p>
            </div>

            <div class="hp-fleet">
                <?php foreach ($fleet as $v) render_fleet_card($v); ?>
            </div>
            <p class="hp-note"><i class="fas fa-circle-info"></i> Fuel, toll tax, state tax and driver allowance included. Parking, GST and night charges extra. Outstation minimum 250 km/day. <a href="fleet.php">Compare full fleet details <i class="fas fa-arrow-right"></i></a></p>
        </div>
    </section>

    <!-- ============ RATE CARD ============ -->
    <section class="hp-section hp-soft" id="pricing">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">Rate Card</span>
                <h2>Urbania Rental Price in Delhi</h2>
            </div>
            <?php render_rate_table($fleet); ?>
            <?php render_fare_example(); ?>
        </div>
    </section>

    <!-- ============ NORMAL VS LUXURY ============ -->
    <section class="hp-section">
        <div class="container">
            <?php render_type_compare(); ?>
        </div>
    </section>

    <!-- ============ SERVICES ============ -->
    <section class="hp-section hp-dark">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">What We Do</span>
                <h2>An Urbania for every occasion</h2>
            </div>
            <div class="hp-services">
                <a href="services.php" class="hp-service reveal"><i class="fas fa-mountain-sun"></i><h3>Urbania for Outstation Trip</h3><p>Delhi to Manali, Shimla, Jaipur, Udaipur and Chandigarh — hills, heritage and pilgrimages with drivers who know every ghat road.</p><span>Learn more <i class="fas fa-arrow-right"></i></span></a>
                <a href="urbania-for-wedding-delhi.php" class="hp-service reveal"><i class="fas fa-ring"></i><h3>Urbania for Wedding</h3><p>Decorated luxury Urbania for baraat, guest shuttles and venue transfers in Delhi NCR — on time, every time.</p><span>Learn more <i class="fas fa-arrow-right"></i></span></a>
                <a href="urbania-for-corporate-delhi-ncr.php" class="hp-service reveal"><i class="fas fa-briefcase"></i><h3>Urbania for Corporate Tour</h3><p>Offsites, client visits and employee shuttles in Gurgaon, Noida and Delhi with GST invoicing and monthly billing.</p><span>Learn more <i class="fas fa-arrow-right"></i></span></a>
                <a href="services.php" class="hp-service reveal"><i class="fas fa-plane-arrival"></i><h3>Urbania for Airport Transfer</h3><p>IGI Airport pickups and drops with flight tracking, name-board greeting and luggage assistance.</p><span>Learn more <i class="fas fa-arrow-right"></i></span></a>
                <a href="char-dham-urbania-package.php" class="hp-service reveal"><i class="fas fa-om"></i><h3>Delhi to Chardham Urbania</h3><p>Elder-friendly Urbania for religious tour groups to Kedarnath, Badrinath, Gangotri and Yamunotri.</p><span>View package <i class="fas fa-arrow-right"></i></span></a>
                <a href="services.php" class="hp-service reveal"><i class="fas fa-city"></i><h3>Urbania Hire in Delhi NCR</h3><p>8 hr / 80 km local packages — Urbania on rent in Gurgaon, Noida, Ghaziabad and Faridabad.</p><span>Learn more <i class="fas fa-arrow-right"></i></span></a>
            </div>
        </div>
    </section>

    <!-- ============ ROUTES ============ -->
    <section class="hp-section" id="routes">
        <div class="container">
            <div class="hp-head hp-head-split reveal">
                <div>
                    <span class="hp-kicker">Urbania from Delhi</span>
                    <h2>Where will you go next?</h2>
                </div>
                <p>Fixed, fair pricing on the most-booked Delhi outstation Urbania routes across North India.</p>
            </div>
            <div class="hp-routes">
                <?php foreach ($routes as $r): ?>
                <a href="<?php echo $r['url']; ?>" class="hp-route reveal">
                    <img src="images/destinations/<?php echo $r['img']; ?>" alt="<?php echo htmlspecialchars($r['alt']); ?>" loading="lazy">
                    <div class="hp-route-info">
                        <small>Delhi to</small>
                        <h3><?php echo $r['to']; ?></h3>
                        <span><i class="fas fa-road"></i> <?php echo $r['km']; ?> km &nbsp;·&nbsp; <i class="far fa-clock"></i> <?php echo $r['time']; ?></span>
                    </div>
                    <i class="fas fa-arrow-up-right-from-square hp-route-go"></i>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="hp-packages reveal">
                <span>Tour packages:</span>
                <a href="golden-triangle-urbania-package.php">Golden Triangle</a>
                <a href="char-dham-urbania-package.php">Char Dham</a>
                <a href="himachal-urbania-package.php">Himachal</a>
                <a href="uttarakhand-urbania-package.php">Uttarakhand</a>
                <a href="rajasthan-urbania-package.php">Rajasthan</a>
                <a href="kashmir-urbania-package.php">Kashmir</a>
                <a href="leh-ladakh-urbania-package.php">Leh Ladakh</a>
                <a href="pilgrimage-urbania-package.php">Pilgrimage</a>
                <a href="wildlife-urbania-package.php">Wildlife</a>
            </div>
        </div>
    </section>

    <!-- ============ WHY US ============ -->
    <section class="hp-section hp-soft">
        <div class="container hp-why">
            <div class="hp-why-media reveal">
                <img src="images/urbania-4.webp" alt="White Force Urbania luxury van on rent in Delhi NCR – Urbania hire with driver for outstation & local trips" loading="lazy">
                <div class="hp-why-badge">
                    <strong>4.9<i class="fas fa-star"></i></strong>
                    <span>Google rating<br>from 1,480+ reviews</span>
                </div>
            </div>
            <div class="hp-why-copy reveal">
                <span class="hp-kicker">Why Book Urbania on Rent Delhi</span>
                <h2>Why Book Urbania with Us?</h2>
                <p>We are a Delhi-based team that only runs Force Urbania — so every 12 seater and 16 seater Urbania, driver and process is tuned for premium group travel.</p>
                <div class="hp-why-list">
                    <div><i class="fas fa-user-tie"></i><div><h4>Trained, verified chauffeurs</h4><p>Verified, uniformed drivers with years of hill and highway experience.</p></div></div>
                    <div><i class="fas fa-file-invoice-dollar"></i><div><h4>Transparent quotes</h4><p>Written estimate up front. No surprise charges at the end of the trip.</p></div></div>
                    <div><i class="fas fa-spray-can-sparkles"></i><div><h4>Immaculate vehicles</h4><p>Deep-cleaned and sanitised before every departure, with regular servicing.</p></div></div>
                    <div><i class="fas fa-location-crosshairs"></i><div><h4>GPS-tracked &amp; insured</h4><p>Live tracking, comprehensive insurance and all-India tourist permits.</p></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ HOW IT WORKS ============ -->
    <section class="hp-section">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">How It Works</span>
                <h2>Booked in three simple steps</h2>
            </div>
            <ol class="hp-steps">
                <li class="reveal"><span>01</span><h3>Share your plan</h3><p>Tell us your route, dates and group size via the form, call or WhatsApp.</p></li>
                <li class="reveal"><span>02</span><h3>Get a clear quote</h3><p>Receive an itemised quote within minutes — no hidden costs.</p></li>
                <li class="reveal"><span>03</span><h3>Ride in comfort</h3><p>Your chauffeur arrives on time with a spotless Urbania. Sit back and enjoy.</p></li>
            </ol>
        </div>
    </section>

    <!-- ============ TESTIMONIALS ============ -->
    <section class="hp-section hp-soft" id="testimonials">
        <div class="container">
            <div class="hp-head hp-head-split reveal">
                <div>
                    <span class="hp-kicker">Reviews</span>
                    <h2>Loved by travellers</h2>
                </div>
                <a href="testimonials.php" class="hp-link">Read all reviews <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="hp-reviews">
                <figure class="hp-review reveal">
                    <div class="hp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <blockquote>“The Urbania was spotless and very luxurious. Our trip to Jaipur became extra special. Highly recommend!”</blockquote>
                    <figcaption><span class="hp-avatar">JM</span><div><strong>John Mark</strong><small>Delhi → Jaipur · Family trip</small></div></figcaption>
                </figure>
                <figure class="hp-review reveal">
                    <div class="hp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <blockquote>“Excellent service! The 12 seater Urbania was perfect for our office offsite. The driver was very professional.”</blockquote>
                    <figcaption><span class="hp-avatar">S</span><div><strong>Sushi</strong><small>Corporate offsite</small></div></figcaption>
                </figure>
                <figure class="hp-review reveal">
                    <div class="hp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <blockquote>“On-time, clean, and comfortable. The kids loved the ambient lighting. Will book again!”</blockquote>
                    <figcaption><span class="hp-avatar">H</span><div><strong>Henry</strong><small>Family holiday</small></div></figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- ============ BLOGS ============ -->
    <section class="hp-section">
        <div class="container">
            <div class="hp-head hp-head-split reveal">
                <div>
                    <span class="hp-kicker">Travel Guides</span>
                    <h2>Road trip inspiration</h2>
                </div>
                <a href="blogs.php" class="hp-link">View all 12 guides <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="hp-blogs">
                <a href="blog-delhi-to-jaipur.php" class="hp-blog reveal">
                    <div class="hp-blog-media"><img src="images/blog_delhi_jaipur.jpg" alt="Hawa Mahal Palace of Winds in Jaipur, Rajasthan – Delhi to Jaipur Urbania on rent for family & group tours" loading="lazy"><span>280 km · 4 hrs</span></div>
                    <h3>Delhi to Jaipur Road Trip Guide</h3>
                    <p>Expressway tips, royal palaces and the best stops along the way.</p>
                </a>
                <a href="blog-delhi-to-manali.php" class="hp-blog reveal">
                    <div class="hp-blog-media"><img src="images/blog_delhi_manali.jpg" alt="Snow-covered mountain peaks in Manali, Himachal Pradesh – Delhi to Manali Urbania on rent for family & group tours" loading="lazy"><span>530 km · 11 hrs</span></div>
                    <h3>Escaping to the Hills: Delhi to Manali</h3>
                    <p>Atal Tunnel, snow peaks and smooth mountain cruising.</p>
                </a>
                <a href="blog-delhi-to-chardham.php" class="hp-blog reveal">
                    <div class="hp-blog-media"><img src="images/blog_delhi_chardham.jpg" alt="Ancient Kedarnath Temple against Himalayan snow peaks – Delhi to Kedarnath Urbania on rent for family & group tours" loading="lazy"><span>1,600+ km · 12 days</span></div>
                    <h3>Sacred Circuit: Char Dham Yatra</h3>
                    <p>A complete pilgrimage guide for Kedarnath and Badrinath.</p>
                </a>
            </div>
        </div>
    </section>

    <!-- ============ SERVICE AREAS & ROUTES (SEO) ============ -->
    <section class="hp-section hp-soft">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">Urbania on Rent Near Me</span>
                <h2>Urbania on Rent for Outstation Trips</h2>
            </div>
            <div class="hp-seo-copy hp-justify hp-plain-links reveal">
                <p>Urbania on Rent Delhi is a dedicated <strong>Urbania rental in Delhi</strong> for groups of 9 to 16 travellers. Choose the <a href="force-urbania-luxury-maharaja-on-rent-delhi.php">Luxury Maharaja Urbania</a> — <a href="9-seater-urbania-maharaja-delhi.php">9 seater</a> or <a href="12-seater-urbania-luxury-delhi.php">12 seater</a> — for weddings, corporate guests and premium family trips, or the <a href="16-seater-urbania-normal-delhi.php">16 seater Normal Urbania</a> with 2x1 seats for large group tours. Every Urbania comes with full AC and a professional driver. <strong>Urbania booking Delhi</strong> takes just one call or WhatsApp message.</p>
                <p><strong>Service areas:</strong> <a href="urbania-on-rent-gurgaon.php">Urbania on rent in Gurgaon</a>, <a href="urbania-on-rent-noida.php">Urbania on rent in Noida</a>, <a href="delhi-to-ghaziabad-urbania-on-rent.php">Urbania on rent in Ghaziabad</a>, <a href="delhi-to-faridabad-urbania-on-rent.php">Urbania on rent in Faridabad</a> and <a href="delhi-to-greater-noida-urbania-on-rent.php">Greater Noida</a> — with free doorstep pickup across Delhi NCR.</p>
                <p><strong>Popular Urbania for outstation Delhi routes:</strong> <a href="delhi-to-manali-urbania.php">Delhi to Manali Urbania</a>, <a href="delhi-to-shimla-urbania.php">Delhi to Shimla Urbania</a>, <a href="delhi-to-chandigarh-urbania.php">Delhi to Chandigarh Urbania</a>, <a href="delhi-to-haridwar-urbania.php">Delhi to Haridwar Urbania</a>, <a href="delhi-to-rishikesh-urbania.php">Delhi to Rishikesh Urbania</a>, <a href="delhi-to-kedarnath-urbania.php">Delhi to Kedarnath Urbania</a>, <a href="delhi-to-badrinath-urbania-on-rent.php">Delhi to Badrinath Urbania</a>, <a href="char-dham-urbania-package.php">Delhi to Chardham Urbania</a>, <a href="kashmir-urbania-package.php">Delhi to Amarnath Urbania</a>, <a href="delhi-to-jaipur-urbania.php">Delhi to Jaipur Urbania</a> and <a href="delhi-to-udaipur-urbania.php">Delhi to Udaipur Urbania</a>.</p>
                <p><strong>Book an Urbania for:</strong> family trip, group tour, wedding, corporate tour, airport transfer, religious tour and outstation travel — the most comfortable <strong>luxury traveller for group tour Delhi</strong>.</p>
            </div>
        </div>
    </section>

    <!-- ============ DELHI NCR PICKUP AREAS ============ -->
    <section class="hp-section">
        <div class="container">
            <?php render_ncr_areas(); ?>
            <div class="hp-packages reveal">
                <span>Urbania by type:</span>
                <?php foreach (landing_links() as $url => $label): ?>
                <a href="<?php echo $url; ?>"><?php echo $label; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============ HOMEPAGE SEO CONTENT ============ -->
    <section class="hp-section" id="urbania-guide">
        <div class="container">
            <div class="hp-seo-copy hp-keyword-copy hp-justify hp-plain-links">
                <?php render_home_seo_sections(); ?>
            </div>
        </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="hp-section hp-soft" id="faq">
        <div class="container hp-faq-wrap">
            <div class="hp-faq-intro reveal">
                <span class="hp-kicker">FAQ</span>
                <h2>Frequently Asked Questions</h2>
                <p>Can't find what you're looking for? Our team is available around the clock.</p>
                <a href="tel:+917290885949" class="hp-btn hp-btn-dark"><i class="fas fa-phone"></i> +91 72908 85949</a>
            </div>
            <div class="hp-faq hp-justify">
                <?php foreach ($faqs as $i => $f): ?>
                <details class="reveal" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary><?php echo $f['q']; ?><i class="fas fa-plus"></i></summary>
                    <p><?php echo $f['a']; ?></p>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    <?php
    echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(function ($f) {
            return ['@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f['a'])]];
        }, $faqs),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>
    </script>

    <?php echo fleet_offer_schema($fleet, 'Force Urbania on Rent in Delhi NCR — Normal & Luxury Maharaja'); ?>

    <!-- Dynamic Destination Route Search Engine -->
    <script>
    (function () {
        const DESTINATIONS = <?php echo json_encode($hp_destinations, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>;
        const VALID_ORIGINS = ['delhi', 'noida', 'ghaziabad', 'faridabad', 'gurgaon'];
        const POPULAR_SLUGS = ['manali', 'jaipur', 'agra', 'rishikesh', 'shimla', 'haridwar', 'amritsar', 'chandigarh', 'udaipur', 'nainital', 'mussoorie', 'kedarnath'];

        const form = document.getElementById('hpRouteSearchForm');
        const pickupSelect = document.getElementById('hpPickupCity');
        const destInput = document.getElementById('hpDestInput');
        const destSlugInput = document.getElementById('hpDestSlug');
        const destDropdown = document.getElementById('hpDestDropdown');
        const clearBtn = document.getElementById('hpDestClearBtn');
        const searchBtn = document.getElementById('hpSearchRoutesBtn');
        const feedbackBanner = document.getElementById('hpSearchFeedback');
        const feedbackMsg = document.getElementById('hpFeedbackMsg');
        const destField = document.getElementById('hpDestField');

        if (!form || !destInput || !destDropdown) return;

        let activeIndex = -1;
        let currentMatches = [];
        let isDropdownOpen = false;

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function highlightMatch(text, query) {
            if (!query) return escapeHtml(text);
            const q = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp('(' + q + ')', 'gi');
            const escaped = escapeHtml(text);
            return escaped.replace(regex, '<mark>$1</mark>');
        }

        function showFeedback(msg) {
            if (feedbackMsg && feedbackBanner) {
                feedbackMsg.textContent = msg;
                feedbackBanner.style.display = 'flex';
                destInput.style.borderColor = '#dc2626';
            }
        }

        function hideFeedback() {
            if (feedbackBanner) {
                feedbackBanner.style.display = 'none';
                destInput.style.borderColor = '';
            }
        }

        function updateButtonState() {
            const hasValidDest = destSlugInput.value.trim() !== '';
            const hasValidOrigin = VALID_ORIGINS.includes(pickupSelect.value.toLowerCase());
            searchBtn.disabled = !(hasValidDest && hasValidOrigin);
        }

        function openDropdown() {
            destDropdown.style.display = 'block';
            destInput.setAttribute('aria-expanded', 'true');
            isDropdownOpen = true;
        }

        function closeDropdown() {
            destDropdown.style.display = 'none';
            destInput.setAttribute('aria-expanded', 'false');
            isDropdownOpen = false;
            activeIndex = -1;
        }

        function getPopularDestinations() {
            const popular = [];
            POPULAR_SLUGS.forEach(function (slug) {
                const found = DESTINATIONS.find(function (d) { return d.slug === slug; });
                if (found) popular.push(found);
            });
            return popular;
        }

        function renderResults(items, isPopular, query) {
            currentMatches = items;
            activeIndex = -1;
            destDropdown.innerHTML = '';

            if (items.length === 0) {
                destDropdown.innerHTML = `
                    <div class="hp-dest-empty">
                        <i class="fas fa-location-dot"></i>
                        <strong>No destination matching "${escapeHtml(query)}"</strong>
                        <span>Try searching popular destinations like Manali, Jaipur, Agra, Shimla, or Rishikesh.</span>
                    </div>
                `;
                openDropdown();
                return;
            }

            const header = document.createElement('div');
            header.className = 'hp-dropdown-section-title';
            header.innerHTML = isPopular 
                ? '<i class="fas fa-fire" style="color: #c9a23a;"></i> Top Outstation Destinations' 
                : '<i class="fas fa-compass" style="color: #c9a23a;"></i> ' + items.length + ' Matching Destination' + (items.length > 1 ? 's' : '');
            destDropdown.appendChild(header);

            items.forEach(function (item, idx) {
                const el = document.createElement('div');
                el.className = 'hp-dest-item';
                el.setAttribute('role', 'option');
                el.setAttribute('id', 'hp-dest-opt-' + idx);
                el.setAttribute('data-slug', item.slug);
                el.setAttribute('data-name', item.name);

                const highlightedName = isPopular ? escapeHtml(item.name) : highlightMatch(item.name, query);
                const badgeText = item.category || (isPopular ? 'Popular' : 'Urbania Route');

                el.innerHTML = `
                    <div class="hp-dest-item-main">
                        <span class="hp-dest-item-icon"><i class="fas fa-location-dot"></i></span>
                        <div class="hp-dest-item-info">
                            <span class="hp-dest-name">${highlightedName}</span>
                            <span class="hp-dest-state">${escapeHtml(item.state || 'India')}</span>
                        </div>
                    </div>
                    <span class="hp-dest-badge">${escapeHtml(badgeText)}</span>
                `;

                // Handle click & mobile touch selection
                el.addEventListener('mousedown', function (e) {
                    e.preventDefault(); // Prevent input blur before click registers
                    selectDestination(item.slug, item.name);
                });

                destDropdown.appendChild(el);
            });

            openDropdown();
        }

        function selectDestination(slug, name) {
            destInput.value = name;
            destSlugInput.value = slug;
            clearBtn.style.display = 'inline-flex';
            hideFeedback();
            updateButtonState();
            closeDropdown();
        }

        function filterDestinations(query) {
            const q = query.toLowerCase().trim();
            if (!q) {
                renderResults(getPopularDestinations(), true, '');
                return;
            }

            const startsWithMatches = [];
            const containsMatches = [];
            const stateMatches = [];

            DESTINATIONS.forEach(function (d) {
                const nameLower = d.name.toLowerCase();
                const stateLower = (d.state || '').toLowerCase();

                if (nameLower.startsWith(q)) {
                    startsWithMatches.push(d);
                } else if (nameLower.includes(q)) {
                    containsMatches.push(d);
                } else if (stateLower.includes(q)) {
                    stateMatches.push(d);
                }
            });

            const merged = [...startsWithMatches, ...containsMatches, ...stateMatches].slice(0, 25);
            renderResults(merged, false, q);
        }

        function updateActiveItem(newIndex) {
            const items = destDropdown.querySelectorAll('.hp-dest-item');
            if (items.length === 0) return;

            items.forEach(function (el) { el.classList.remove('is-active'); });

            if (newIndex >= 0 && newIndex < items.length) {
                activeIndex = newIndex;
                items[activeIndex].classList.add('is-active');
                items[activeIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                destInput.setAttribute('aria-activedescendant', items[activeIndex].id);
            } else {
                activeIndex = -1;
                destInput.removeAttribute('aria-activedescendant');
            }
        }

        function resolveMatchingDestination(text) {
            const t = text.toLowerCase().trim();
            if (!t) return null;
            // 1. Exact match on name
            let match = DESTINATIONS.find(function (d) { return d.name.toLowerCase() === t; });
            if (match) return match;
            // 2. Exact match on slug
            match = DESTINATIONS.find(function (d) { return d.slug.toLowerCase() === t; });
            if (match) return match;
            // 3. First prefix match
            match = DESTINATIONS.find(function (d) { return d.name.toLowerCase().startsWith(t); });
            if (match) return match;
            return null;
        }

        // Input event
        destInput.addEventListener('input', function () {
            const val = destInput.value.trim();
            destSlugInput.value = ''; // Invalidate slug until user selects or exact match verified
            updateButtonState();
            hideFeedback();

            if (val) {
                clearBtn.style.display = 'inline-flex';
                filterDestinations(val);
                // Check if exact typed string matches a destination
                const exact = DESTINATIONS.find(function (d) { return d.name.toLowerCase() === val.toLowerCase(); });
                if (exact) {
                    destSlugInput.value = exact.slug;
                    updateButtonState();
                }
            } else {
                clearBtn.style.display = 'none';
                renderResults(getPopularDestinations(), true, '');
            }
        });

        // Focus & Click on input
        destInput.addEventListener('focus', function () {
            hideFeedback();
            const val = destInput.value.trim();
            if (val) {
                filterDestinations(val);
            } else {
                renderResults(getPopularDestinations(), true, '');
            }
        });

        // Keyboard navigation
        destInput.addEventListener('keydown', function (e) {
            if (!isDropdownOpen && (e.key === 'ArrowDown' || e.key === 'ArrowUp')) {
                openDropdown();
                return;
            }

            const items = destDropdown.querySelectorAll('.hp-dest-item');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                let nextIdx = activeIndex + 1;
                if (nextIdx >= items.length) nextIdx = 0;
                updateActiveItem(nextIdx);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                let prevIdx = activeIndex - 1;
                if (prevIdx < 0) prevIdx = items.length - 1;
                updateActiveItem(prevIdx);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (isDropdownOpen && activeIndex >= 0 && currentMatches[activeIndex]) {
                    const picked = currentMatches[activeIndex];
                    selectDestination(picked.slug, picked.name);
                    triggerRouteSearch();
                } else {
                    const typed = destInput.value.trim();
                    const match = resolveMatchingDestination(typed);
                    if (match) {
                        selectDestination(match.slug, match.name);
                        triggerRouteSearch();
                    } else {
                        showFeedback('Please select a valid destination from the suggestions.');
                    }
                }
            } else if (e.key === 'Escape') {
                closeDropdown();
            } else if (e.key === 'Tab') {
                closeDropdown();
            }
        });

        // Clear button
        clearBtn.addEventListener('click', function () {
            destInput.value = '';
            destSlugInput.value = '';
            clearBtn.style.display = 'none';
            hideFeedback();
            updateButtonState();
            destInput.focus();
            renderResults(getPopularDestinations(), true, '');
        });

        // Pickup city change
        pickupSelect.addEventListener('change', function () {
            hideFeedback();
            updateButtonState();
        });

        // Click outside closes dropdown
        document.addEventListener('click', function (e) {
            if (!destField.contains(e.target)) {
                closeDropdown();
            }
        });

        // Navigation executor
        function triggerRouteSearch() {
            const origin = pickupSelect.value.toLowerCase().trim();
            let slug = destSlugInput.value.toLowerCase().trim();

            if (!VALID_ORIGINS.includes(origin)) {
                showFeedback('Please select a valid pickup city.');
                return false;
            }

            // Auto-resolve if user typed but didn't click
            if (!slug) {
                const typed = destInput.value.trim();
                const match = resolveMatchingDestination(typed);
                if (match) {
                    slug = match.slug;
                    destSlugInput.value = slug;
                    destInput.value = match.name;
                    updateButtonState();
                }
            }

            if (!slug) {
                showFeedback('Please select a valid destination to search routes.');
                destInput.focus();
                return false;
            }

            // Direct route URL navigation (NO WhatsApp redirect!)
            // Every origin has a physical <slug>.php stub that loads route.php (no .htaccess needed)
            const routeSlug = origin + '-to-' + slug + '-urbania-on-rent';
            const targetUrl = routeSlug + '.php';
            window.location.href = targetUrl;
            return true;
        }

        // Form submission intercept
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            triggerRouteSearch();
        });
    })();
    </script>
</main>

<?php include 'footer.php'; ?>

