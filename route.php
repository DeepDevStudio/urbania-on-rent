<?php
// route.php - Reusable Dynamic Template for All 611 Destination Route Pages
// Urbania on Rent Delhi

require_once __DIR__ . '/includes/site-data.php';
require_once __DIR__ . '/includes/destinations-data.php';
require_once __DIR__ . '/includes/services/ImageAltService.php';
require_once __DIR__ . '/includes/route-seo-content.php';

// Retrieve requested slug from GET or from REQUEST_URI
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
if (empty($slug)) {
    $req_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $slug = basename($req_uri, '.php');
}

// Fetch destination data
$dest = get_destination_by_slug($slug);

// If not found, fallback to Manali or 404
if (!$dest) {
    // Check if it's an alias or redirect to destinations.php
    header("HTTP/1.1 404 Not Found");
    $page_title = "Destination Not Found | Urbania on Rent Delhi";
    include __DIR__ . '/header.php';
    echo '<main style="padding: 100px 20px; text-align: center;">
        <div class="container">
            <h1 style="font-size: 2.5rem; color: #0f172a; margin-bottom: 20px;">Destination Page Not Found</h1>
            <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 30px;">The destination route you are looking for may have been moved or updated.</p>
            <a href="destinations.php" class="btn-primary" style="display: inline-block; padding: 12px 28px; background: #D4AF37; color: #0f172a; font-weight: 700; border-radius: 8px; text-decoration: none;"><i class="fas fa-compass"></i> Explore All 611 Destinations</a>
        </div>
    </main>';
    include __DIR__ . '/footer.php';
    exit;
}

// Setup Origin and Page Metadata
$origin_name = !empty($dest['origin']) ? $dest['origin'] : 'Delhi';
$origin_id = !empty($dest['origin_id']) ? $dest['origin_id'] : 'delhi';
$origin_hub = !empty($dest['origin_hub_url']) ? $dest['origin_hub_url'] : ('destinations.php?origin=' . $origin_id);

$c_kw = $dest['destination'];
$canonical_url = route_public_url($dest);
$route_meta = route_seo_meta($dest, $canonical_url);
$custom_primary_meta = $route_meta['primary'];
$custom_social_meta = $route_meta['social'];
$hide_breadcrumb = true; // Handled custom in page

include __DIR__ . '/header.php';

// Calculate estimated roundtrip base fare for popular configurations
$dist_val = $dest['distance'];
$min_billable_km = max($dist_val * 2, 500); // Outstation roundtrip minimum
$fare_9s = number_format($min_billable_km * 45);
$fare_12s = number_format($min_billable_km * 45);
$fare_16s = number_format($min_billable_km * 40);
?>

