<?php
// destinations.php - Master Multi-Origin Destination Hub
// Urbania on Rent Delhi NCR

require_once __DIR__ . '/includes/site-data.php';
require_once __DIR__ . '/includes/destinations-data.php';

$valid_origins = get_all_origins();
$requested_origin = isset($_GET['origin']) ? strtolower(trim($_GET['origin'])) : '';
if (empty($requested_origin)) {
    $req_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if (preg_match('#/destinations/([a-z]+)#i', $req_path, $m)) {
        $requested_origin = strtolower($m[1]);
    }
}
if (!array_key_exists($requested_origin, $valid_origins)) {
    $requested_origin = 'delhi';
}

$current_origin_id = $requested_origin;
$current_origin = $valid_origins[$current_origin_id];
$origin_display_name = $current_origin['name'];

$all_destinations = get_all_destinations($current_origin_id);
$total_destinations = count($all_destinations);

if ($current_origin_id === 'delhi') {
    $page_title = 'Explore 600+ Destinations by Force Urbania on Rent from Delhi | Best Group Travel Routes';
    $page_description = 'Discover over 600+ outstation travel routes from Delhi by luxury Force Urbania on rent. Hire 9, 12 & 16 seater Urbania with driver for hill stations, pilgrimage tours, Rajasthan, Uttarakhand & Himachal.';
    $page_keywords = 'urbania destinations from delhi, delhi to outstation urbania, force urbania route hire, delhi to manali urbania, delhi to jaipur urbania, luxury van hire outstation routes';
    $canonical_url = 'https://urbaniaonrentdelhi.co.in/destinations.php';
} else {
    $page_title = 'Explore 600+ Destinations by Force Urbania on Rent from ' . $origin_display_name . ' | Luxury Outstation Van Hire';
    $page_description = 'Book luxury Force Urbania on rent from ' . $origin_display_name . ' with driver across 600+ outstation routes. 9, 12 & 16 seater Urbania for hill stations, pilgrimage tours, corporate trips & family vacations.';
    $page_keywords = 'urbania destinations from ' . strtolower($origin_display_name) . ', ' . strtolower($origin_display_name) . ' to outstation urbania, force urbania hire ' . strtolower($origin_display_name) . ', luxury van rental ' . strtolower($origin_display_name);
    $canonical_url = 'https://urbaniaonrentdelhi.co.in/destinations/' . $current_origin_id;
}
$hide_breadcrumb = true;

include __DIR__ . '/header.php';
?>

