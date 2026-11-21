# Urbania on Rent Delhi

Website of **urbaniaonrentdelhi.co.in**: Force Urbania on rent in Delhi (PHP, no database).

## Run locally
Needs PHP 8+.

```
php -S localhost:8003
```

Open http://localhost:8003

## Main parts
- `index.php`, `about.php`, `fleet.php`, `contact.php`, `blogs.php`: main pages
- `header.php`, `footer.php`, `includes/`: shared layout and data (`includes/site-data.php` has the fleet, prices and blog list)
- `blog-*.php`: travel guides (layout in `includes/blog-post.php`)
- `route.php` + `delhi-to-*-urbania*.php`: destination pages
- `sitemap*.xml`, `robots.txt`: SEO
- `images/`: photos (credits in `includes/image-credits.json`, shown on `image-credits.php`)
