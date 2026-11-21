<?php
// City-specific SEO keyword section shared by route.php and the hand-built delhi-to-*-urbania.php pages.
// Expects $seo_city (required); $seo_origin, $seo_state, $seo_distance, $seo_time and $seo_category are optional.
$c             = htmlspecialchars($seo_city);
$origin_clean  = !empty($seo_origin) ? $seo_origin : 'Delhi';
$origin        = htmlspecialchars($origin_clean);
$state         = !empty($seo_state) ? htmlspecialchars($seo_state) : '';
$category      = isset($seo_category) ? strtolower($seo_category) : '';
$is_religious  = (bool) preg_match('/religious|pilgrim/', $category)
    || preg_match('/kedarnath|badrinath|char ?dham|amarnath|haridwar|rishikesh|vrindavan|mathura|ayodhya|varanasi|vaishno|katra|amritsar|ajmer|pushkar|khatu|salasar|gangotri|yamunotri|kainchi/i', $seo_city);
$phone_display = isset($site_phone_display) ? $site_phone_display : '+91 72908 85949';
$phone_tel     = isset($site_phone_tel) ? $site_phone_tel : '+917290885949';

$seo_tags = [
    "$origin_clean to $c Urbania",
    "$origin_clean to $c Urbania on Rent",
    "Force Urbania on Rent $origin_clean to $c",
    "12 Seater Force Urbania on Rent $origin_clean to $c",
    "16 Seater Force Urbania on Rent $origin_clean to $c",
    "Luxury Urbania for $c",
    "Force Urbania Hire $origin_clean to $c",
    "$c Urbania Hire from $origin_clean",
    "Urbania Booking $origin_clean to $c",
    "Urbania for $c Family Trip",
    "Urbania for $c Group Tour",
    $is_religious ? "Urbania for $c Religious Tour" : "Urbania for $c Corporate Tour",
    "Force Urbania on Rent in $origin_clean",
    'Force Urbania on Rent in Delhi NCR',
    'Urbania on Rent Near Me',
];
?>
    <!-- City SEO Keyword Section -->
    <section class="seo-highlights-section" style="padding: 50px 0; background: #ffffff; border-top: 1px solid #e2e8f0;">
        <div class="container">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <i class="fas fa-certificate" style="color: #D4AF37; font-size: 1.3rem;"></i>
                    <h2 style="font-size: 1.4rem; color: #0f172a; margin: 0; font-weight: 800;"><?php echo $origin; ?> to <?php echo $c; ?> Urbania on Rent – 12 &amp; 16 Seater Luxury Urbania</h2>
                </div>
                <p style="color: #475569; font-size: 0.97rem; line-height: 1.8; margin-bottom: 14px;">
                    Looking for a <strong><?php echo $origin; ?> to <?php echo $c; ?> Urbania on rent</strong>? Urbania on Rent offers <strong>12 seater Urbania on rent</strong>, <strong>16 seater Urbania on rent</strong> and 9 seater <strong>luxury Force Urbania on rent in <?php echo $origin; ?></strong> for your <?php echo $c; ?><?php echo $state ? ' (' . $state . ')' : ''; ?> trip<?php if (!empty($seo_distance)): ?> — about <?php echo htmlspecialchars($seo_distance); ?><?php echo !empty($seo_time) ? ' and ' . htmlspecialchars($seo_time) . ' by road' : ''; ?><?php endif; ?>. Every <strong>Force Urbania on rent <?php echo $origin; ?></strong> booking comes as an <strong>Urbania with driver on rent</strong>, with pushback seats, full AC, large luggage space and transparent per-km fares for <strong>Urbania for outstation travel</strong>.
                </p>
                <p style="color: #475569; font-size: 0.97rem; line-height: 1.8; margin-bottom: 14px;">
                    Book an <strong>Urbania for family trip</strong> to <?php echo $c; ?>, an <strong>Urbania for group tour</strong> with friends, an <strong>Urbania for corporate tour</strong> or offsite, or an <strong>Urbania for wedding</strong> guests travelling to <?php echo $c; ?>.<?php if ($is_religious): ?> Our elder-friendly <strong>Urbania for religious tour</strong> bookings are popular for <?php echo $c; ?> darshan and yatra groups.<?php endif; ?> We also handle <strong>Urbania for airport transfer</strong> from IGI Airport and NCR pickups straight to <?php echo $c; ?>.
                </p>
                <p style="color: #475569; font-size: 0.97rem; line-height: 1.8; margin-bottom: 20px;">
                    Doorstep pickup is available across <?php echo $origin; ?> and entire Delhi NCR — <strong>Urbania on rent in Gurgaon</strong>, <strong>Urbania on rent in Noida</strong>, <strong>Urbania on rent in Ghaziabad</strong> and <strong>Urbania on rent in Faridabad</strong>. Searching for <strong>Urbania on rent near me</strong>? Call <a href="tel:<?php echo $phone_tel; ?>" style="color: #b08d27; font-weight: 700;"><?php echo $phone_display; ?></a> for instant <strong>Urbania booking <?php echo $origin; ?> to <?php echo $c; ?></strong> and the best <strong>Urbania rental in <?php echo $origin; ?></strong> rates.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <?php foreach ($seo_tags as $tag): ?>
                    <span class="seo-badge-tag"><i class="fas fa-tag"></i> <strong><?php echo $tag; ?></strong></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