<main class="destinations-hub-page">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb" style="background: #0b1120; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 12px 0;">
        <div class="container">
            <a href="index.php" class="breadcrumb-link" style="color: #94a3b8;"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator" style="color: #64748b; margin: 0 8px;"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></span>
            <?php if ($current_origin_id === 'delhi'): ?>
            <span class="breadcrumb-current" style="color: #D4AF37; font-weight: 600;">Destinations</span>
            <?php else: ?>
            <a href="destinations.php" class="breadcrumb-link" style="color: #94a3b8;">Destinations</a>
            <span class="breadcrumb-separator" style="color: #64748b; margin: 0 8px;"><i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i></span>
            <span class="breadcrumb-current" style="color: #D4AF37; font-weight: 600;"><?php echo htmlspecialchars($origin_display_name); ?> Hub</span>
            <?php endif; ?>
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
          "name": "<?php echo addslashes($origin_display_name); ?> Destinations",
          "item": "<?php echo $canonical_url; ?>"
        }
      ]
    }
    </script>

    <!-- Hub Hero Section -->
    <section class="destinations-hub-hero" style="background: linear-gradient(135deg, rgba(11, 17, 32, 0.90), rgba(15, 23, 42, 0.84)), url('images/destinations/golden-triangle.jpg') no-repeat center center / cover; padding: 85px 0 75px; text-align: center; color: #ffffff;">
        <div class="container">
            <div class="hub-hero-inner" style="max-width: 960px; margin: 0 auto;">
                <span class="hero-badge" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(212,175,55,0.2); color: #D4AF37; border: 1px solid #D4AF37; padding: 6px 20px; border-radius: 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">
                    <i class="fas fa-map-marked-alt"></i> Complete Delhi NCR Route Network
                </span>
                
                <h1 style="font-size: clamp(2.3rem, 5vw, 3.8rem); font-weight: 900; line-height: 1.2; margin-bottom: 15px;">
                    Explore India with <span style="color: #D4AF37;">Urbania on Rent</span> from <?php echo htmlspecialchars($origin_display_name); ?>
                </h1>
                
                <p style="font-size: clamp(1.05rem, 2vw, 1.25rem); color: #cbd5e1; max-width: 780px; margin: 0 auto 30px; line-height: 1.6;">
                    Discover comfortable group travel routes from <?php echo htmlspecialchars($origin_display_name); ?> with our premium Force Urbania rental service. Covering <?php echo $total_destinations; ?>+ verified outstation destinations with certified chauffeurs.
                </p>

                <!-- Premium Origin Selector Bar -->
                <div class="origin-selector-wrapper" style="margin-bottom: 35px;">
                    <div style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #D4AF37; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-crosshairs"></i> Select Departure Origin Hub:
                    </div>
                    <div class="origin-pills-container" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 10px;">
                        <?php foreach ($valid_origins as $orig_key => $orig_meta): 
                            $is_active = ($orig_key === $current_origin_id);
                            $hub_href = ($orig_key === 'delhi') ? 'destinations.php' : ('destinations.php?origin=' . $orig_key);
                        ?>
                        <a href="<?php echo $hub_href; ?>" class="origin-hub-pill <?php echo $is_active ? 'active' : ''; ?>">
                            <i class="fas fa-location-dot"></i>
                            <span><?php echo htmlspecialchars($orig_meta['name']); ?></span>
                            <span class="hub-pill-badge">611 Routes</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Search Box -->
                <div class="dest-search-bar" style="max-width: 680px; margin: 0 auto; position: relative;">
                    <div style="display: flex; align-items: center; background: #ffffff; border-radius: 50px; padding: 8px 12px 8px 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.35);">
                        <i class="fas fa-search" style="color: #D4AF37; font-size: 1.2rem; margin-right: 12px;"></i>
                        <input type="text" id="destSearchInput" placeholder="Search from <?php echo htmlspecialchars($origin_display_name); ?> (e.g. Manali, Jaipur, Ayodhya, Agra)..." style="width: 100%; border: none; outline: none; font-size: 1.05rem; color: #1e293b; background: transparent; font-family: inherit;">
                        <button type="button" id="clearSearchBtn" style="display: none; background: none; border: none; color: #94a3b8; font-size: 1.1rem; cursor: pointer; padding: 5px 10px;" title="Clear Search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Pills & Destination Grid Section -->
    <section class="destinations-directory-section" style="padding: 60px 0 90px; background: #f8fafc;">
        <div class="container">
            <!-- Filter Controls -->
            <div class="filter-controls-wrapper" style="margin-bottom: 35px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-sliders-h" style="color: #D4AF37; font-size: 1.1rem;"></i>
                        <h2 style="font-size: 1.35rem; color: #0f172a; font-weight: 800; margin: 0;"><?php echo htmlspecialchars($origin_display_name); ?> Routes by Theme & Region</h2>
                    </div>
                    <div id="resultCountBadge" style="background: #0f172a; color: #D4AF37; padding: 6px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; border: 1px solid rgba(212,175,55,0.3);">
                        Showing <span id="countDisplay"><?php echo $total_destinations; ?></span> Routes from <?php echo htmlspecialchars($origin_display_name); ?>
                    </div>
                </div>

                <!-- Filter Pills -->
                <div class="filter-pills-row" style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <button class="filter-pill active" data-filter="all">All Routes (<?php echo $total_destinations; ?>)</button>
                    <button class="filter-pill" data-filter="popular"><i class="fas fa-crown" style="color: #D4AF37;"></i> Popular Routes</button>
                    <button class="filter-pill" data-filter="Hill Stations"><i class="fas fa-mountain"></i> Hill Stations</button>
                    <button class="filter-pill" data-filter="Religious & Pilgrimage"><i class="fas fa-om"></i> Religious Destinations</button>
                    <button class="filter-pill" data-filter="Rajasthan"><i class="fas fa-chess-rook"></i> Rajasthan</button>
                    <button class="filter-pill" data-filter="Uttarakhand"><i class="fas fa-water"></i> Uttarakhand</button>
                    <button class="filter-pill" data-filter="Himachal Pradesh"><i class="fas fa-snowflake"></i> Himachal Pradesh</button>
                    <button class="filter-pill" data-filter="Uttar Pradesh"><i class="fas fa-archway"></i> Uttar Pradesh</button>
                    <button class="filter-pill" data-filter="Punjab"><i class="fas fa-sun"></i> Punjab</button>
                    <button class="filter-pill" data-filter="Haryana"><i class="fas fa-landmark"></i> Haryana</button>
                    <button class="filter-pill" data-filter="Jammu & Kashmir"><i class="fas fa-tree"></i> Jammu & Kashmir</button>
                    <button class="filter-pill" data-filter="Weekend Getaways"><i class="fas fa-clock"></i> Weekend (< 250 km)</button>
                    <button class="filter-pill" data-filter="Long Distance Routes"><i class="fas fa-road"></i> Long Distance (> 450 km)</button>
                </div>
            </div>

            <!-- CSS for Origin Hub Pills & Filter Pills -->
            <style>
                .origin-hub-pill {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 10px 20px;
                    border-radius: 30px;
                    font-weight: 700;
                    font-size: 0.95rem;
                    text-decoration: none;
                    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                    border: 1px solid rgba(212, 175, 55, 0.4);
                    background: rgba(15, 23, 42, 0.85);
                    color: #e2e8f0;
                    backdrop-filter: blur(10px);
                }
                .origin-hub-pill:hover {
                    background: rgba(212, 175, 55, 0.25);
                    border-color: #D4AF37;
                    color: #ffffff;
                    transform: translateY(-2px);
                }
                .origin-hub-pill.active {
                    background: linear-gradient(135deg, #D4AF37 0%, #fef08a 100%);
                    color: #0f172a;
                    border-color: #D4AF37;
                    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.45);
                    transform: translateY(-2px);
                }
                .origin-hub-pill .hub-pill-badge {
                    font-size: 0.72rem;
                    padding: 2px 8px;
                    border-radius: 12px;
                    background: rgba(0, 0, 0, 0.35);
                    color: inherit;
                    font-weight: 800;
                    letter-spacing: 0.3px;
                }
                .origin-hub-pill.active .hub-pill-badge {
                    background: rgba(15, 23, 42, 0.25);
                    color: #0f172a;
                }
                .filter-pill {
                    background: #ffffff;
                    color: #334155;
                    border: 1px solid #cbd5e1;
                    padding: 8px 16px;
                    border-radius: 30px;
                    font-size: 0.9rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.25s ease;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                }
                .filter-pill:hover {
                    background: #f1f5f9;
                    border-color: #94a3b8;
                    transform: translateY(-1px);
                }
                .filter-pill.active {
                    background: #0f172a;
                    color: #ffffff;
                    border-color: #D4AF37;
                    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
                }
                .dest-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
                    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s;
                    display: flex;
                    flex-direction: column;
                }
                .dest-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
                    border-color: rgba(212,175,55,0.4);
                }
                .dest-card-img-wrap {
                    position: relative;
                    height: 180px;
                    aspect-ratio: 16 / 9;
                    overflow: hidden;
                    background: #0f172a;
                }
                .dest-card-img-wrap img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: center;
                    transition: transform 0.5s ease;
                }
                .dest-card:hover .dest-card-img-wrap img {
                    transform: scale(1.05);
                }
                .dest-badge-state {
                    position: absolute;
                    top: 12px;
                    left: 12px;
                    background: rgba(15, 23, 42, 0.85);
                    color: #D4AF37;
                    font-size: 0.75rem;
                    font-weight: 700;
                    padding: 4px 10px;
                    border-radius: 20px;
                    border: 1px solid rgba(212,175,55,0.4);
                    backdrop-filter: blur(4px);
                }
                .dest-badge-cat {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                    background: rgba(255, 255, 255, 0.9);
                    color: #0f172a;
                    font-size: 0.75rem;
                    font-weight: 700;
                    padding: 4px 10px;
                    border-radius: 20px;
                }
                .pagination-btn {
                    padding: 10px 18px;
                    background: #ffffff;
                    border: 1px solid #cbd5e1;
                    border-radius: 8px;
                    font-weight: 700;
                    color: #0f172a;
                    cursor: pointer;
                    transition: all 0.2s;
                }
                .pagination-btn:hover:not(:disabled) {
                    background: #0f172a;
                    color: #ffffff;
                    border-color: #0f172a;
                }
                .pagination-btn:disabled {
                    opacity: 0.4;
                    cursor: not-allowed;
                }
                .pagination-btn.active-page {
                    background: #D4AF37;
                    color: #0f172a;
                    border-color: #D4AF37;
                }
            </style>

            <!-- Destination Grid Container -->
            <div id="destGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
                <!-- Cards dynamically rendered via JavaScript for 611 items with fast client pagination -->
            </div>

            <!-- No Results Found State -->
            <div id="noResults" style="display: none; text-align: center; padding: 60px 20px;">
                <i class="fas fa-map-location-dot" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                <h3 style="font-size: 1.4rem; color: #0f172a; font-weight: 700; margin-bottom: 8px;">No matching destinations found</h3>
                <p style="color: #64748b; font-size: 1rem;">Try searching for a different city or clearing your filter selection.</p>
                <button type="button" onclick="resetFilters()" style="margin-top: 15px; padding: 10px 24px; background: #D4AF37; color: #0f172a; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">Reset All Filters</button>
            </div>

            <!-- Pagination Bar -->
            <div id="paginationContainer" style="margin-top: 45px; display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
                <!-- Page numbers generated by JS -->
            </div>
        </div>
    </section>

    <!-- Why Choose Force Urbania Section (Compact Automatic Luxury Carousel) -->
    <section class="why-urbania-dest-section" style="padding: 45px 0 50px; background: linear-gradient(180deg, #0b1120 0%, #070a14 100%); position: relative; overflow: hidden; border-top: 1px solid rgba(212,175,55,0.2); border-bottom: 1px solid rgba(212,175,55,0.2);">
        <!-- Background Ambient Glow -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 700px; height: 260px; background: radial-gradient(circle, rgba(212,175,55,0.08) 0%, rgba(11,17,32,0) 70%); pointer-events: none;"></div>

        <div class="container" style="position: relative; z-index: 2; max-width: 1280px; margin: 0 auto; padding: 0 15px;">
            <!-- Compact Header -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(212,175,55,0.12); color: #D4AF37; border: 1px solid rgba(212,175,55,0.35); padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px;">
                        <i class="fas fa-crown" style="font-size: 0.75rem;"></i> Fleet Excellence
                    </span>
                    <h2 style="font-size: clamp(1.4rem, 2.5vw, 1.85rem); color: #ffffff; font-weight: 800; margin: 8px 0 0; letter-spacing: -0.3px;">
                        Why Travel Outstation with Our <span style="background: linear-gradient(90deg, #D4AF37, #fef08a); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Force Urbania</span> Fleet?
                    </h2>
                </div>

                <!-- Controls: Progress Dots + Arrows -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="why-compact-dots" id="whyCarouselDots" style="display: flex; gap: 6px; align-items: center;"></div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="why-compact-nav-btn" id="whyPrevBtn" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="why-compact-nav-btn" id="whyNextBtn" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Carousel Viewport -->
            <div class="why-compact-viewport" id="whyCarouselViewport" style="overflow: hidden; border-radius: 14px; padding: 6px 2px;">
                <div class="why-compact-track" id="whyCarouselTrack" style="display: flex; gap: 16px; transition: transform 0.45s cubic-bezier(0.2, 0.9, 0.3, 1); will-change: transform;">
                    
                    <!-- Card 1: Seating -->
                    <div class="why-compact-card">
                        <div class="why-compact-header">
                            <div class="why-compact-icon"><i class="fas fa-couch"></i></div>
                            <div>
                                <span class="why-compact-category">First-Class</span>
                                <h3>Pushback Luxury Seating</h3>
                            </div>
                        </div>
                        <p>Wide captain seats with generous legroom and deep recline angles ensure seniors, adults, and kids travel without joint fatigue.</p>
                        <div class="why-compact-footer">
                            <span><i class="fas fa-check"></i> 1x1 & 2x1 Layouts</span>
                            <span class="why-mini-badge">Ultra Comfort</span>
                        </div>
                    </div>

                    <!-- Card 2: Stability -->
                    <div class="why-compact-card">
                        <div class="why-compact-header">
                            <div class="why-compact-icon"><i class="fas fa-mountain"></i></div>
                            <div>
                                <span class="why-compact-category">Hill Driving</span>
                                <h3>Hill Road & Highway Stability</h3>
                            </div>
                        </div>
                        <p>Modern monocoque chassis structure with advanced suspension ensures stability and zero body roll across mountain ghats and expressways.</p>
                        <div class="why-compact-footer">
                            <span><i class="fas fa-shield-alt"></i> Anti-Roll Frame</span>
                            <span class="why-mini-badge">Max Safety</span>
                        </div>
                    </div>

                    <!-- Card 3: Drivers -->
                    <div class="why-compact-card">
                        <div class="why-compact-header">
                            <div class="why-compact-icon"><i class="fas fa-user-tie"></i></div>
                            <div>
                                <span class="why-compact-category">Verified</span>
                                <h3>Verified Route Drivers</h3>
                            </div>
                        </div>
                        <p>Professional chauffeurs with 10+ years of highway driving experience, polite demeanor, and thorough familiarity with roadside amenities.</p>
                        <div class="why-compact-footer">
                            <span><i class="fas fa-id-card"></i> Certified Drivers</span>
                            <span class="why-mini-badge">24/7 Help</span>
                        </div>
                    </div>

                    <!-- Card 4: Pricing -->
                    <div class="why-compact-card">
                        <div class="why-compact-header">
                            <div class="why-compact-icon"><i class="fas fa-wallet"></i></div>
                            <div>
                                <span class="why-compact-category">Best Value</span>
                                <h3>Transparent Cost Per Person</h3>
                            </div>
                        </div>
                        <p>Starting at ₹40/km, Force Urbania rental costs significantly less per passenger compared to multiple cabs or train tickets.</p>
                        <div class="why-compact-footer">
                            <span><i class="fas fa-tag"></i> From ₹40/km</span>
                            <span class="why-mini-badge">Zero Hidden</span>
                        </div>
                    </div>

                    <!-- Card 5: Luggage -->
                    <div class="why-compact-card">
                        <div class="why-compact-header">
                            <div class="why-compact-icon"><i class="fas fa-suitcase-rolling"></i></div>
                            <div>
                                <span class="why-compact-category">Storage</span>
                                <h3>Dedicated Boot Space</h3>
                            </div>
                        </div>
                        <p>Generous luggage capacity holds 10–15 large suitcases and luggage easily without sacrificing any passenger foot space.</p>
                        <div class="why-compact-footer">
                            <span><i class="fas fa-box"></i> Boot & Overhead</span>
                            <span class="why-mini-badge">Spacious</span>
                        </div>
                    </div>

                    <!-- Card 6: AC & Charging -->
                    <div class="why-compact-card">
                        <div class="why-compact-header">
                            <div class="why-compact-icon"><i class="fas fa-snowflake"></i></div>
                            <div>
                                <span class="why-compact-category">Amenities</span>
                                <h3>Individual AC & USB Ports</h3>
                            </div>
                        </div>
                        <p>Dedicated personal AC vents, rapid phone charging ports at every seat, and premium audio-visual entertainment for long drives.</p>
                        <div class="why-compact-footer">
                            <span><i class="fas fa-bolt"></i> Fast USB + AC</span>
                            <span class="why-mini-badge">Premium Tech</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Compact Carousel Styles -->
        <style>
            .why-compact-card {
                flex: 0 0 calc(25% - 12px);
                min-width: 0;
                background: rgba(15, 23, 42, 0.75);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(212, 175, 55, 0.22);
                border-radius: 14px;
                padding: 18px 18px 16px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
                box-sizing: border-box;
            }
            .why-compact-card:hover {
                transform: translateY(-4px);
                border-color: rgba(212, 175, 55, 0.6);
                box-shadow: 0 12px 28px rgba(212, 175, 55, 0.12), 0 6px 16px rgba(0, 0, 0, 0.5);
                background: rgba(15, 23, 42, 0.9);
            }
            .why-compact-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 10px;
            }
            .why-compact-icon {
                width: 40px;
                height: 40px;
                flex-shrink: 0;
                border-radius: 10px;
                background: linear-gradient(135deg, rgba(212, 175, 55, 0.22), rgba(212, 175, 55, 0.05));
                border: 1px solid rgba(212, 175, 55, 0.4);
                color: #D4AF37;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.15rem;
                box-shadow: 0 4px 10px rgba(212, 175, 55, 0.1);
            }
            .why-compact-card:hover .why-compact-icon {
                background: #D4AF37;
                color: #0f172a;
            }
            .why-compact-category {
                font-size: 0.68rem;
                color: #D4AF37;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.6px;
                display: block;
                line-height: 1;
                margin-bottom: 3px;
            }
            .why-compact-card h3 {
                font-size: 0.98rem;
                color: #ffffff;
                font-weight: 700;
                margin: 0;
                line-height: 1.25;
            }
            .why-compact-card p {
                color: #94a3b8;
                font-size: 0.82rem;
                line-height: 1.45;
                margin: 0 0 12px;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .why-compact-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 10px;
                border-top: 1px solid rgba(255, 255, 255, 0.07);
                font-size: 0.75rem;
                color: #94a3b8;
            }
            .why-compact-footer i {
                color: #10b981;
                margin-right: 4px;
            }
            .why-mini-badge {
                background: rgba(212, 175, 55, 0.12);
                color: #fef08a;
                font-weight: 700;
                font-size: 0.68rem;
                padding: 2px 8px;
                border-radius: 12px;
                border: 1px solid rgba(212, 175, 55, 0.25);
            }
            .why-compact-nav-btn {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: rgba(15, 23, 42, 0.85);
                border: 1px solid rgba(212, 175, 55, 0.35);
                color: #D4AF37;
                font-size: 0.85rem;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .why-compact-nav-btn:hover {
                background: #D4AF37;
                color: #0f172a;
                transform: scale(1.08);
            }
            .why-compact-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.25);
                cursor: pointer;
                transition: all 0.25s ease;
            }
            .why-compact-dot.active {
                width: 20px;
                border-radius: 10px;
                background: #D4AF37;
                box-shadow: 0 0 8px rgba(212, 175, 55, 0.5);
            }

            @media (max-width: 1100px) {
                .why-compact-card {
                    flex: 0 0 calc(33.333% - 11px);
                }
            }
            @media (max-width: 768px) {
                .why-compact-card {
                    flex: 0 0 calc(50% - 8px);
                }
            }
            @media (max-width: 480px) {
                .why-compact-card {
                    flex: 0 0 85%;
                }
            }
        </style>
    </section>

    <!-- Call to Action Banner -->
    <section class="cta-section" style="padding: 60px 0; background: #0b1120;">
        <div class="container">
            <div class="cta-content glass-panel" style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 45px 35px; text-align: center; color: #ffffff;">
                <div class="cta-icon" style="color: #D4AF37; font-size: 2.5rem; margin-bottom: 15px;">
                    <i class="fas fa-van-shuttle"></i>
                </div>
                <h2 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 10px;">Can't find your specific route or drop point?</h2>
                <p style="color: #cbd5e1; font-size: 1.1rem; max-width: 650px; margin: 0 auto 25px;">
                    We operate pan-India custom charters. Tell us your pickup location, itinerary, and group size for an instant customized quote.
                </p>
                <div class="cta-buttons" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo wa_link('Hi, I need a custom Force Urbania quote from ' . $origin_display_name . ' for an outstation tour.'); ?>" target="_blank" class="btn" style="background: #25D366; color: #ffffff; border: none; font-weight: 700; padding: 14px 28px; border-radius: 8px; text-decoration: none;"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                    <a href="tel:<?php echo $site_phone_tel; ?>" class="btn" style="background: #D4AF37; color: #0f172a; border: none; font-weight: 700; padding: 14px 28px; border-radius: 8px; text-decoration: none;"><i class="fas fa-phone-alt"></i> Call <?php echo $site_phone_display; ?></a>
                    <a href="contact.php" class="btn btn-outline-light" style="border: 1px solid #ffffff; color: #ffffff; padding: 14px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Destinations Data Store & Interactive Directory Engine -->
