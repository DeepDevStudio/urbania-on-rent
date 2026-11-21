import json
import datetime
import os
import glob

with open('destinations_dataset.json', 'r', encoding='utf-8') as f:
    destinations = json.load(f)

today = datetime.datetime.now().strftime('%Y-%m-%d')
base_url = "https://urbaniaonrentdelhi.co.in"

# 1. Generate sitemap-destinations.xml
dest_xml = ['<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']

for d in destinations:
    slug = d['slug']
    url = f"{base_url}/{slug}"  # extensionless, matches the page canonical
    dest_xml.append(f"""  <url>
    <loc>{url}</loc>
    <lastmod>{today}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>""")

dest_xml.append('</urlset>')

with open('sitemap-destinations.xml', 'w', encoding='utf-8') as f:
    f.write("\n".join(dest_xml))
print(f"Generated sitemap-destinations.xml with {len(destinations)} destination URLs")

# 2. Generate sitemap-pages.xml
core_pages = [
    ('', '1.0', 'daily'),
    ('destinations.php', '0.9', 'daily'),
    ('fleet.php', '0.9', 'weekly'),
    ('services.php', '0.9', 'weekly'),
    ('force-urbania-normal-on-rent-delhi.php', '0.9', 'weekly'),
    ('force-urbania-luxury-maharaja-on-rent-delhi.php', '0.9', 'weekly'),
    ('9-seater-urbania-maharaja-delhi.php', '0.9', 'weekly'),
    ('12-seater-urbania-luxury-delhi.php', '0.9', 'weekly'),
    ('16-seater-urbania-normal-delhi.php', '0.9', 'weekly'),
    ('urbania-on-rent-gurgaon.php', '0.9', 'weekly'),
    ('urbania-on-rent-noida.php', '0.9', 'weekly'),
    ('urbania-for-wedding-delhi.php', '0.9', 'weekly'),
    ('urbania-for-corporate-delhi-ncr.php', '0.9', 'weekly'),
    ('about.php', '0.8', 'monthly'),
    ('testimonials.php', '0.8', 'weekly'),
    ('contact.php', '0.9', 'monthly'),
    ('char-dham-urbania-package.php', '0.8', 'weekly'),
    ('golden-triangle-urbania-package.php', '0.8', 'weekly'),
    ('himachal-urbania-package.php', '0.8', 'weekly'),
    ('kashmir-urbania-package.php', '0.8', 'weekly'),
    ('leh-ladakh-urbania-package.php', '0.8', 'weekly'),
    ('pilgrimage-urbania-package.php', '0.8', 'weekly'),
    ('rajasthan-urbania-package.php', '0.8', 'weekly'),
    ('uttarakhand-urbania-package.php', '0.8', 'weekly'),
    ('wildlife-urbania-package.php', '0.8', 'weekly'),
    ('image-credits.php', '0.3', 'monthly')
]

# Hand-built full destination pages (delhi-to-<city>-urbania.php)
full_route_pages = sorted(glob.glob('delhi-to-*-urbania.php'))
core_pages += [(fp, '0.9', 'weekly') for fp in full_route_pages]

pages_xml = ['<?xml version="1.0" encoding="UTF-8"?>',
             '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']

for page, prio, freq in core_pages:
    url = f"{base_url}/{page}"
    pages_xml.append(f"""  <url>
    <loc>{url}</loc>
    <lastmod>{today}</lastmod>
    <changefreq>{freq}</changefreq>
    <priority>{prio}</priority>
  </url>""")

pages_xml.append('</urlset>')

with open('sitemap-pages.xml', 'w', encoding='utf-8') as f:
    f.write("\n".join(pages_xml))
print(f"Generated sitemap-pages.xml with {len(core_pages)} core pages")

# 3. Generate sitemap-blogs.xml
blog_pages = [
    'blogs.php',
    'blog-delhi-to-agra.php',
    'blog-delhi-to-amritsar.php',
    'blog-delhi-to-chardham.php',
    'blog-delhi-to-haridwar.php',
    'blog-delhi-to-jaipur.php',
    'blog-delhi-to-manali.php',
    'blog-delhi-to-mussoorie.php',
    'blog-delhi-to-nainital.php',
    'blog-delhi-to-rishikesh.php',
    'blog-delhi-to-shimla.php',
    'blog-delhi-to-udaipur.php',
    'blog-delhi-to-varanasi.php'
]

blogs_xml = ['<?xml version="1.0" encoding="UTF-8"?>',
             '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']

for bp in blog_pages:
    url = f"{base_url}/{bp}"
    blogs_xml.append(f"""  <url>
    <loc>{url}</loc>
    <lastmod>{today}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>""")

blogs_xml.append('</urlset>')

with open('sitemap-blogs.xml', 'w', encoding='utf-8') as f:
    f.write("\n".join(blogs_xml))
print(f"Generated sitemap-blogs.xml with {len(blog_pages)} blog pages")

# 4. Generate sitemap_index.xml
index_xml = f"""<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>{base_url}/sitemap-pages.xml</loc>
    <lastmod>{today}</lastmod>
  </sitemap>
  <sitemap>
    <loc>{base_url}/sitemap-destinations.xml</loc>
    <lastmod>{today}</lastmod>
  </sitemap>
  <sitemap>
    <loc>{base_url}/sitemap-blogs.xml</loc>
    <lastmod>{today}</lastmod>
  </sitemap>
</sitemapindex>"""

with open('sitemap_index.xml', 'w', encoding='utf-8') as f:
    f.write(index_xml)
print("Generated sitemap_index.xml")

