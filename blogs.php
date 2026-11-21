<?php
require __DIR__ . '/includes/site-data.php';

$page_title = 'Road Trip Guides from Delhi | Travel Blog | Urbania on Rent Delhi';
$page_description = 'Road trip guides from Delhi to Jaipur, Agra, Manali, Shimla, Rishikesh, Haridwar, Amritsar, Udaipur, Nainital, Mussoorie, Varanasi & Char Dham — routes, stops and tips for travelling by luxury Urbania on rent.';
$page_keywords = 'delhi road trip guide, weekend getaways from delhi, delhi to jaipur by road, delhi to manali road trip, char dham yatra from delhi, urbania on rent for outstation, luxury urbania on rent in delhi, urbania travel blog';
$extra_css = ['css/home.css', 'css/pages.css'];
$hide_breadcrumb = true;
include 'header.php';

$all_blogs = array_values($blogs);
$featured = $all_blogs[0];
$rest = array_slice($all_blogs, 1);
$counts = array_count_values(array_column($rest, 'cat'));
?>
<main class="hp">

    <section class="pg-hero pg-hero-center" style="background-image:url('images/blog_delhi_manali.jpg')">
        <div class="container">
            <div class="pg-hero-copy">
                <?php render_crumbs([['Travel Guides', null]]); ?>
                <span class="hp-eyebrow"><i class="fas fa-compass"></i> Travel Guides</span>
                <h1>Road trips from Delhi, <em>done in style</em></h1>
                <p class="pg-lead">Routes, must-see stops and insider tips for North India's best road trips — and how to travel them comfortably in a luxury Urbania on rent.</p>
            </div>
        </div>
    </section>

    <section class="hp-section">
        <div class="container">

            <!-- Featured -->
            <article class="bl-featured reveal">
                <a href="<?php echo $featured['url']; ?>" class="bl-featured-media">
                    <img src="<?php echo $featured['img']; ?>" alt="<?php echo htmlspecialchars($featured['alt']); ?>">
                </a>
                <div class="bl-featured-body">
                    <span class="hp-kicker">Featured guide</span>
                    <div class="bl-meta"><span><i class="fas fa-location-dot"></i><?php echo $featured['region']; ?></span><span><i class="fas fa-road"></i><?php echo $featured['dist']; ?> · <?php echo $featured['time']; ?></span><span><i class="far fa-clock"></i><?php echo $featured['read']; ?> min read</span></div>
                    <h2><a href="<?php echo $featured['url']; ?>"><?php echo $featured['title']; ?></a></h2>
                    <p><?php echo $featured['excerpt']; ?></p>
                    <div><a href="<?php echo $featured['url']; ?>" class="hp-btn hp-btn-gold">Read the guide <i class="fas fa-arrow-right"></i></a></div>
                </div>
            </article>

            <div class="hp-head hp-head-split reveal" style="margin-bottom:28px">
                <div>
                    <span class="hp-kicker">All Guides</span>
                    <h2>Popular road trips from Delhi</h2>
                </div>
            </div>
            <div class="pg-tabs" style="justify-content:flex-start;margin:0 0 40px">
                <button class="is-active" data-filter="all">All guides (<?php echo count($rest); ?>)</button>
                <button data-filter="hill"><i class="fas fa-mountain"></i> Hill stations (<?php echo $counts['hill'] ?? 0; ?>)</button>
                <button data-filter="heritage"><i class="fas fa-landmark"></i> Heritage &amp; royal (<?php echo $counts['heritage'] ?? 0; ?>)</button>
                <button data-filter="spiritual"><i class="fas fa-om"></i> Spiritual &amp; pilgrimage (<?php echo $counts['spiritual'] ?? 0; ?>)</button>
            </div>

            <div class="bl-grid" id="blogGrid">
                <?php foreach ($rest as $b): ?>
                <a href="<?php echo $b['url']; ?>" class="hp-blog reveal" data-category="<?php echo $b['cat']; ?>">
                    <div class="hp-blog-media">
                        <img src="<?php echo $b['img']; ?>" alt="<?php echo htmlspecialchars($b['alt']); ?>" loading="lazy">
                        <span class="hp-blog-tag"><?php echo $b['tag']; ?></span>
                        <span><?php echo $b['dist']; ?> · <?php echo $b['time']; ?></span>
                    </div>
                    <div class="bl-meta"><span><i class="fas fa-location-dot"></i><?php echo $b['region']; ?></span><span><i class="far fa-clock"></i><?php echo $b['read']; ?> min read</span></div>
                    <h3><?php echo $b['title']; ?></h3>
                    <p><?php echo $b['excerpt']; ?></p>
                    <span class="hp-blog-more">Read guide <i class="fas fa-arrow-right"></i></span>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Keyword topics -->
            <div class="bl-topics reveal">
                <h2>Popular Urbania rental searches in Delhi NCR</h2>
                <p>Planning a group trip? These are the routes and rental options travellers ask us about most.</p>
                <div class="hp-packages">
                    <a href="index.php">Urbania on rent in Delhi</a>
                    <a href="fleet.php">Luxury Urbania on rent in Delhi</a>
                    <a href="fleet.php">12 seater Urbania on rent Delhi</a>
                    <a href="fleet.php">16 seater Urbania hire Delhi</a>
                    <a href="fleet.php">9 seater Urbania Delhi</a>
                    <a href="services.php">Urbania for outstation from Delhi</a>
                    <a href="services.php">Urbania with driver in Delhi</a>
                    <a href="delhi-to-jaipur-urbania.php">Delhi to Jaipur Urbania</a>
                    <a href="delhi-to-manali-urbania.php">Delhi to Manali Urbania</a>
                    <a href="delhi-to-agra-urbania.php">Delhi to Agra Urbania</a>
                    <a href="char-dham-urbania-package.php">Char Dham Urbania package</a>
                    <a href="contact.php">Urbania booking near me</a>
                </div>
            </div>
        </div>
    </section>

    <section class="hp-section" style="padding-top:0">
        <div class="container">
            <div class="pg-cta reveal">
                <div>
                    <h2>Found your next trip? <em>Let's plan it.</em></h2>
                    <p>Tell us where you're headed — we'll suggest the right Urbania and send an all-inclusive quote.</p>
                </div>
                <div class="hp-hero-ctas">
                    <a href="contact.php" class="hp-btn hp-btn-gold"><i class="fas fa-calendar-check"></i> Get a Free Quote</a>
                    <a href="<?php echo wa_link('Hi, I read your travel guide and want to plan a trip in an Urbania.'); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-glass"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    <?php
    echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => 'Urbania on Rent Delhi Travel Guides',
        'url' => $site_url . '/blogs.php',
        'blogPost' => array_map(function ($b) use ($site_url) {
            return ['@type' => 'BlogPosting', 'headline' => $b['title'], 'url' => $site_url . '/' . $b['url'], 'image' => $site_url . '/' . $b['img']];
        }, $all_blogs),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    ?>
    </script>
</main>

<script>
    (function () {
        var tabs = document.querySelectorAll('.pg-tabs button');
        var cards = document.querySelectorAll('#blogGrid .hp-blog');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('is-active'); });
                tab.classList.add('is-active');
                var f = tab.getAttribute('data-filter');
                cards.forEach(function (c) {
                    var show = f === 'all' || c.getAttribute('data-category') === f;
                    c.classList.toggle('is-hidden', !show);
                    if (show) c.classList.add('is-in');
                });
            });
        });
    })();
</script>
<?php include 'footer.php'; ?>