<script>
const ALL_DESTINATIONS = <?php echo json_encode($all_destinations, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>;
const CURRENT_ORIGIN_ID = <?php echo json_encode($current_origin_id); ?>;
const CURRENT_ORIGIN_NAME = <?php echo json_encode($origin_display_name); ?>;
const ITEMS_PER_PAGE = 24;
let currentPage = 1;
let currentFilter = 'all';
let currentSearch = '';
let filteredDestinations = [...ALL_DESTINATIONS];

const searchInput = document.getElementById('destSearchInput');
const clearSearchBtn = document.getElementById('clearSearchBtn');
const filterPills = document.querySelectorAll('.filter-pill');
const destGrid = document.getElementById('destGrid');
const noResults = document.getElementById('noResults');
const paginationContainer = document.getElementById('paginationContainer');
const countDisplay = document.getElementById('countDisplay');

function applyFilters() {
    const q = currentSearch.toLowerCase().trim();
    
    filteredDestinations = ALL_DESTINATIONS.filter(item => {
        // Filter by tab/category/state
        let matchesFilter = true;
        if (currentFilter === 'popular') {
            matchesFilter = item.is_popular;
        } else if (currentFilter === 'Weekend Getaways') {
            matchesFilter = item.distance <= 250;
        } else if (currentFilter === 'Long Distance Routes') {
            matchesFilter = item.distance > 450;
        } else if (currentFilter !== 'all') {
            matchesFilter = (item.state === currentFilter || item.category === currentFilter);
        }

        if (!matchesFilter) return false;

        // Search match
        if (q) {
            const matchName = item.destination.toLowerCase().includes(q);
            const matchState = item.state.toLowerCase().includes(q);
            const matchCat = item.category.toLowerCase().includes(q);
            const matchDesc = item.description.toLowerCase().includes(q);
            return matchName || matchState || matchCat || matchDesc;
        }
        return true;
    });

    countDisplay.textContent = filteredDestinations.length;
    currentPage = 1;
    renderGrid();
}

function renderGrid() {
    destGrid.innerHTML = '';
    
    if (filteredDestinations.length === 0) {
        noResults.style.display = 'block';
        paginationContainer.style.display = 'none';
        return;
    }

    noResults.style.display = 'none';
    paginationContainer.style.display = 'flex';

    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, filteredDestinations.length);
    const pageItems = filteredDestinations.slice(startIndex, endIndex);

    pageItems.forEach(item => {
        const originName = item.origin || CURRENT_ORIGIN_NAME;
        const card = document.createElement('div');
        card.className = 'dest-card';
        card.innerHTML = `
            <div class="dest-card-img-wrap">
                <a href="${escapeHtml(item.slug)}.php#pricing" style="display: block; width: 100%; height: 100%;">
                    <img src="${escapeHtml(item.hero_image)}" alt="${escapeHtml((item.image_alt || (item.destination + (item.state ? ', ' + item.state : '') + ' travel attractions and scenic landscape')) + ' – ' + originName + ' to ' + item.destination + ' Urbania on rent for family & group tours')}" width="1200" height="675" loading="lazy">
                </a>
                <span class="dest-badge-state"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(item.state)}</span>
                <span class="dest-badge-cat">${escapeHtml(item.category)}</span>
            </div>
            <div style="padding: 22px 20px; display: flex; flex-direction: column; flex-grow: 1;">
                <div style="font-size: 0.8rem; color: #D4AF37; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Direct Outstation Route</div>
                <h3 style="font-size: 1.25rem; color: #0f172a; font-weight: 800; margin: 0 0 12px; line-height: 1.3;">
                    <a href="${escapeHtml(item.slug)}.php#pricing" style="color: inherit; text-decoration: none;">${escapeHtml(originName)} → ${escapeHtml(item.destination)}</a>
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; background: #f8fafc; padding: 10px 12px; border-radius: 8px; margin-bottom: 14px; font-size: 0.85rem; color: #475569;">
                    <div><i class="fas fa-road" style="color: #D4AF37;"></i> <strong>${escapeHtml(item.distance_str)}</strong></div>
                    <div><i class="fas fa-clock" style="color: #D4AF37;"></i> <strong>${escapeHtml(item.estimated_travel_time)}</strong></div>
                    <div style="grid-column: span 2;"><i class="fas fa-calendar-alt" style="color: #D4AF37;"></i> ${escapeHtml(item.recommended_duration)}</div>
                </div>

                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin: 0 0 16px; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    ${escapeHtml(item.description)}
                </p>

                <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 8px; margin-top: auto;">
                    <a href="${escapeHtml(item.slug)}.php#pricing" style="display: block; text-align: center; padding: 10px; background: #0f172a; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: background 0.2s;">
                        <i class="fas fa-route"></i> View Fares
                    </a>
                    <a href="https://wa.me/917290885949?text=${encodeURIComponent('Hi, I want to book a Force Urbania for ' + originName + ' to ' + item.destination)}" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 5px; padding: 10px; background: #25D366; color: #ffffff; border-radius: 8px; font-weight: 700; font-size: 0.85rem; text-decoration: none;">
                        <i class="fab fa-whatsapp"></i> Book
                    </a>
                </div>
            </div>
        `;
        destGrid.appendChild(card);
    });

    renderPagination();
}

