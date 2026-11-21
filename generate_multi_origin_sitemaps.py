import json
import xml.etree.ElementTree as ET
from datetime import datetime

with open('includes/destinations_multi_origin.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

origins = ['delhi', 'gurgaon', 'noida', 'ghaziabad', 'faridabad']
routes_by_origin = data.get('routes_by_origin', {})
base_url = "https://urbaniaonrentdelhi.co.in"
today_str = datetime.now().strftime("%Y-%m-%d")

total_urls = 0
all_route_urls = []

# Generate origin-specific sitemaps
for orig in origins:
    routes = routes_by_origin.get(orig, [])
    filename = f"sitemap-destinations-{orig}.xml"
    
    xml_lines = ['<?xml version="1.0" encoding="UTF-8"?>', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']
    for r in routes:
        slug = r['slug']
        url = f"{base_url}/{slug}"  # extensionless, matches the page canonical
        all_route_urls.append(url)
        xml_lines.append(f"  <url>\n    <loc>{url}</loc>\n    <lastmod>{today_str}</lastmod>\n    <changefreq>weekly</changefreq>\n    <priority>0.8</priority>\n  </url>")
    xml_lines.append('</urlset>')
    
    with open(filename, 'w', encoding='utf-8') as f_out:
        f_out.write("\n".join(xml_lines) + "\n")
    print(f"Generated {filename} with {len(routes)} routes.")
    total_urls += len(routes)

# Update master sitemap-destinations.xml with all 3,055 routes
master_lines = ['<?xml version="1.0" encoding="UTF-8"?>', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']
for url in all_route_urls:
    master_lines.append(f"  <url>\n    <loc>{url}</loc>\n    <lastmod>{today_str}</lastmod>\n    <changefreq>weekly</changefreq>\n    <priority>0.8</priority>\n  </url>")
master_lines.append('</urlset>')
with open("sitemap-destinations.xml", "w", encoding="utf-8") as f_out:
    f_out.write("\n".join(master_lines) + "\n")
print(f"Updated master sitemap-destinations.xml with {len(all_route_urls)} routes.")

# Update sitemap_index.xml
sitemap_index_lines = [
    '<?xml version="1.0" encoding="UTF-8"?>',
    '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-pages.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-destinations-delhi.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-destinations-gurgaon.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-destinations-noida.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-destinations-ghaziabad.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-destinations-faridabad.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    f'  <sitemap>\n    <loc>{base_url}/sitemap-blogs.xml</loc>\n    <lastmod>{today_str}</lastmod>\n  </sitemap>',
    '</sitemapindex>'
]
with open("sitemap_index.xml", "w", encoding="utf-8") as f_out:
    f_out.write("\n".join(sitemap_index_lines) + "\n")
print("Updated sitemap_index.xml.")

# Also update sitemap-pages.xml to include destination hubs if not already present
with open("sitemap-pages.xml", "r", encoding="utf-8") as f_pages:
    pages_content = f_pages.read()

new_hub_urls = [
    f"{base_url}/destinations/gurgaon",
    f"{base_url}/destinations/noida",
    f"{base_url}/destinations/ghaziabad",
    f"{base_url}/destinations/faridabad"
]
hub_xml_snippets = []
for h_url in new_hub_urls:
    if h_url not in pages_content:
        hub_xml_snippets.append(f"  <url>\n    <loc>{h_url}</loc>\n    <lastmod>{today_str}</lastmod>\n    <changefreq>daily</changefreq>\n    <priority>0.9</priority>\n  </url>")

if hub_xml_snippets:
    pages_content = pages_content.replace('</urlset>', "\n".join(hub_xml_snippets) + "\n</urlset>")
    with open("sitemap-pages.xml", "w", encoding="utf-8") as f_pages:
        f_pages.write(pages_content)
    print(f"Added {len(hub_xml_snippets)} destination hubs to sitemap-pages.xml")

print(f"ALL SITEMAPS GENERATED SUCCESSFULLY. Total routes in sitemaps: {total_urls}")