# 5. Combined sitemap.xml for direct crawlers
combined_xml = ['<?xml version="1.0" encoding="UTF-8"?>',
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']

for page, prio, freq in core_pages:
    combined_xml.append(f"""  <url>
    <loc>{base_url}/{page}</loc>
    <lastmod>{today}</lastmod>
    <changefreq>{freq}</changefreq>
    <priority>{prio}</priority>
  </url>""")

for bp in blog_pages:
    combined_xml.append(f"""  <url>
    <loc>{base_url}/{bp}</loc>
    <lastmod>{today}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>""")

for d in destinations:
    combined_xml.append(f"""  <url>
    <loc>{base_url}/{d['slug']}.php</loc>
    <lastmod>{today}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>""")

combined_xml.append('</urlset>')

with open('sitemap.xml', 'w', encoding='utf-8') as f:
    f.write("\n".join(combined_xml))
print(f"Generated complete sitemap.xml with {len(core_pages) + len(blog_pages) + len(destinations)} URLs")

# 6. Update robots.txt - welcome search engines and AI crawlers, block only internal files
crawlers = [
    # Search engines
    'Googlebot', 'Googlebot-Image', 'Bingbot', 'Slurp', 'DuckDuckBot', 'YandexBot',
    'Baiduspider', 'Applebot',
    # AI assistants and AI search
    'ClaudeBot', 'Claude-User', 'Claude-SearchBot', 'anthropic-ai',
    'GPTBot', 'OAI-SearchBot', 'ChatGPT-User',
    'Google-Extended', 'Applebot-Extended',
    'PerplexityBot', 'Perplexity-User',
    'meta-externalagent', 'Amazonbot', 'DuckAssistBot', 'MistralAI-User',
    'cohere-ai', 'CCBot',
    # Everyone else
    '*',
]
disallow = [
    '/includes/', '/config/', '/__pycache__/',
    '/header.php', '/footer.php', '/route.php',
    '/add_urbania_images.php', '/cleanup_css.php', '/generate_reviews.php',
    '/replace_toyota.php', '/theme_update.php', '/update_pages.php',
    '/update_seo_keywords.php', '/update_whatsapp.php',
    '/*.py$', '/*.json$', '/innovacrysta_',
]
robots_lines = [f"# robots.txt for {base_url}",
                "# All search engines and AI crawlers are welcome to crawl every public page.",
                "# Only internal includes, maintenance scripts and data files are blocked.",
                ""]
robots_lines += [f"User-agent: {ua}" for ua in crawlers]
# Disallow first so first-match parsers agree with Google's longest-match rule
robots_lines += [f"Disallow: {d}" for d in disallow]
robots_lines += ["Allow: /llms.txt", "Allow: /images/", "Allow: /css/", "Allow: /"]
robots_lines += ["", "# Sitemaps",
                 f"Sitemap: {base_url}/sitemap_index.xml",
                 f"Sitemap: {base_url}/sitemap.xml", ""]

with open('robots.txt', 'w', encoding='utf-8') as f:
    f.write("\n".join(robots_lines))
print("Updated robots.txt")

# 7. llms.txt - plain summary of the site for AI assistants (https://llmstxt.org)
def page_title(fname):
    return fname.replace('.php', '').replace('-', ' ').title().replace('Urbania', 'Urbania')

popular = [d for d in destinations if str(d.get('is_popular')) == 'True']
llms = [
    "# Urbania on Rent Delhi",
    "",
    "> Force Urbania van rental in Delhi NCR with driver: 9, 12 and 16 seater luxury Urbania "
    "for outstation trips, tours, weddings, airport transfers and corporate travel. "
    "Fares from Rs 40/km to Rs 45/km. 611 destination routes from Delhi.",
    "",
    "- Phone / WhatsApp: +91 72908 85949",
    "- Email: rentonurbania@gmail.com",
    "- Address: B-26, Rajeev Nagar, Near Radhey Krishna Mandir, Begumpur, New Delhi - 110086 (Opp. Rohini Sec-22)",
    "",
    "## Main pages",
    f"- [Home]({base_url}/): Urbania on rent in Delhi - overview, fleet and booking",
    f"- [Fleet and fares]({base_url}/fleet.php): 9, 12 and 16 seater Urbania models with per-km rates",
    f"- [Services]({base_url}/services.php): outstation, local, wedding, airport and corporate Urbania hire",
    f"- [All destinations]({base_url}/destinations.php): all 611 routes from Delhi",
    f"- [About]({base_url}/about.php)",
    f"- [Testimonials]({base_url}/testimonials.php)",
    f"- [Contact and booking]({base_url}/contact.php)",
    "",
    "## Tour packages",
]
llms += [f"- [{page_title(p)}]({base_url}/{p})" for p, _, _ in core_pages if p.endswith('-package.php')]
llms += ["", "## Popular routes from Delhi"]
llms += [f"- [{d['meta_title'].split(' | ')[0]}]({base_url}/{d['slug']}.php): {d['distance_str']}, {d['estimated_travel_time']}"
         for d in popular]
llms += [f"- [{page_title(fp)}]({base_url}/{fp})" for fp in full_route_pages]
llms += ["", "## Travel guides"]
llms += [f"- [{page_title(bp)}]({base_url}/{bp})" for bp in blog_pages]
llms += ["", "## Optional",
         f"- [Full sitemap]({base_url}/sitemap.xml): every page on the site", ""]

with open('llms.txt', 'w', encoding='utf-8') as f:
    f.write("\n".join(llms))
print(f"Generated llms.txt")