function renderPagination() {
    paginationContainer.innerHTML = '';
    const totalPages = Math.ceil(filteredDestinations.length / ITEMS_PER_PAGE);
    if (totalPages <= 1) return;

    // Prev Button
    const prevBtn = document.createElement('button');
    prevBtn.className = 'pagination-btn';
    prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i> Prev';
    prevBtn.disabled = (currentPage === 1);
    prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderGrid(); window.scrollTo({top: 450, behavior: 'smooth'}); } };
    paginationContainer.appendChild(prevBtn);

    // Page Numbers (Smart windowing)
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        addPageBtn(1);
        if (startPage > 2) addEllipsis();
    }

    for (let p = startPage; p <= endPage; p++) {
        addPageBtn(p);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) addEllipsis();
        addPageBtn(totalPages);
    }

    // Next Button
    const nextBtn = document.createElement('button');
    nextBtn.className = 'pagination-btn';
    nextBtn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
    nextBtn.disabled = (currentPage === totalPages);
    nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderGrid(); window.scrollTo({top: 450, behavior: 'smooth'}); } };
    paginationContainer.appendChild(nextBtn);
}

function addPageBtn(pageNo) {
    const btn = document.createElement('button');
    btn.className = 'pagination-btn' + (pageNo === currentPage ? ' active-page' : '');
    btn.textContent = pageNo;
    btn.onclick = () => { currentPage = pageNo; renderGrid(); window.scrollTo({top: 450, behavior: 'smooth'}); };
    paginationContainer.appendChild(btn);
}

