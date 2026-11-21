<?php
// Shared template for Normal / Luxury / seater / city / occasion landing pages.
// The calling page sets $lp (see force-urbania-normal-on-rent-delhi.php for the shape).
require_once __DIR__ . '/seo-blocks.php';

$page_title       = $lp['title'];
$page_description = $lp['description'];
$page_keywords    = $lp['keywords'];
$og_image         = $lp['hero_img'];
$extra_css        = ['css/home.css', 'css/pages.css'];
$hide_breadcrumb  = true;
include __DIR__ . '/../header.php';

$vehicles = $lp['vehicles'];
?>
<main class="hp">

    <section class="pg-hero" style="background-image:url('<?php echo $lp['hero_img']; ?>')">
        <div class="container">
            <div class="pg-hero-copy">
                <?php render_crumbs($lp['crumbs']); ?>
                <span class="hp-eyebrow"><i class="fas <?php echo $lp['eyebrow_icon'] ?? 'fa-van-shuttle'; ?>"></i> <?php echo $lp['eyebrow']; ?></span>
                <h1><?php echo $lp['h1']; ?></h1>
                <p class="pg-lead"><?php echo $lp['lead']; ?></p>
                <ul class="pg-hero-meta">
                    <li><i class="fas fa-user-group"></i> <?php echo implode(', ', array_column($vehicles, 'seats')); ?> seater</li>
                    <li><i class="fas fa-indian-rupee-sign"></i> From ₹<?php echo fleet_min_price($vehicles); ?>/km</li>
                    <li><i class="fas fa-location-dot"></i> Delhi NCR doorstep pickup</li>
                </ul>
                <div class="hp-hero-ctas">
                    <a href="<?php echo wa_link($lp['wa_text']); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-gold"><i class="fab fa-whatsapp"></i> Get Quote on WhatsApp</a>
                    <a href="tel:<?php echo $site_phone_tel; ?>" class="hp-btn hp-btn-glass"><i class="fas fa-phone"></i> <?php echo $site_phone_display; ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicles -->
    <section class="hp-section" id="fleet">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">Available Urbania</span>
                <h2><?php echo $lp['fleet_h2']; ?></h2>
            </div>
            <div class="hp-fleet<?php echo count($vehicles) < 3 ? ' hp-fleet-few' : ''; ?>">
                <?php foreach ($vehicles as $v) render_fleet_card($v); ?>
            </div>
        </div>
    </section>

    <!-- Rate card -->
    <section class="hp-section hp-soft" id="pricing">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker">Rate Card</span>
                <h2><?php echo $lp['rate_h2']; ?></h2>
            </div>
            <?php render_rate_table($vehicles); ?>
        </div>
    </section>

    <!-- Main content -->
    <section class="hp-section">
        <div class="container">
            <div class="hp-head reveal">
                <span class="hp-kicker"><?php echo $lp['content_kicker'] ?? 'Overview'; ?></span>
                <h2><?php echo $lp['content_h2']; ?></h2>
            </div>
            <div class="hp-seo-copy reveal">
                <?php foreach ($lp['content'] as $para): ?>
                <p><?php echo $para; ?></p>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($lp['best_for'])): ?>
            <div class="hp-seo-copy reveal">
                <h3><?php echo $lp['best_for_h3']; ?></h3>
                <ul>
                    <?php foreach ($lp['best_for'] as $b): ?>
                    <li><?php echo $b; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Normal vs Luxury -->
    <section class="hp-section hp-soft">
        <div class="container">
            <?php render_type_compare(); ?>
        </div>
    </section>

    <!-- Delhi NCR pickup areas -->
    <section class="hp-section">
        <div class="container">
            <?php render_ncr_areas(); ?>
        </div>
    </section>

    <!-- FAQ -->
    <section class="hp-section hp-soft" id="faq">
        <div class="container hp-faq-wrap">
            <div class="hp-faq-intro reveal">
                <span class="hp-kicker">FAQ</span>
                <h2><?php echo $lp['faq_h2']; ?></h2>
                <p>Still have a question? Our team is available 24/7.</p>
                <a href="tel:<?php echo $site_phone_tel; ?>" class="hp-btn hp-btn-dark"><i class="fas fa-phone"></i> <?php echo $site_phone_display; ?></a>
            </div>
            <div class="hp-faq">
                <?php foreach ($lp['faqs'] as $i => $f): ?>
                <details class="reveal" <?php echo $i === 0 ? 'open' : ''; ?>>
                    <summary><?php echo $f['q']; ?><i class="fas fa-plus"></i></summary>
                    <p><?php echo $f['a']; ?></p>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php echo faq_schema($lp['faqs']); ?>
    <?php echo fleet_offer_schema($vehicles, $lp['schema_name']); ?>

    <!-- Related pages -->
    <section class="hp-section">
        <div class="container">
            <div class="hp-packages reveal">
                <span>Related:</span>
                <?php foreach (landing_links() as $url => $label): if ($url === basename($_SERVER['PHP_SELF'])) continue; ?>
                <a href="<?php echo $url; ?>"><?php echo $label; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="hp-section">
        <div class="container">
            <div class="pg-cta reveal">
                <div>
                    <h2><?php echo $lp['cta_h2']; ?></h2>
                    <p>Share your dates, pickup point and route — we'll send an all-inclusive written quote within minutes.</p>
                </div>
                <div class="hp-hero-ctas">
                    <a href="<?php echo wa_link($lp['wa_text']); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-gold"><i class="fab fa-whatsapp"></i> Ask on WhatsApp</a>
                    <a href="tel:<?php echo $site_phone_tel; ?>" class="hp-btn hp-btn-glass"><i class="fas fa-phone"></i> Call Now</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../footer.php'; ?>
