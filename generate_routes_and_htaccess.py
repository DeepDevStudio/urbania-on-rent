import json
import os

with open('destinations_dataset.json', 'r', encoding='utf-8') as f:
    destinations = json.load(f)

print(f"Generating stubs for {len(destinations)} destination routes...")

stub_content = """<?php
$_GET['slug'] = basename(__FILE__, '.php');
require __DIR__ . '/route.php';
"""

created_count = 0
for d in destinations:
    slug = d['slug'] # e.g. delhi-to-abhaneri-urbania-on-rent
    filename = f"{slug}.php"
    with open(filename, 'w', encoding='utf-8') as f:
        f.write(stub_content)
    created_count += 1

print(f"Successfully generated {created_count} route stub PHP files!")

# Write .htaccess
htaccess_content = """# Apache Configuration for Urbania on Rent Delhi
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Exclude existing files and directories
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L]

    # Clean destinations hub URL
    RewriteRule ^destinations/?$ destinations.php [L,QSA]

    # Clean destination route URLs (extensionless)
    RewriteRule ^(delhi-to-[a-zA-Z0-9\-]+)/?$ route.php?slug=$1 [L,QSA]
</IfModule>

# Browser Caching for Performance
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/avif "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Frame-Options "SAMEORIGIN"
</IfModule>
"""

with open('.htaccess', 'w', encoding='utf-8') as f:
    f.write(htaccess_content)

print("Created .htaccess successfully!")
