<?php
// Shared layout for blog-*.php articles.
// Expects: $post_slug, $post_heading, $post_subtitle, $post_body (HTML), $page_title, $page_description.
require_once __DIR__ . '/site-data.php';

$post = $blogs[$post_slug];
$dest = $post['dest'];
$dest_lc = strtolower($dest);

$page_keywords = "delhi to {$dest_lc} road trip, delhi to {$dest_lc} by road, delhi to {$dest_lc} urbania, force urbania on rent delhi to {$dest_lc}, {$dest_lc} trip from delhi, luxury force urbania on rent in delhi, urbania with driver for {$dest_lc}";
$extra_css = ['css/home.css', 'css/pages.css'];
$hide_breadcrumb = true;
$og_type = 'article';
$og_image = $post['img'];

// Clean the article body: drop legacy inline styles and add anchor ids for the table of contents.
$body = preg_replace('/\s+style="[^"]*"/i', '', $post_body);
$body = preg_replace('/<div>\s*(<img[^>]*>)\s*<\/div>/i', '$1', $body);
$body = preg_replace('/<img(?![^>]*\bloading=)/i', '<img loading="lazy"', $body);
$toc = [];
$body = preg_replace_callback('/<h([23])>(.*?)<\/h\1>/is', function ($m) use (&$toc) {
    $text = trim(strip_tags($m[2]));
    $id = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($text)), '-');
    if ($m[1] === '3') {
        $toc[] = ['id' => $id, 'text' => $text];
    }
    return '<h' . $m[1] . ' id="' . $id . '">' . $m[2] . '</h' . $m[1] . '>';
}, $body);

$words = str_word_count(strip_tags($body));

// Related guides: same category first, then the rest.
$related = array_filter($blogs, function ($b) use ($post) { return $b['slug'] !== $post['slug'] && $b['cat'] === $post['cat']; });
$related = array_slice(array_merge($related, array_filter($blogs, function ($b) use ($post) { return $b['slug'] !== $post['slug'] && $b['cat'] !== $post['cat']; })), 0, 3);

$heading_html = preg_replace('/<span>(.*?)<\/span>/', '<em>$1</em>', $post_heading);

include __DIR__ . '/../header.php';
?>
<main class="hp">

    <section class="pg-hero ar-hero" style="background-image:url('<?php echo $post['img']; ?>')">
        <div class="container">
            <div class="pg-hero-copy" style="max-width:860px">
                <?php render_crumbs([['Travel Guides', 'blogs.php'], [$post['title'], null]]); ?>
                <span class="hp-eyebrow"><i class="fas fa-compass"></i> <?php echo htmlspecialchars($post['tag']); ?> · <?php echo htmlspecialchars($post['region']); ?></span>
                <h1><?php echo $heading_html; ?></h1>
                <p class="pg-lead"><?php echo $post_subtitle; ?></p>
                <ul class="pg-hero-meta">
                    <li><i class="fas fa-road"></i> <?php echo $post['dist']; ?> from Delhi</li>
                    <li><i class="far fa-clock"></i> <?php echo $post['time']; ?> drive</li>
                    <li><i class="fas fa-book-open"></i> <?php echo $post['read']; ?> min read</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="hp-section">
        <div class="container ar-layout">
            <article class="ar-content">
                <?php echo $body; ?>

                <div class="ar-inline-cta">
                    <div>
                        <h3>Book a Delhi to <?php echo htmlspecialchars($dest); ?> Urbania</h3>
                        <p>Luxury 9, 12 &amp; 16 seater Urbania with driver — fuel and tolls included.</p>
                    </div>
                    <a href="<?php echo wa_link('Hi, I want to book an Urbania for a Delhi to ' . $dest . ' trip.'); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-gold"><i class="fab fa-whatsapp"></i> Get a quote</a>
                </div>
            </article>

            <aside class="ar-side">
                <div class="ar-box ar-book">
                    <h4>Plan this trip</h4>
                    <strong>Delhi to <?php echo htmlspecialchars($dest); ?> by luxury Urbania</strong>
                    <p>Chauffeur-driven Force Urbania from ₹40/km. Doorstep pickup across Delhi NCR.</p>
                    <a href="<?php echo wa_link('Hi, I want to book an Urbania for a Delhi to ' . $dest . ' trip.'); ?>" target="_blank" rel="noopener" class="hp-btn hp-btn-gold"><i class="fab fa-whatsapp"></i> WhatsApp for quote</a>
                    <a href="<?php echo $post['route']; ?>" class="hp-btn hp-btn-glass">View <?php echo htmlspecialchars($dest); ?> package</a>
                </div>
                <?php if (count($toc) > 1): ?>
                <div class="ar-box">
                    <h4>In this guide</h4>
                    <ol class="ar-toc">
                        <?php foreach ($toc as $t): ?>
                            <li><a href="#<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['text']); ?></a></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <?php endif; ?>
                <div class="ar-box">
                    <h4>Trip facts</h4>
                    <ul class="ar-facts">
                        <li><span>Distance</span><strong><?php echo $post['dist']; ?></strong></li>
                        <li><span>Drive time</span><strong><?php echo $post['time']; ?></strong></li>
                        <li><span>Region</span><strong><?php echo $post['region']; ?></strong></li>
                        <li><span>Urbania from</span><strong>₹40/km</strong></li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>

    <section class="hp-section hp-soft">
        <div class="container">
            <div class="hp-head hp-head-split reveal">
                <div>
                    <span class="hp-kicker">Keep Exploring</span>
                    <h2>More road trips from Delhi</h2>
                </div>
                <a href="blogs.php" class="hp-link">All travel guides <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="hp-blogs">
                <?php foreach ($related as $b): ?>
                <a href="<?php echo $b['url']; ?>" class="hp-blog reveal">
                    <div class="hp-blog-media"><img src="<?php echo $b['img']; ?>" alt="<?php echo htmlspecialchars($b['alt']); ?>" loading="lazy"><span><?php echo $b['dist']; ?> · <?php echo $b['time']; ?></span></div>
                    <h3><?php echo $b['title']; ?></h3>
                    <p><?php echo $b['excerpt']; ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    <?php
    echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post['title'],
        'description' => $page_description,
        'image' => $site_url . '/' . $post['img'],
        'url' => $site_url . '/' . $post['url'],
        'wordCount' => $words,
        'keywords' => $page_keywords,
        'author' => ['@type' => 'Organization', 'name' => 'Urbania on Rent Delhi', 'url' => $site_url],
        'publisher' => ['@type' => 'Organization', 'name' => 'Urbania on Rent Delhi', 'logo' => ['@type' => 'ImageObject', 'url' => $site_url . '/images/urbania-1.webp']],
        'mainEntityOfPage' => $site_url . '/' . $post['url'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    ?>
    </script>
</main>

<script>
    (function () {
        var links = document.querySelectorAll('.ar-toc a');
        if (!links.length || !('IntersectionObserver' in window)) return;
        var map = {};
        links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting && map[e.target.id]) {
                    links.forEach(function (a) { a.classList.remove('is-active'); });
                    map[e.target.id].classList.add('is-active');
                }
            });
        }, { rootMargin: '-100px 0px -70% 0px' });
        Object.keys(map).forEach(function (id) { var el = document.getElementById(id); if (el) io.observe(el); });
    })();
</script>
<?php include __DIR__ . '/../footer.php'; ?>
