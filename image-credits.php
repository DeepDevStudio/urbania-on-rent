<?php
require __DIR__ . '/includes/site-data.php';

$page_title = 'Photo Credits | Urbania on Rent Delhi';
$page_description = 'Credits and licences for the destination photos used on Urbania on Rent Delhi, sourced from Wikimedia Commons.';
$page_keywords = 'urbania on rent delhi photo credits, wikimedia commons';
$extra_css = ['css/home.css', 'css/pages.css'];
$hide_breadcrumb = true;
include 'header.php';

$credits = json_decode(file_get_contents(__DIR__ . '/includes/image-credits.json'), true) ?: [];
?>
<main class="hp">

    <section class="pg-hero">
        <div class="container">
            <div class="pg-hero-copy">
                <?php render_crumbs([['Photo Credits', null]]); ?>
                <h1>Photo <em>credits</em></h1>
                <p class="pg-lead">The destination photos on this site come from <a href="https://commons.wikimedia.org/" target="_blank" rel="noopener">Wikimedia Commons</a> and are used under their free licences. Thank you to every photographer listed below.</p>
            </div>
        </div>
    </section>

    <section style="padding: 40px 0 70px;">
        <div class="container">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.92rem;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px 8px;">Photo</th>
                            <th style="padding: 10px 8px;">Author</th>
                            <th style="padding: 10px 8px;">Licence</th>
                            <th style="padding: 10px 8px;">Used on</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($credits as $c): ?>
                        <tr style="border-bottom: 1px solid #eef2f7; vertical-align: top;">
                            <td style="padding: 8px;"><a href="<?php echo htmlspecialchars($c['page']); ?>" target="_blank" rel="noopener nofollow"><?php echo htmlspecialchars($c['subject']); ?></a></td>
                            <td style="padding: 8px;"><?php echo htmlspecialchars($c['artist']); ?></td>
                            <td style="padding: 8px;">
                                <?php if (!empty($c['license_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($c['license_url']); ?>" target="_blank" rel="noopener nofollow"><?php echo htmlspecialchars($c['license']); ?></a>
                                <?php else: echo htmlspecialchars($c['license']); endif; ?>
                            </td>
                            <td style="padding: 8px;">
                                <?php foreach ($c['used_on'] as $i => $u): echo $i ? ', ' : ''; ?>
                                    <?php if ($u['url']): ?><a href="<?php echo htmlspecialchars($u['url']); ?>"><?php echo htmlspecialchars($u['title']); ?></a><?php else: echo htmlspecialchars($u['title']); endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>
<?php include 'footer.php'; ?>
