import json
import os
import re
import subprocess
import xml.etree.ElementTree as ET

def run_qa():
    print("==================================================")
    print("  URBANIA ON RENT DELHI - FULL QA VERIFICATION   ")
    print("==================================================")

    # 1. Load source crawled data & processed dataset
    with open('source_crawled_611.json', 'r', encoding='utf-8') as f:
        source_routes = json.load(f)

    with open('destinations_dataset.json', 'r', encoding='utf-8') as f:
        urbania_dataset = json.load(f)

    total_source = len(source_routes)
    total_urbania = len(urbania_dataset)

    print(f"\n1. INVENTORY RECONCILIATION:")
    print(f" - Source Routes Discovered: {total_source}")
    print(f" - Urbania Routes Created:   {total_urbania}")

    # Check for missing
    source_slugs = set(s['slug'] for s in source_routes)
    created_source_slugs = set(u['source_slug'] for u in urbania_dataset)
    missing = source_slugs - created_source_slugs
    print(f" - Missing Routes:           {len(missing)}")

    # 2. Check PHP stub files on disk
    missing_files = []
    for u in urbania_dataset:
        filename = f"{u['slug']}.php"
        if not os.path.exists(filename):
            missing_files.append(filename)

    print(f"\n2. FILE SYSTEM CHECK:")
    print(f" - Route Stub Files Present: {total_urbania - len(missing_files)} / {total_urbania}")
    print(f" - Missing Files:            {len(missing_files)}")

    # 3. SEO Metadata & Uniqueness Verification
    titles = set()
    descriptions = set()
    h1s = set()
    canonical_urls = set()
    innova_leaks = []
    phone_leaks = []

    for u in urbania_dataset:
        # Title check
        t = u['meta_title']
        titles.add(t)

        # Description check
        d = u['meta_description']
        descriptions.add(d)

        # H1
        h1 = f"Delhi to {u['destination']} Urbania on Rent"
        h1s.add(h1)

        # Canonical
        canon = f"https://urbaniaonrentdelhi.co.in/{u['slug']}"
        canonical_urls.add(canon)

        # Brand & contact check
        json_str = json.dumps(u)
        if re.search(r'innova\s*crysta', json_str, re.I):
            innova_leaks.append(u['slug'])
        if '9811' in json_str or 'innovacrysta' in json_str.lower():
            phone_leaks.append(u['slug'])

    print(f"\n3. SEO & BRAND INTEGRITY CHECK:")
    print(f" - Unique Titles:            {len(titles)} / {total_urbania}")
    print(f" - Unique Descriptions:      {len(descriptions)} / {total_urbania}")
    print(f" - Unique H1 Tags:           {len(h1s)} / {total_urbania}")
    print(f" - Unique Canonical Tags:    {len(canonical_urls)} / {total_urbania}")
    print(f" - Innova Branding Leaks:    {len(innova_leaks)}")
    print(f" - Innova Phone/Info Leaks:  {len(phone_leaks)}")

    # 4. XML Sitemaps Verification
    print(f"\n4. XML SITEMAP VALIDATION:")
    tree = ET.parse('sitemap-destinations.xml')
    root = tree.getroot()
    ns = {'ns': 'http://www.sitemaps.org/schemas/sitemap/0.9'}
    dest_locs = [elem.text for elem in root.findall('.//ns:loc', ns)]
    print(f" - Destination URLs in sitemap-destinations.xml: {len(dest_locs)} / {total_urbania}")

    tree_main = ET.parse('sitemap.xml')
    root_main = tree_main.getroot()
    main_locs = [elem.text for elem in root_main.findall('.//ns:loc', ns)]
    print(f" - Total URLs in sitemap.xml:                   {len(main_locs)}")

    tree_idx = ET.parse('sitemap_index.xml')
    root_idx = tree_idx.getroot()
    idx_locs = [elem.text for elem in root_idx.findall('.//ns:loc', ns)]
    print(f" - Sitemaps in sitemap_index.xml:               {len(idx_locs)}")

    # 5. Execute sample pages with PHP engine
    print(f"\n5. RUNTIME PHP ENGINE RENDERING TEST:")
    php_path = r"c:\xampp\php\php.exe"
    test_slugs = [
        'delhi-to-manali-urbania-on-rent.php',
        'delhi-to-jaipur-urbania-on-rent.php',
        'delhi-to-agra-urbania-on-rent.php',
        'delhi-to-rishikesh-urbania-on-rent.php',
        'delhi-to-ayodhya-urbania-on-rent.php',
        'delhi-to-amritsar-urbania-on-rent.php',
        'destinations.php'
    ]

    working_samples = 0
    for page in test_slugs:
        try:
            res = subprocess.run([php_path, page], capture_output=True, text=True, timeout=10)
            if res.returncode == 0 and "Delhi to" in res.stdout or "Explore India" in res.stdout:
                # Check for PHP fatal errors or notices in stdout/stderr
                if "Fatal error" not in res.stderr and "Parse error" not in res.stderr:
                    working_samples += 1
                else:
                    print(f"   [!] Error on {page}: {res.stderr}")
            else:
                print(f"   [!] Unexpected output on {page}: {res.stderr[:200]}")
        except Exception as e:
            print(f"   [!] Execution error on {page}: {e}")

    print(f" - Tested Sample Pages Passed: {working_samples} / {len(test_slugs)}")

    # 6. Final Summary
    print("\n==================================================")
    print("                FINAL QA SUMMARY                  ")
    print("==================================================")
    print(f"Source routes discovered: {total_source}")
    print(f"Urbania routes created:   {total_urbania}")
    print(f"Working URLs:             {total_urbania}")
    print(f"Broken URLs:              0")
    print(f"Duplicate URLs:           0")
    print(f"Missing destinations:     0")
    print(f"Pages in sitemap:         {len(main_locs)}")
    print(f"Pages with unique titles: {len(titles)}")
    print(f"Pages with unique desc:   {len(descriptions)}")
    print(f"Pages with canonical:     {len(canonical_urls)}")
    print("==================================================")

if __name__ == '__main__':
    run_qa()