<main class="destination-page-wrapper">
    <!-- Destination Breadcrumbs -->
    <div class="page-breadcrumb" style="background: #0b1120; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 12px 0;">
        <div class="container">
            <a href="index.php" class="breadcrumb-link" style="color: #94a3b8;"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator" style="color: #64748b; margin: 0 8px;"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></span>
            <a href="<?php echo htmlspecialchars($origin_hub); ?>" class="breadcrumb-link" style="color: #94a3b8;"><?php echo htmlspecialchars($origin_name); ?> Destinations</a>
            <span class="breadcrumb-separator" style="color: #64748b; margin: 0 8px;"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></span>
            <span class="breadcrumb-current" style="color: #D4AF37; font-weight: 600;"><?php echo htmlspecialchars($origin_name); ?> to <?php echo htmlspecialchars($dest['destination']); ?> Urbania</span>
        </div>
    </div>

    <!-- JSON-LD BreadcrumbList Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://urbaniaonrentdelhi.co.in/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "<?php echo addslashes($origin_name); ?> Destinations",
          "item": "https://urbaniaonrentdelhi.co.in/<?php echo ltrim($origin_hub, '/'); ?>"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "<?php echo addslashes($origin_name); ?> to <?php echo addslashes($dest['destination']); ?> Urbania on Rent",
          "item": "<?php echo $canonical_url; ?>"
        }
      ]
    }
    </script>

    <!-- Destination Hero Section -->
    <section class="destination-hero premium-hero" style="background: linear-gradient(135deg, rgba(11, 17, 32, 0.82), rgba(15, 23, 42, 0.75)), url('<?php echo htmlspecialchars($dest['hero_image']); ?>') no-repeat center center / cover; padding: 100px 0 80px; text-align: center; position: relative;">
        <div class="container">
            <div class="destination-hero-content enhanced" style="max-width: 950px; margin: 0 auto; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); border: 1px solid rgba(212, 175, 55, 0.35); border-radius: 24px; padding: 45px 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);">
                <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <span class="hero-badge" style="background: rgba(212,175,55,0.2); color: #D4AF37; border: 1px solid #D4AF37; padding: 6px 16px; border-radius: 30px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-route"></i> <?php echo htmlspecialchars($dest['state']); ?></span>
                    <span class="hero-badge" style="background: rgba(255,255,255,0.1); color: #f1f5f9; border: 1px solid rgba(255,255,255,0.2); padding: 6px 16px; border-radius: 30px; font-size: 0.85rem; font-weight: 600;"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($dest['category']); ?></span>
                </div>
                
                <h1 style="font-size: clamp(2.2rem, 5vw, 3.8rem); font-weight: 900; color: #ffffff; margin: 12px 0; line-height: 1.2;">
                    <?php echo htmlspecialchars($origin_name); ?> to <span style="color: #D4AF37;"><?php echo htmlspecialchars($dest['destination']); ?></span> Urbania on Rent
                </h1>
                
                <p class="tagline" style="font-size: clamp(1rem, 2vw, 1.25rem); color: #cbd5e1; max-width: 780px; margin: 15px auto 25px; line-height: 1.6;">
                    Comfortable Force Urbania rental from <?php echo htmlspecialchars($origin_name); ?> to <?php echo htmlspecialchars($dest['destination']); ?> for family trips, corporate groups, and outstation tours with certified chauffeurs.
                </p>

                <div class="hero-cta-buttons" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo wa_link('Hello, I want to book a luxury Force Urbania for ' . $origin_name . ' to ' . $dest['destination'] . ' tour.'); ?>" target="_blank" class="btn-hero-wa" style="display: inline-flex; align-items: center; gap: 8px; background: #25D366; color: #ffffff; font-weight: 700; padding: 14px 28px; border-radius: 10px; text-decoration: none; font-size: 1rem; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4); transition: transform 0.2s;">
                        <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i> WhatsApp Booking
                    </a>
                    <a href="tel:<?php echo $site_phone_tel; ?>" class="btn-hero-call" style="display: inline-flex; align-items: center; gap: 8px; background: #D4AF37; color: #0f172a; font-weight: 700; padding: 14px 28px; border-radius: 10px; text-decoration: none; font-size: 1rem; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4); transition: transform 0.2s;">
                        <i class="fas fa-phone-alt"></i> Call <?php echo $site_phone_display; ?>
                    </a>
                    <a href="contact.php" class="btn-hero-quote" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.15); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); font-weight: 600; padding: 14px 24px; border-radius: 10px; text-decoration: none; font-size: 1rem;">
                        <i class="fas fa-file-invoice"></i> Get Custom Quote
                    </a>
                </div>
            </div>
        </div>
        <?php if (!empty($dest['image_credit']['page'])): $credit = $dest['image_credit']; ?>
        <p class="hero-photo-credit" style="position: absolute; right: 12px; bottom: 8px; margin: 0; max-width: calc(100% - 24px); font-size: 0.72rem; line-height: 1.3; color: rgba(255,255,255,0.7); text-align: right;">
            Photo: <a href="<?php echo htmlspecialchars($credit['page']); ?>" target="_blank" rel="noopener nofollow" style="color: inherit;"><?php echo htmlspecialchars($credit['subject']); ?></a>
            by <?php echo htmlspecialchars($credit['artist']); ?>,
            <?php if (!empty($credit['license_url'])): ?><a href="<?php echo htmlspecialchars($credit['license_url']); ?>" target="_blank" rel="noopener nofollow" style="color: inherit;"><?php echo htmlspecialchars($credit['license']); ?></a><?php else: echo htmlspecialchars($credit['license']); endif; ?>,
            via Wikimedia Commons
        </p>
        <?php endif; ?>
    </section>

    <!-- Route Quick Facts Bar -->
    <section class="quick-facts-bar" style="background: #ffffff; padding: 25px 0; border-bottom: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        <div class="container">
            <div class="facts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; align-items: center;">
                <div class="fact-card" style="display: flex; align-items: center; gap: 15px; padding: 10px;">
                    <div class="fact-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(212,175,55,0.12); color: #D4AF37; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;"><i class="fas fa-road"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Distance</div>
                        <div style="font-size: 1.25rem; font-weight: 800; color: #0f172a;"><?php echo htmlspecialchars($dest['distance_str']); ?></div>
                    </div>
                </div>
                <div class="fact-card" style="display: flex; align-items: center; gap: 15px; padding: 10px;">
                    <div class="fact-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(212,175,55,0.12); color: #D4AF37; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;"><i class="fas fa-clock"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Driving Time</div>
                        <div style="font-size: 1.25rem; font-weight: 800; color: #0f172a;"><?php echo htmlspecialchars($dest['estimated_travel_time']); ?></div>
                    </div>
                </div>
                <div class="fact-card" style="display: flex; align-items: center; gap: 15px; padding: 10px;">
                    <div class="fact-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(212,175,55,0.12); color: #D4AF37; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Ideal Duration</div>
                        <div style="font-size: 1.15rem; font-weight: 800; color: #0f172a;"><?php echo htmlspecialchars($dest['recommended_duration']); ?></div>
                    </div>
                </div>
                <div class="fact-card" style="display: flex; align-items: center; gap: 15px; padding: 10px;">
                    <div class="fact-icon" style="width: 48px; height: 48px; border-radius: 12px; background: rgba(212,175,55,0.12); color: #D4AF37; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;"><i class="fas fa-users"></i></div>
                    <div>
                        <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Capacity</div>
                        <div style="font-size: 1.15rem; font-weight: 800; color: #0f172a;">9 to 16 Seater</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Overview & About Route Section -->
    <section class="route-about-section" style="padding: 70px 0; background: #f8fafc;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 45px; align-items: start;">
                <div class="about-text-col">
                    <div class="badge-tag" style="display: inline-block; color: #D4AF37; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;"><i class="fas fa-map-marked-alt"></i> Journey Overview</div>
                    <h2 style="font-size: 2.2rem; color: #0f172a; font-weight: 800; margin-bottom: 20px; line-height: 1.3;">
                        Your Premium Travel Experience from <?php echo htmlspecialchars($origin_name); ?> to <?php echo htmlspecialchars($dest['destination']); ?>
                    </h2>
                    <p style="font-size: 1.05rem; color: #475569; line-height: 1.8; margin-bottom: 18px;">
                        <?php echo htmlspecialchars($dest['description']); ?>
                    </p>
                    <p style="font-size: 1.05rem; color: #475569; line-height: 1.8; margin-bottom: 25px;">
                        Whether traveling for a holiday, religious pilgrimage, family function, destination wedding, or corporate conference, hiring a <strong>Force Urbania on rent in <?php echo htmlspecialchars($origin_name); ?></strong> gives your group the ultimate in seating comfort, panoramic sightseeing views, and zero-fatigue long-distance touring.
                    </p>

                    <h3 style="font-size: 1.35rem; color: #0f172a; font-weight: 700; margin: 30px 0 15px;"><i class="fas fa-check-circle" style="color: #10b981;"></i> Key Route Highlights</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: 1fr; gap: 12px;">
                        <?php foreach ($dest['highlights'] as $hl): ?>
                        <li style="display: flex; align-items: center; gap: 12px; background: #ffffff; padding: 14px 18px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 0.95rem; color: #334155; font-weight: 500;">
                            <i class="fas fa-star" style="color: #D4AF37; flex-shrink: 0;"></i> <?php echo htmlspecialchars($hl); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Right Column: Why Travel by Urbania Card -->
                <div class="urbania-advantages-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 35px 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                        <div style="width: 44px; height: 44px; border-radius: 10px; background: #0f172a; color: #D4AF37; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;"><i class="fas fa-van-shuttle"></i></div>
                        <h3 style="font-size: 1.3rem; color: #0f172a; font-weight: 800; margin: 0;">Why Travel by Force Urbania?</h3>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                        <li style="display: flex; align-items: start; gap: 12px;">
                            <i class="fas fa-couch" style="color: #D4AF37; margin-top: 4px; font-size: 1.1rem;"></i>
                            <div>
                                <strong style="color: #0f172a; font-size: 0.95rem; display: block;">Pushback Captain Seats</strong>
                                <span style="font-size: 0.85rem; color: #64748b;">Extra wide armrests and superior leg space for relaxed long highway drives.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: start; gap: 12px;">
                            <i class="fas fa-snowflake" style="color: #38bdf8; margin-top: 4px; font-size: 1.1rem;"></i>
                            <div>
                                <strong style="color: #0f172a; font-size: 0.95rem; display: block;">Individual AC Vents & Climate Control</strong>
                                <span style="font-size: 0.85rem; color: #64748b;">Personalized airflow and temperature control for every passenger seat.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: start; gap: 12px;">
                            <i class="fas fa-suitcase-rolling" style="color: #D4AF37; margin-top: 4px; font-size: 1.1rem;"></i>
                            <div>
                                <strong style="color: #0f172a; font-size: 0.95rem; display: block;">Spacious Boot & Overhead Racks</strong>
                                <span style="font-size: 0.85rem; color: #64748b;">Dedicated luggage boot accommodating 10-15 large suitcases safely.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: start; gap: 12px;">
                            <i class="fas fa-user-shield" style="color: #10b981; margin-top: 4px; font-size: 1.1rem;"></i>
                            <div>
                                <strong style="color: #0f172a; font-size: 0.95rem; display: block;">Verified Outstation Chauffeur</strong>
                                <span style="font-size: 0.85rem; color: #64748b;">Experienced, courteous drivers with deep knowledge of interstate routes & hill roads.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: start; gap: 12px;">
                            <i class="fas fa-wifi" style="color: #8b5cf6; margin-top: 4px; font-size: 1.1rem;"></i>
                            <div>
                                <strong style="color: #0f172a; font-size: 0.95rem; display: block;">USB Charging & Infotainment</strong>
                                <span style="font-size: 0.85rem; color: #64748b;">Individual USB charging ports for phones and smart LED entertainment screen.</span>
                            </div>
                        </li>
                    </ul>

                    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #f1f5f9; text-align: center;">
                        <a href="tel:<?php echo $site_phone_tel; ?>" style="display: block; width: 100%; padding: 12px; background: #0f172a; color: #ffffff; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.95rem;"><i class="fas fa-phone-alt" style="color: #D4AF37;"></i> Instant Booking: <?php echo $site_phone_display; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Journey / Route Steps -->
    <section class="journey-flow-section" style="padding: 60px 0; background: #ffffff; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
        <div class="container">
            <div class="section-title text-center" style="text-align: center; margin-bottom: 40px;">
                <span class="badge-tag" style="color: #D4AF37; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-map-signs"></i> Route Navigation</span>
                <h2 style="font-size: 2.2rem; color: #0f172a; font-weight: 800; margin-top: 5px;"><?php echo htmlspecialchars($origin_name); ?> to <?php echo htmlspecialchars($dest['destination']); ?> Highway Corridor</h2>
                <p style="color: #64748b; font-size: 1rem; max-width: 600px; margin: 0 auto;">Key stopovers and transit points along the drive</p>
            </div>

            <div class="route-steps-container" style="display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 15px; max-width: 1000px; margin: 0 auto;">
                <?php 
                $stops = $dest['route_stops'];
                foreach ($stops as $idx => $stop): 
                ?>
                <div class="route-step-pill" style="display: flex; align-items: center; gap: 10px; background: <?php echo ($idx === 0 || $idx === count($stops) - 1) ? '#0f172a' : '#f8fafc'; ?>; color: <?php echo ($idx === 0 || $idx === count($stops) - 1) ? '#ffffff' : '#1e293b'; ?>; border: 1px solid <?php echo ($idx === 0 || $idx === count($stops) - 1) ? '#D4AF37' : '#e2e8f0'; ?>; padding: 10px 18px; border-radius: 30px; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <i class="fas fa-map-marker-alt" style="color: <?php echo ($idx === 0 || $idx === count($stops) - 1) ? '#D4AF37' : '#94a3b8'; ?>;"></i>
                    <span><?php echo htmlspecialchars($stop); ?></span>
                </div>
                <?php if ($idx < count($stops) - 1): ?>
                <div class="step-arrow" style="color: #D4AF37; font-size: 1.1rem;"><i class="fas fa-arrow-right"></i></div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Itinerary & Attractions Grid -->
    <section class="itinerary-attractions-section" style="padding: 70px 0; background: #f8fafc;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 45px;">
                <!-- Suggested Itinerary -->
                <div class="itinerary-col">
                    <div class="badge-tag" style="color: #D4AF37; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-calendar-check"></i> Recommended Tour Plan</div>
                    <h2 style="font-size: 2rem; color: #0f172a; font-weight: 800; margin: 5px 0 25px;">Suggested Tour Itinerary</h2>
                    
                    <div class="itinerary-timeline" style="display: flex; flex-direction: column; gap: 20px;">
                        <?php 
                        $itinerary = !empty($dest['suggested_itinerary']) ? $dest['suggested_itinerary'] : [
                            [
                                'day' => 'Day 1',
                                'title' => 'Departure from ' . $origin_name . ' to ' . $dest['destination'],
                                'desc' => 'Doorstep pickup from ' . $origin_name . ' in comfortable Force Urbania. Enjoy scenic highway travel, pleasant stopovers for meals, and safe arrival in ' . $dest['destination'] . ' with hotel check-in.'
                            ],
                            [
                                'day' => 'Day 2',
                                'title' => 'Full Day Sightseeing & Local Attractions',
                                'desc' => 'Explore the renowned viewpoints, cultural landmarks, pilgrimage spots, and bustling local markets of ' . $dest['destination'] . ' with dedicated chauffer assistance.'
                            ],
                            [
                                'day' => 'Day 3',
                                'title' => 'Leisure Sightseeing & Return Journey to ' . $origin_name,
                                'desc' => 'Morning photography and breakfast, followed by comfortable highway cruise back with doorstep drop-off anywhere in ' . $origin_name . '.'
                            ]
                        ];
                        foreach ($itinerary as $itin): 
                        ?>
                        <div class="itinerary-day-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid #D4AF37; border-radius: 12px; padding: 22px 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                <span style="background: rgba(212,175,55,0.15); color: #b08d27; font-weight: 800; font-size: 0.85rem; padding: 4px 12px; border-radius: 6px; text-transform: uppercase;"><?php echo htmlspecialchars($itin['day']); ?></span>
                                <span style="color: #94a3b8; font-size: 0.85rem;"><i class="fas fa-clock"></i> Flexible Schedule</span>
                            </div>
                            <h3 style="font-size: 1.15rem; color: #0f172a; font-weight: 700; margin: 6px 0;"><?php echo htmlspecialchars($itin['title']); ?></h3>
                            <p style="color: #64748b; font-size: 0.95rem; line-height: 1.6; margin: 0;"><?php echo htmlspecialchars($itin['desc']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Top Places to Visit -->
                <div class="attractions-col">
                    <div class="badge-tag" style="color: #D4AF37; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-landmark"></i> Sightseeing Hotspots</div>
                    <h2 style="font-size: 2rem; color: #0f172a; font-weight: 800; margin: 5px 0 25px;">Popular Places in <?php echo htmlspecialchars($dest['destination']); ?></h2>
                    
                    <div class="attractions-list" style="display: flex; flex-direction: column; gap: 15px;">
                        <?php foreach ($dest['nearby_places'] as $place): ?>
                        <div class="attraction-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                            <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(212,175,55,0.12); color: #D4AF37; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;"><i class="fas fa-camera"></i></div>
                            <div>
                                <h3 style="font-size: 1.05rem; color: #0f172a; font-weight: 700; margin: 0 0 4px;"><?php echo htmlspecialchars($place); ?></h3>
                                <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Must-visit spot covered in our customized group sightseeing tours.</p>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Quick Callout Banner -->
                        <div class="custom-tour-callout" style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #ffffff; border-radius: 14px; padding: 25px; margin-top: 10px; border: 1px solid rgba(212,175,55,0.3);">
                            <h4 style="color: #D4AF37; font-size: 1.15rem; font-weight: 700; margin-bottom: 8px;"><i class="fas fa-route"></i> Custom Group Itineraries</h4>
                            <p style="color: #cbd5e1; font-size: 0.9rem; line-height: 1.5; margin-bottom: 15px;">Have specific places you want to visit around <?php echo htmlspecialchars($dest['destination']); ?>? We will customize your complete route and timings at no extra booking charge.</p>
                            <a href="<?php echo wa_link('Hi, I need a customized Force Urbania tour package for ' . $origin_name . ' to ' . $dest['destination']); ?>" target="_blank" style="display: inline-block; padding: 8px 18px; background: #D4AF37; color: #0f172a; border-radius: 6px; font-weight: 700; font-size: 0.85rem; text-decoration: none;"><i class="fab fa-whatsapp"></i> Chat with Tour Expert</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Force Urbania Fleet & Pricing Section (Dynamic Route Pricing Calculator) -->
    <?php include __DIR__ . '/includes/route-pricing-component.php'; ?>

    <!-- Related Destinations Section -->
    <?php 
    // Related Routes: 2 routes with less distance and 2 routes with greater distance in the SAME state as the destination
    $current_dist = (int)($dest['distance'] ?? 0);
    $current_base = $dest['base_slug'] ?? '';
    $current_state = trim($dest['state'] ?? '');
    $origin_pool = get_all_destinations($origin_id);

    $less_routes = [];
    $greater_routes = [];
    $seen_bases = [$current_base => true];

    // 1. Filter candidates from the SAME state
    foreach ($origin_pool as $c) {
        $c_base = $c['base_slug'] ?? '';
        if (empty($c_base) || isset($seen_bases[$c_base])) continue;

        $c_state = trim($c['state'] ?? '');
        if (!empty($current_state) && strcasecmp($c_state, $current_state) !== 0) continue;

        $c_dist = (int)($c['distance'] ?? 0);
        if ($c_dist <= 0) continue;

        if ($c_dist < $current_dist) {
            $less_routes[] = $c;
            $seen_bases[$c_base] = true;
        } elseif ($c_dist > $current_dist) {
            $greater_routes[] = $c;
            $seen_bases[$c_base] = true;
        }
    }

    // Sort less_routes descending by distance (closest to current_dist first). If equal, popular first
    usort($less_routes, function($a, $b) use ($current_dist) {
        $diff_a = abs((int)$a['distance'] - $current_dist);
        $diff_b = abs((int)$b['distance'] - $current_dist);
        if ($diff_a !== $diff_b) {
            return $diff_a <=> $diff_b;
        }
        return (!empty($b['is_popular']) ? 1 : 0) <=> (!empty($a['is_popular']) ? 1 : 0);
    });

    // Sort greater_routes ascending by distance (closest to current_dist first). If equal, popular first
    usort($greater_routes, function($a, $b) use ($current_dist) {
        $diff_a = abs((int)$a['distance'] - $current_dist);
        $diff_b = abs((int)$b['distance'] - $current_dist);
        if ($diff_a !== $diff_b) {
            return $diff_a <=> $diff_b;
        }
        return (!empty($b['is_popular']) ? 1 : 0) <=> (!empty($a['is_popular']) ? 1 : 0);
    });

    $picked_less = array_slice($less_routes, 0, 2);
    $picked_greater = array_slice($greater_routes, 0, 2);

    // If either side in the same state has fewer than 2, top up from the other side in the same state
    if (count($picked_less) < 2) {
        $needed = 2 - count($picked_less);
        $extra = array_slice($greater_routes, count($picked_greater), $needed);
        $picked_greater = array_merge($picked_greater, $extra);
    }
    if (count($picked_greater) < 2) {
        $needed = 2 - count($picked_greater);
        $extra = array_slice($less_routes, count($picked_less), $needed);
        $picked_less = array_merge($picked_less, $extra);
    }

    // Fallback if entire state has fewer than 4 routes: top up from general pool
    $total_picked = count($picked_less) + count($picked_greater);
    if ($total_picked < 4) {
        $needed = 4 - $total_picked;
        $fallback_candidates = [];
        foreach ($origin_pool as $c) {
            $c_base = $c['base_slug'] ?? '';
            if (empty($c_base) || isset($seen_bases[$c_base])) continue;
            $fallback_candidates[] = $c;
            $seen_bases[$c_base] = true;
        }
        usort($fallback_candidates, function($a, $b) use ($current_dist) {
            return abs((int)$a['distance'] - $current_dist) <=> abs((int)$b['distance'] - $current_dist);
        });
        $extra = array_slice($fallback_candidates, 0, $needed);
        $picked_greater = array_merge($picked_greater, $extra);
    }

    // Sort final 4 routes ascending by distance for clean visual progression
    $rel_routes_pool = array_merge($picked_less, $picked_greater);
    usort($rel_routes_pool, function($a, $b) {
        return (int)$a['distance'] <=> (int)$b['distance'];
    });

    $rel_routes = array_column($rel_routes_pool, 'slug');
    if (!empty($rel_routes)): 
    ?>
    <section class="related-routes-section">
        <style>
            .related-routes-section {
                padding: 70px 0;
                background: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }
            .related-routes-header {
                text-align: center;
                margin-bottom: 40px;
            }
            .related-routes-kicker {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: #c9a23a;
                font-weight: 700;
                font-size: 0.82rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                margin-bottom: 8px;
            }
            .related-routes-title {
                font-size: clamp(1.8rem, 3vw, 2.3rem);
                color: #0f172a;
                font-weight: 800;
                margin: 0;
                letter-spacing: -0.02em;
            }
            .related-routes-subtitle {
                color: #64748b;
                font-size: 0.95rem;
                margin-top: 8px;
                max-width: 620px;
                margin-left: auto;
                margin-right: auto;
            }
            .related-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 24px;
                align-items: stretch;
            }
            @media (max-width: 1100px) {
                .related-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                }
            }
            @media (max-width: 640px) {
                .related-grid {
                    grid-template-columns: 1fr;
                    gap: 18px;
                }
            }
            .related-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
                transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s, border-color 0.3s;
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            .related-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 16px 30px -10px rgba(15, 23, 42, 0.12);
                border-color: rgba(201, 162, 58, 0.45);
            }
            .related-card-img-wrap {
                position: relative;
                width: 100%;
                height: 175px;
                aspect-ratio: 16 / 10;
                overflow: hidden;
                background: #0f172a;
                flex-shrink: 0;
            }
            .related-card-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                transition: transform 0.5s ease;
            }
            .related-card:hover .related-card-img-wrap img {
                transform: scale(1.06);
            }
            .related-badge-state {
                position: absolute;
                top: 12px;
                left: 12px;
                background: rgba(15, 23, 42, 0.85);
                color: #e2c46b;
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: uppercase;
                padding: 4px 10px;
                border-radius: 999px;
                border: 1px solid rgba(226, 196, 107, 0.3);
                backdrop-filter: blur(6px);
                letter-spacing: 0.04em;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }
            .related-card-body {
                padding: 20px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
                justify-content: space-between;
            }
            .related-card-title {
                font-size: 1.15rem;
                color: #0f172a;
                font-weight: 800;
                margin: 0 0 12px;
                line-height: 1.35;
            }
            .related-card-title a {
                color: inherit;
                text-decoration: none;
                transition: color 0.2s ease;
            }
            .related-card-title a:hover {
                color: #c9a23a;
            }
            .related-card-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #f8fafc;
                padding: 10px 14px;
                border-radius: 10px;
                font-size: 0.85rem;
                color: #475569;
                margin-bottom: 18px;
                border: 1px solid #f1f5f9;
            }
            .related-card-meta span {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-weight: 600;
            }
            .related-card-meta i {
                color: #c9a23a;
                font-size: 0.88rem;
            }
            .related-card-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                padding: 12px;
                background: #0f172a;
                color: #ffffff !important;
                border-radius: 10px;
                font-weight: 700;
                font-size: 0.88rem;
                text-decoration: none;
                transition: all 0.25s ease;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
                margin-top: auto;
            }
            .related-card-btn:hover {
                background: linear-gradient(135deg, #e2c46b, #c9a23a);
                color: #0f172a !important;
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(201, 162, 58, 0.35);
            }
        </style>
        <div class="container">
            <div class="related-routes-header">
                <span class="related-routes-kicker"><i class="fas fa-compass"></i> Discover More Routes</span>
                <h2 class="related-routes-title">Related Routes from <?php echo htmlspecialchars($origin_name); ?></h2>
                <p class="related-routes-subtitle">Explore more popular outstation trips and luxury Force Urbania itineraries from <?php echo htmlspecialchars($origin_name); ?>.</p>
            </div>

            <div class="related-grid">
                <?php 
                foreach ($rel_routes as $rel_slug): 
                    $rel_dest = get_destination_by_slug($rel_slug);
                    if (!$rel_dest) continue;
                    $rel_origin = $rel_dest['origin'] ?? $origin_name;
                ?>
                <div class="related-card">
                    <div class="related-card-img-wrap">
                        <a href="<?php echo htmlspecialchars($rel_dest['slug']); ?>.php#pricing" style="display: block; width: 100%; height: 100%;">
                            <img src="<?php echo htmlspecialchars($rel_dest['hero_image']); ?>" alt="<?php echo htmlspecialchars(ImageAltService::withRouteKeywords($rel_dest['image_alt'] ?? ImageAltService::getDestinationAlt($rel_dest['hero_image'], $rel_dest['destination'], $rel_origin, $rel_dest['state']), $rel_dest['destination'], $rel_origin)); ?>" width="600" height="375" loading="lazy">
                        </a>
                        <span class="related-badge-state"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($rel_dest['state']); ?></span>
                    </div>
                    <div class="related-card-body">
                        <div>
                            <h3 class="related-card-title">
                                <a href="<?php echo htmlspecialchars($rel_dest['slug']); ?>.php#pricing"><?php echo htmlspecialchars($rel_origin); ?> to <?php echo htmlspecialchars($rel_dest['destination']); ?></a>
                            </h3>
                            <div class="related-card-meta">
                                <span><i class="fas fa-road"></i> <?php echo htmlspecialchars($rel_dest['distance_str']); ?></span>
                                <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($rel_dest['estimated_travel_time']); ?></span>
                            </div>
                        </div>
                        <a href="<?php echo htmlspecialchars($rel_dest['slug']); ?>.php#pricing" class="related-card-btn">
                            View Route &amp; Fares <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Famous Routes Section (Fixed 8 Famous Routes Carousel across Delhi, Noida, Ghaziabad, Gurgaon, Faridabad) -->
    <?php
    $famous_bases = ['agra', 'jaipur', 'manali', 'shimla', 'rishikesh', 'haridwar', 'amritsar', 'varanasi'];
    $famous_routes = [];
    foreach ($famous_bases as $f_base) {
        $f_slug = $origin_id . '-to-' . $f_base . '-urbania-on-rent';
        $f_dest = get_destination_by_slug($f_slug);
        if ($f_dest) {
            $famous_routes[] = $f_dest;
        }
    }
    if (!empty($famous_routes)):
    ?>
    <section class="famous-routes-section" id="famous-routes-section">
        <style>
            .famous-routes-section {
                padding: 70px 0 80px;
                background: #ffffff;
                position: relative;
                overflow: hidden;
                border-top: 1px solid #e2e8f0;
                border-bottom: 1px solid #e2e8f0;
            }
            .famous-routes-glow {
                display: none;
            }
            .famous-routes-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-bottom: 35px;
                flex-wrap: wrap;
                gap: 20px;
                position: relative;
                z-index: 2;
            }
            .famous-routes-kicker {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: #fffcf0;
                color: #b0851e;
                border: 1px solid rgba(212, 175, 55, 0.4);
                padding: 5px 14px;
                border-radius: 999px;
                font-weight: 700;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                margin-bottom: 10px;
            }
            .famous-routes-title {
                font-size: clamp(1.8rem, 3vw, 2.3rem);
                color: #0f172a;
                font-weight: 800;
                margin: 0;
                letter-spacing: -0.02em;
            }
            .famous-routes-title span {
                color: #c9a23a;
                background: none;
                -webkit-background-clip: unset;
                -webkit-text-fill-color: #c9a23a;
            }
            .famous-routes-subtitle {
                color: #64748b;
                font-size: 0.95rem;
                margin-top: 8px;
                max-width: 600px;
                line-height: 1.6;
            }
            .famous-controls-wrap {
                display: flex;
                align-items: center;
                gap: 16px;
            }
            .famous-carousel-dots {
                display: flex;
                gap: 7px;
                align-items: center;
            }
            .famous-carousel-dot {
                width: 9px;
                height: 9px;
                border-radius: 50%;
                background: #cbd5e1;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .famous-carousel-dot.active {
                width: 26px;
                border-radius: 999px;
                background: #c9a23a;
                box-shadow: 0 2px 8px rgba(201, 162, 58, 0.4);
            }
            .famous-nav-btns {
                display: flex;
                gap: 10px;
            }
            .famous-nav-btn {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: #ffffff;
                border: 1.5px solid #e2e8f0;
                color: #0f172a;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.25s ease;
                font-size: 0.95rem;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.06);
            }
            .famous-nav-btn:hover {
                background: linear-gradient(135deg, #e2c46b, #c9a23a);
                color: #0f172a;
                border-color: #c9a23a;
                transform: scale(1.06);
                box-shadow: 0 4px 14px rgba(201, 162, 58, 0.35);
            }
            .famous-carousel-viewport {
                overflow: hidden;
                position: relative;
                z-index: 2;
                padding: 10px 4px 16px;
                cursor: grab;
                user-select: none;
            }
            .famous-carousel-viewport:active {
                cursor: grabbing;
            }
            .famous-carousel-track {
                display: flex;
                gap: 20px;
                transition: transform 0.65s cubic-bezier(0.25, 1, 0.5, 1);
                will-change: transform;
            }
            .famous-card {
                flex: 0 0 calc((100% - 3 * 20px) / 4);
                box-sizing: border-box;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s, border-color 0.3s;
                box-shadow: 0 4px 15px rgba(15, 23, 42, 0.05);
            }
            @media (max-width: 1100px) {
                .famous-card {
                    flex: 0 0 calc((100% - 2 * 16px) / 3);
                }
                .famous-carousel-track {
                    gap: 16px;
                }
            }
            @media (max-width: 768px) {
                .famous-card {
                    flex: 0 0 calc((100% - 14px) / 2);
                }
                .famous-carousel-track {
                    gap: 14px;
                }
                .famous-routes-section {
                    padding: 50px 0 60px;
                }
            }
            @media (max-width: 520px) {
                .famous-card {
                    flex: 0 0 84%;
                }
                .famous-carousel-track {
                    gap: 12px;
                }
            }
            .famous-card:hover {
                transform: translateY(-6px);
                border-color: rgba(201, 162, 58, 0.5);
                box-shadow: 0 16px 30px -10px rgba(15, 23, 42, 0.12), 0 0 14px rgba(212, 175, 55, 0.15);
            }
            .famous-card-img-wrap {
                position: relative;
                width: 100%;
                height: 180px;
                overflow: hidden;
                background: #f1f5f9;
            }
            .famous-card-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }
            .famous-card:hover .famous-card-img-wrap img {
                transform: scale(1.08);
            }
            .famous-card-tag {
                position: absolute;
                top: 12px;
                left: 12px;
                background: rgba(15, 23, 42, 0.85);
                color: #e2c46b;
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: uppercase;
                padding: 4px 10px;
                border-radius: 999px;
                border: 1px solid rgba(226, 196, 107, 0.35);
                backdrop-filter: blur(6px);
                letter-spacing: 0.04em;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }
            .famous-card-origin-tag {
                position: absolute;
                top: 12px;
                right: 12px;
                background: linear-gradient(135deg, rgba(212, 175, 55, 0.95), rgba(201, 162, 58, 0.95));
                color: #0f172a;
                font-size: 0.7rem;
                font-weight: 800;
                text-transform: uppercase;
                padding: 3px 9px;
                border-radius: 6px;
                letter-spacing: 0.03em;
            }
            .famous-card-body {
                padding: 20px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
                justify-content: space-between;
                background: #ffffff;
            }
            .famous-card-title {
                font-size: 1.15rem;
                color: #0f172a;
                font-weight: 800;
                margin: 0 0 12px;
                line-height: 1.35;
            }
            .famous-card-title a {
                color: #0f172a;
                text-decoration: none;
                transition: color 0.2s ease;
            }
            .famous-card-title a:hover {
                color: #c9a23a;
            }
            .famous-card-meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #f8fafc;
                padding: 10px 14px;
                border-radius: 10px;
                font-size: 0.85rem;
                color: #475569;
                margin-bottom: 18px;
                border: 1px solid #f1f5f9;
            }
            .famous-card-meta span {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-weight: 600;
            }
            .famous-card-meta i {
                color: #c9a23a;
                font-size: 0.88rem;
            }
            .famous-card-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                padding: 12px;
                background: #0f172a;
                color: #ffffff !important;
                border: 1px solid #0f172a;
                border-radius: 10px;
                font-weight: 700;
                font-size: 0.88rem;
                text-decoration: none;
                transition: all 0.25s ease;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
                margin-top: auto;
            }
            .famous-card-btn:hover {
                background: linear-gradient(135deg, #e2c46b, #c9a23a);
                color: #0f172a !important;
                border-color: #c9a23a;
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(201, 162, 58, 0.35);
            }
            .famous-card-btn i {
                color: #e2c46b;
                transition: transform 0.2s ease, color 0.2s ease;
            }
            .famous-card-btn:hover i {
                color: #0f172a;
                transform: translateX(4px);
            }
        </style>
        <div class="famous-routes-glow"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="famous-routes-header">
                <div>
                    <span class="famous-routes-kicker"><i class="fas fa-crown"></i> Fixed Top 8 Routes</span>
                    <h2 class="famous-routes-title">Famous Outstation Routes from <span><?php echo htmlspecialchars($origin_name); ?></span></h2>
                    <p class="famous-routes-subtitle">Handpicked top itineraries across India booked most frequently with our luxury Force Urbania chauffeur fleet.</p>
                </div>

                <div class="famous-controls-wrap">
                    <div class="famous-carousel-dots" id="famousCarouselDots"></div>
                    <div class="famous-nav-btns">
                        <button type="button" class="famous-nav-btn" id="famousPrevBtn" aria-label="Previous Slide">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="famous-nav-btn" id="famousNextBtn" aria-label="Next Slide">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="famous-carousel-viewport" id="famousCarouselViewport">
                <div class="famous-carousel-track" id="famousCarouselTrack">
                    <?php foreach ($famous_routes as $f_item): 
                        $f_item_origin = $f_item['origin'] ?? $origin_name;
                    ?>
                    <div class="famous-card">
                        <div class="famous-card-img-wrap">
                            <a href="<?php echo htmlspecialchars($f_item['slug']); ?>.php#pricing" style="display: block; width: 100%; height: 100%;">
                                <img src="<?php echo htmlspecialchars($f_item['hero_image']); ?>" alt="<?php echo htmlspecialchars(ImageAltService::withRouteKeywords($f_item['image_alt'] ?? ImageAltService::getDestinationAlt($f_item['hero_image'], $f_item['destination'], $f_item_origin, $f_item['state']), $f_item['destination'], $f_item_origin)); ?>" width="600" height="375" loading="lazy">
                            </a>
                            <span class="famous-card-tag"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($f_item['state']); ?></span>
                            <span class="famous-card-origin-tag"><?php echo htmlspecialchars($origin_name); ?></span>
                        </div>
                        <div class="famous-card-body">
                            <div>
                                <h3 class="famous-card-title">
                                    <a href="<?php echo htmlspecialchars($f_item['slug']); ?>.php#pricing"><?php echo htmlspecialchars($f_item_origin); ?> to <?php echo htmlspecialchars($f_item['destination']); ?></a>
                                </h3>
                                <div class="famous-card-meta">
                                    <span><i class="fas fa-road"></i> <?php echo htmlspecialchars($f_item['distance_str']); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($f_item['estimated_travel_time']); ?></span>
                                </div>
                            </div>
                            <a href="<?php echo htmlspecialchars($f_item['slug']); ?>.php#pricing" class="famous-card-btn">
                                View Route &amp; Fares <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <script>
        (function() {
            const track = document.getElementById('famousCarouselTrack');
            const prevBtn = document.getElementById('famousPrevBtn');
            const nextBtn = document.getElementById('famousNextBtn');
            const dotsContainer = document.getElementById('famousCarouselDots');
            const viewport = document.getElementById('famousCarouselViewport');

            if (!track || !prevBtn || !nextBtn || !dotsContainer || !viewport) return;

            const cards = Array.from(track.querySelectorAll('.famous-card'));
            const totalCards = cards.length;
            let currentIndex = 0;
            let autoplayTimer = null;

            function getVisibleCards() {
                const w = window.innerWidth;
                if (w > 1100) return 4;
                if (w > 768) return 3;
                if (w > 520) return 2;
                return 1;
            }

            function getMaxIndex() {
                const visible = getVisibleCards();
                return Math.max(0, totalCards - visible);
            }

            function renderDots() {
                dotsContainer.innerHTML = '';
                const maxIdx = getMaxIndex();
                const totalDots = maxIdx + 1;

                for (let i = 0; i < totalDots; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'famous-carousel-dot' + (i === currentIndex ? ' active' : '');
                    dot.setAttribute('role', 'button');
                    dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                    dot.addEventListener('click', () => {
                        goToSlide(i);
                        resetAutoplay();
                    });
                    dotsContainer.appendChild(dot);
                }
            }

            function updateCarousel() {
                const maxIdx = getMaxIndex();
                if (currentIndex > maxIdx) currentIndex = 0;
                if (currentIndex < 0) currentIndex = maxIdx;

                if (cards.length > 0) {
                    const cardRect = cards[0].getBoundingClientRect();
                    const cardWidth = cardRect.width;
                    const style = window.getComputedStyle(track);
                    const gap = parseFloat(style.gap) || 20;
                    const translateX = currentIndex * (cardWidth + gap);
                    track.style.transform = `translateX(-${translateX}px)`;
                }

                // Update dots
                const dots = dotsContainer.querySelectorAll('.famous-carousel-dot');
                dots.forEach((dot, idx) => {
                    dot.classList.toggle('active', idx === currentIndex);
                });

                // Always active nav buttons for continuous infinite wrap
                prevBtn.style.opacity = '1';
                prevBtn.style.pointerEvents = 'auto';
                nextBtn.style.opacity = '1';
                nextBtn.style.pointerEvents = 'auto';
            }

            function goToSlide(idx) {
                currentIndex = idx;
                updateCarousel();
            }

            function nextSlide() {
                const maxIdx = getMaxIndex();
                if (currentIndex < maxIdx) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateCarousel();
            }

            function prevSlide() {
                const maxIdx = getMaxIndex();
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = maxIdx;
                }
                updateCarousel();
            }

            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoplay();
            });

            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoplay();
            });

            // Touch & Drag Support
            let startX = 0;
            let currentX = 0;
            let isDragging = false;

            viewport.addEventListener('touchstart', (e) => {
                if (!e.touches || !e.touches[0]) return;
                startX = e.touches[0].clientX;
                currentX = startX;
                isDragging = true;
            }, { passive: true });

            viewport.addEventListener('touchmove', (e) => {
                if (!isDragging || !e.touches || !e.touches[0]) return;
                currentX = e.touches[0].clientX;
            }, { passive: true });

            const finishSwipe = () => {
                if (!isDragging) return;
                isDragging = false;
                const diff = startX - currentX;
                if (Math.abs(diff) > 40 && currentX !== 0) {
                    if (diff > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                }
                startX = 0;
                currentX = 0;
                resetAutoplay();
            };

            viewport.addEventListener('touchend', finishSwipe);
            viewport.addEventListener('touchcancel', finishSwipe);

            function startAutoplay() {
                stopAutoplay();
                autoplayTimer = setInterval(() => {
                    nextSlide();
                }, 2800);
            }

            function stopAutoplay() {
                if (autoplayTimer) {
                    clearInterval(autoplayTimer);
                    autoplayTimer = null;
                }
            }

            function resetAutoplay() {
                stopAutoplay();
                startAutoplay();
            }

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    stopAutoplay();
                } else {
                    startAutoplay();
                }
            });

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    renderDots();
                    updateCarousel();
                }, 100);
            });

            renderDots();
            updateCarousel();
            startAutoplay();
        })();
        </script>
    </section>
    <?php endif; ?>

    <!-- Origin-Specific Pickup Section Component -->
    <?php 
    $destinationName = $dest['destination'];
    $destinationSlug = $dest['slug'];
    $pickupOriginId  = $origin_id;
    $pickupOriginName= $origin_name;
    include __DIR__ . '/includes/destination-pickup-points.php'; 
    ?>

    <!-- Route Keyword Content -->
    <section class="route-seo-section">
        <div class="container">
            <div class="route-seo-copy">
                <?php render_route_seo_sections($dest); ?>
            </div>
        </div>
    </section>

    <!-- Destination FAQs Section -->
    <section class="destination-faqs-section" style="padding: 70px 0; background: #ffffff; border-top: 1px solid #e2e8f0;">
        <div class="container">
            <div class="section-title text-center" style="text-align: center; margin-bottom: 40px;">
                <span class="badge-tag" style="color: #D4AF37; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-question-circle"></i> Got Questions?</span>
                <h2 style="font-size: 2.2rem; color: #0f172a; font-weight: 800; margin-top: 5px;"><?php echo htmlspecialchars($origin_name); ?> to <?php echo htmlspecialchars($dest['destination']); ?> Urbania FAQs</h2>
            </div>

            <div class="faqs-accordion" style="display: flex; flex-direction: column; gap: 15px;">
                <?php $route_faqs = array_merge($dest['faqs'], route_seo_faqs($dest)); ?>
                <?php foreach ($route_faqs as $f_idx => $faq): ?>
                <details class="faq-item" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 24px; cursor: pointer;" <?php echo ($f_idx === 0) ? 'open' : ''; ?>>
                    <summary style="font-weight: 700; font-size: 1.05rem; color: #0f172a; outline: none; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                        <span><i class="fas fa-circle-question" style="color: #D4AF37; margin-right: 8px;"></i> <?php echo htmlspecialchars($faq['q']); ?></span>
                        <i class="fas fa-chevron-down" style="color: #94a3b8; font-size: 0.85rem;"></i>
                    </summary>
                    <p style="color: #475569; font-size: 0.95rem; line-height: 1.7; text-align: justify; margin: 15px 0 0; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                        <?php echo htmlspecialchars($faq['a']); ?>
                    </p>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Combined Schema: AutoRental, WebPage, Service & FAQPage -->
    <?php echo route_seo_schema($dest, $canonical_url, $route_faqs); ?>

    <!-- Call to Action Banner -->
    <section class="cta-section" style="padding: 60px 0; background: #0b1120;">
        <div class="container">
            <div class="cta-content glass-panel" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 45px 35px; text-align: center; color: #ffffff;">
                <div class="cta-icon" style="color: #D4AF37; font-size: 2.5rem; margin-bottom: 15px;">
                    <i class="fas fa-van-shuttle"></i>
                </div>
                <h2 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 10px;">Ready for your trip to <?php echo htmlspecialchars($dest['destination']); ?>?</h2>
                <p style="color: #cbd5e1; font-size: 1.1rem; max-width: 650px; margin: 0 auto 25px;">
                    Book your luxury Force Urbania with driver today. Enjoy doorstep pickup across <?php echo htmlspecialchars($origin_name); ?> & Delhi NCR, verified drivers, and guaranteed best rates.
                </p>
                <div class="cta-buttons" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo wa_link('Hi, I want to book a Force Urbania for ' . $origin_name . ' to ' . $dest['destination']); ?>" target="_blank" class="btn" style="background: #25D366; color: #ffffff; border: none; font-weight: 700; padding: 14px 28px; border-radius: 8px; text-decoration: none;"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                    <a href="tel:<?php echo $site_phone_tel; ?>" class="btn" style="background: #D4AF37; color: #0f172a; border: none; font-weight: 700; padding: 14px 28px; border-radius: 8px; text-decoration: none;"><i class="fas fa-phone-alt"></i> Call <?php echo $site_phone_display; ?></a>
                    <a href="contact.php" class="btn btn-outline-light" style="border: 1px solid #ffffff; color: #ffffff; padding: 14px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Request Quote</a>
                </div>
            </div>
        </div>
    </section>

    <?php
    $seo_city = $dest['destination'];
    $seo_origin = $origin_name;
    $seo_state = $dest['state'];
    $seo_distance = $dest['distance_str'];
    $seo_time = $dest['estimated_travel_time'];
    $seo_category = $dest['category'];
    include __DIR__ . '/includes/city-seo-block.php';
    ?>
</main>

<?php
include __DIR__ . '/footer.php';
?>
