<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="icon" type="image/webp" sizes="32x32" href="images/urbania-1.webp">
    
    <!-- Primary Meta Tags -->
    <?php if (!empty($custom_primary_meta)): echo $custom_primary_meta . "\n"; else: ?>
    <title><?php echo isset($page_title) ? $page_title : 'Force Urbania on Rent in Delhi | 9, 12 & 16 Seater Luxury Urbania Hire'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Book Force Urbania on Rent in Delhi for local and outstation trips. 9, 12 & 16 seater luxury Force Urbania available with experienced driver for family tours, outstation trips, weddings and corporate travel. Call 7290885949.'; ?>">
    <meta name="keywords" content="<?php echo isset($page_keywords) ? htmlspecialchars($page_keywords) : 'Force Urbania on rent in delhi, luxury Force Urbania on rent in delhi, 12 seater urbania hire delhi, 16 seater urbania rent delhi, force urbania rental delhi ncr, outstation urbania delhi, urbania with driver delhi'; ?>">
    <?php if (empty($canonical_url)) { $canonical_url = 'https://urbaniaonrentdelhi.co.in/' . (basename($_SERVER['PHP_SELF']) === 'index.php' ? '' : basename($_SERVER['PHP_SELF'])); } ?>
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    <meta name="author" content="Urbania on Rent Delhi">
    <meta name="robots" content="index, follow">
    <?php endif; ?>
    
    <!-- Geo Meta Tags for Delhi NCR Local SEO -->
    <meta name="geo.region" content="IN-DL">
    <meta name="geo.placename" content="New Delhi">
    <meta name="geo.position" content="28.6139;77.2090">
    <meta name="ICBM" content="28.6139, 77.2090">

    <?php if (!empty($custom_social_meta)): echo $custom_social_meta . "\n"; else: ?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo isset($og_type) ? $og_type : 'website'; ?>">
    <meta property="og:url" content="<?php echo $canonical_url; ?>">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title : 'Force Urbania on Rent in Delhi | Luxury Van Hire'; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'Book luxury 9, 12 & 16 seater Force Urbania on rent in Delhi NCR with verified chauffeurs at best per-km rates.'; ?>">
    <meta property="og:image" content="https://urbaniaonrentdelhi.co.in/<?php echo isset($og_image) ? $og_image : 'images/urbania-rent.webp'; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php echo isset($page_title) ? $page_title : 'Force Urbania on Rent in Delhi | Luxury Van Hire'; ?>">
    <meta property="twitter:description" content="<?php echo isset($page_description) ? $page_description : 'Book luxury Force Urbania in Delhi with chauffeur for outstation tours & corporate trips.'; ?>">
    <meta property="twitter:image" content="https://urbaniaonrentdelhi.co.in/<?php echo isset($og_image) ? $og_image : 'images/urbania-rent.webp'; ?>">
    <?php endif; ?>

    <!-- JSON-LD Structured Data Schema for Local Business & Auto Rental SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoRental",
      "name": "Urbania on Rent Delhi",
      "image": "https://urbaniaonrentdelhi.co.in/images/urbania-rent.webp",
      "@id": "https://urbaniaonrentdelhi.co.in",
      "url": "https://urbaniaonrentdelhi.co.in",
      "telephone": "+91-7290885949",
      "email": "rentonurbania@gmail.com",
      "priceRange": "₹40 - ₹45/km",
      "areaServed": ["Delhi", "Gurgaon", "Noida", "Greater Noida", "Ghaziabad", "Faridabad"],
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "B-26, Rajeev Nagar, Near Radhey Krishna Mandir, Begumpur, Opp. Rohini Sec-22",
        "addressLocality": "New Delhi",
        "postalCode": "110086",
        "addressRegion": "DL",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 28.7208,
        "longitude": 77.0694
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "00:00",
        "closes": "23:59"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "1480",
        "bestRating": "5",
        "worstRating": "1"
      }
    }
    </script>

    <!-- Font Awesome 6 (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts: Poppins & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime(__DIR__ . '/css/style.css'); ?>">
    <link rel="stylesheet" href="css/destination.css?v=<?php echo filemtime(__DIR__ . '/css/destination.css'); ?>">
    <link rel="stylesheet" href="css/pro.css?v=<?php echo filemtime(__DIR__ . '/css/pro.css'); ?>">
<?php if (!empty($extra_css)) foreach ((array) $extra_css as $css_file): ?>
    <link rel="stylesheet" href="<?php echo $css_file; ?>?v=<?php echo filemtime(__DIR__ . '/' . $css_file); ?>">
<?php endforeach; ?>
</head>
<body>
    <!-- Floating Action Buttons -->
    <div class="floating-buttons-container">
        <a href="https://wa.me/917290885949?text=Hi,%20I%20want%20to%20inquire%20about%20booking%20a%20luxury%20Force%20Urbania%20in%20Delhi." target="_blank" class="floating-btn floating-whatsapp" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span class="btn-tooltip">Chat on WhatsApp</span>
        </a>
        <a href="tel:+917290885949" class="floating-btn floating-call" title="Call Us Now">
            <i class="fas fa-phone-alt"></i>
            <span class="btn-tooltip">Call +91 7290885949</span>
        </a>
    </div>

    <!-- Top Announcement Bar -->
    <div class="top-announcement-bar">
        <div class="container top-bar-content">
            <div class="top-bar-left">
                <span><i class="fas fa-star" style="color: #D4AF37;"></i> <strong>4.9/5 Rating</strong> (1,480+ Google Reviews)</span>
                <span class="hide-mobile"><i class="fas fa-shield-halved" style="color: #10b981;"></i> Verified Chauffeurs & Sanitized Fleet</span>
            </div>
            <div class="top-bar-right">
                <a href="tel:+917290885949"><i class="fas fa-phone-volume"></i> 24/7 Support: <strong>+91 7290885949</strong></a>
                <a href="mailto:rentonurbania@gmail.com" class="hide-mobile"><i class="fas fa-envelope"></i> rentonurbania@gmail.com</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">
            <div class="logo">
                <a href="index.php" class="logo-link">
                    <span class="logo-icon"><i class="fas fa-van-shuttle"></i></span>
                    <span class="logo-text">Urbania <span class="logo-accent">on Rent Delhi</span></span>
                </a>
            </div>
            
            <!-- Navigation Container (Desktop & Mobile Drawer) -->
            <nav class="nav-container" id="navContainer">
                <div class="mobile-nav-header">
                    <div class="mobile-logo">
                        <span class="logo-icon"><i class="fas fa-van-shuttle"></i></span>
                        <span class="logo-text">Urbania <span class="logo-accent">Delhi</span></span>
                    </div>
                    <button class="mobile-nav-close" id="navClose" aria-label="Close Menu">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>><i class="fas fa-home mobile-nav-icon"></i> Home</a></li>
                    <li><a href="about.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'class="active"' : ''; ?>><i class="fas fa-info-circle mobile-nav-icon"></i> About</a></li>
                    <li><a href="fleet.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'fleet.php') ? 'class="active"' : ''; ?>><i class="fas fa-van-shuttle mobile-nav-icon"></i> Fleet</a></li>
                    <li><a href="destinations.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'destinations.php' || strpos(basename($_SERVER['PHP_SELF']), 'delhi-to-') === 0) ? 'class="active"' : ''; ?>><i class="fas fa-map-marked-alt mobile-nav-icon"></i> Destinations</a></li>
                    <li><a href="services.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'class="active"' : ''; ?>><i class="fas fa-cogs mobile-nav-icon"></i> Services</a></li>
                    <li><a href="blogs.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'blogs.php' || strpos(basename($_SERVER['PHP_SELF']), 'blog-') === 0) ? 'class="active"' : ''; ?>><i class="fas fa-newspaper mobile-nav-icon"></i> Blogs</a></li>
                    <li><a href="testimonials.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'testimonials.php') ? 'class="active"' : ''; ?>><i class="fas fa-star mobile-nav-icon"></i> Reviews</a></li>
                    <li><a href="contact.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'class="active"' : ''; ?>><i class="fas fa-envelope mobile-nav-icon"></i> Contact</a></li>
                </ul>

                <div class="mobile-nav-footer">
                    <a href="contact.php" class="btn-mobile-book"><i class="fas fa-calendar-check"></i> Book Urbania Now</a>
                    <a href="tel:+917290885949" class="btn-mobile-phone"><i class="fas fa-phone-alt"></i> Call +91 7290885949</a>
                </div>
            </nav>

            <!-- Backdrop Overlay for Mobile Navigation -->
            <div class="mobile-nav-overlay" id="navOverlay"></div>

            <div class="header-action">
                <a href="tel:+917290885949" class="btn-header-call"><i class="fas fa-phone-alt"></i> <span>+91 7290885949</span></a>
                <a href="contact.php" class="btn-header-cta"><i class="fas fa-calendar-check"></i> <span>Book Now</span></a>
                <div class="hamburger" id="hamburger" aria-label="Open Menu"><i class="fas fa-bars"></i></div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb (Not on Home Page) -->
    <?php if (basename($_SERVER['PHP_SELF']) != 'index.php' && empty($hide_breadcrumb)) : ?>
    <div class="page-breadcrumb">
        <div class="container">
            <a href="index.php" class="breadcrumb-link"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <?php if (strpos(basename($_SERVER['PHP_SELF']), 'blog-') === 0): ?>
            <a href="blogs.php" class="breadcrumb-link">Blogs</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <?php endif; ?>
            <span class="breadcrumb-current"><?php 
                $page_name = basename($_SERVER['PHP_SELF'], ".php");
                $page_name = str_replace('-', ' ', $page_name);
                echo ucwords($page_name);
            ?></span>
        </div>
    </div>
    <?php endif; ?>