function addEllipsis() {
    const span = document.createElement('span');
    span.textContent = '...';
    span.style.padding = '5px 8px';
    span.style.color = '#94a3b8';
    paginationContainer.appendChild(span);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function resetFilters() {
    currentFilter = 'all';
    currentSearch = '';
    searchInput.value = '';
    clearSearchBtn.style.display = 'none';
    filterPills.forEach(p => p.classList.toggle('active', p.dataset.filter === 'all'));
    applyFilters();
}

// Event Listeners
searchInput.addEventListener('input', (e) => {
    currentSearch = e.target.value;
    clearSearchBtn.style.display = currentSearch ? 'block' : 'none';
    applyFilters();
});

clearSearchBtn.addEventListener('click', () => {
    searchInput.value = '';
    currentSearch = '';
    clearSearchBtn.style.display = 'none';
    applyFilters();
});

filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        currentFilter = pill.dataset.filter;
        applyFilters();
    });
});

// Initial Render
applyFilters();

// ==========================================
// COMPACT AUTOMATIC LUXURY CAROUSEL CONTROLLER
// ==========================================
(function() {
    const track = document.getElementById('whyCarouselTrack');
    const prevBtn = document.getElementById('whyPrevBtn');
    const nextBtn = document.getElementById('whyNextBtn');
    const dotsContainer = document.getElementById('whyCarouselDots');
    const viewport = document.getElementById('whyCarouselViewport');

    if (!track || !prevBtn || !nextBtn || !dotsContainer) return;

    const cards = Array.from(track.querySelectorAll('.why-compact-card'));
    const totalCards = cards.length;
    let currentIndex = 0;
    let autoplayTimer = null;

    function getVisibleCards() {
        const w = window.innerWidth;
        if (w > 1100) return 4;
        if (w > 768) return 3;
        if (w > 480) return 2;
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
            dot.className = 'why-compact-dot' + (i === currentIndex ? ' active' : '');
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
        if (currentIndex > maxIdx) currentIndex = maxIdx;
        if (currentIndex < 0) currentIndex = 0;

        if (cards.length > 0) {
            const cardWidth = cards[0].getBoundingClientRect().width;
            const gap = 16; // matches CSS gap
            const translateX = currentIndex * (cardWidth + gap);
            track.style.transform = `translateX(-${translateX}px)`;
        }

        // Update dots
        const dots = dotsContainer.querySelectorAll('.why-compact-dot');
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === currentIndex);
        });

        // Update button states
        prevBtn.style.opacity = currentIndex === 0 ? '0.45' : '1';
        nextBtn.style.opacity = currentIndex >= maxIdx ? '0.45' : '1';
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
    }

    function nextSlide() {
        const maxIdx = getMaxIndex();
        if (currentIndex < maxIdx) {
            currentIndex++;
        } else {
            currentIndex = 0; // seamless loop back to start
        }
        updateCarousel();
    }

    function prevSlide() {
        const maxIdx = getMaxIndex();
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = maxIdx; // loop to end
        }
        updateCarousel();
    }

    // Nav button event listeners
    nextBtn.addEventListener('click', () => {
        nextSlide();
        resetAutoplay();
    });

    prevBtn.addEventListener('click', () => {
        prevSlide();
        resetAutoplay();
    });

    // Autoplay functions (Automatic continuous loop every 3.2s)
    function startAutoplay() {
        stopAutoplay();
        autoplayTimer = setInterval(nextSlide, 3200);
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

    if (viewport) {
        viewport.addEventListener('mouseenter', stopAutoplay);
        viewport.addEventListener('mouseleave', startAutoplay);
    }

    // Touch Swipe Support
    let startX = 0;
    let isTouching = false;

    if (viewport) {
        viewport.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isTouching = true;
            stopAutoplay();
        }, { passive: true });

        viewport.addEventListener('touchend', (e) => {
            if (!isTouching) return;
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;

            if (Math.abs(diffX) > 35) {
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
            isTouching = false;
            startAutoplay();
        }, { passive: true });
    }

    // Handle Window Resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            renderDots();
            updateCarousel();
        }, 120);
    });

    // Initialize
    renderDots();
    updateCarousel();
    startAutoplay();
})();
</script>

<?php
include __DIR__ . '/footer.php';
?>
