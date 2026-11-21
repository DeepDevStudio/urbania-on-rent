import os, glob, re

def extract_img_tags_robust(html):
    # Mask PHP tags to avoid '<' and '>' interfering with HTML tag matching
    php_blocks = []
    def mask_php(m):
        php_blocks.append(m.group(0))
        return f"__PHP_TAG_{len(php_blocks)-1}__"

    masked = re.sub(r'<\?.*?\?>', mask_php, html, flags=re.DOTALL)
    
    tags = []
    for m in re.finditer(r'<img\s+([^>]+)>', masked, flags=re.IGNORECASE):
        attrs = m.group(1)
        full_tag = m.group(0)
        
        # Unmask PHP tags inside attrs and full_tag
        for i, block in enumerate(php_blocks):
            attrs = attrs.replace(f"__PHP_TAG_{i}__", block)
            full_tag = full_tag.replace(f"__PHP_TAG_{i}__", block)
            
        # Extract alt attribute
        # Try both 'alt="..."' and 'alt=\'...\''
        alt_m = re.search(r'\balt=([\'"])(.*?)\1', attrs, flags=re.IGNORECASE | re.DOTALL)
        alt_val = alt_m.group(2) if alt_m else None
        
        # Extract src attribute
        src_m = re.search(r'\bsrc=([\'"])(.*?)\1', attrs, flags=re.IGNORECASE | re.DOTALL)
        src_val = src_m.group(2) if src_m else None
        
        tags.append({
            'full_tag': full_tag,
            'src': src_val,
            'alt': alt_val,
            'has_alt': alt_val is not None,
            'is_decorative': alt_val == '',
        })
    return tags

all_files = sorted(glob.glob('*.php') + glob.glob('includes/**/*.php', recursive=True))

total_scanned_files = 0
files_with_images = 0
total_images_found = 0
missing_alt_records = []
verified_alt_records = []
decorative_records = []

for filepath in all_files:
    if filepath.startswith('scratch') or 'test_' in filepath:
        continue
    total_scanned_files += 1
    with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()
    
    tags = extract_img_tags_robust(content)
    if tags:
        files_with_images += 1
        total_images_found += len(tags)
        for t in tags:
            rec = {'file': filepath, **t}
            if not t['has_alt']:
                missing_alt_records.append(rec)
            elif t['is_decorative']:
                decorative_records.append(rec)
            else:
                verified_alt_records.append(rec)

print("=" * 60)
print("IMAGE SEO & ACCESSIBILITY AUDIT REPORT")
print("=" * 60)
print(f"Total PHP / Template Files Audited: {total_scanned_files}")
print(f"Files Containing <img> Tags: {files_with_images}")
print(f"Total <img> Tags Detected: {total_images_found}")
print(f"Total Meaningful Images with Valid ALT: {len(verified_alt_records)}")
print(f"Total Decorative Images with alt='': {len(decorative_records)}")
print(f"Total Missing ALT Attributes: {len(missing_alt_records)}")
print("=" * 60)

if missing_alt_records:
    print("\nFAILURES - Missing ALT attributes:")
    for r in missing_alt_records:
        print(f"  File: {r['file']}")
        print(f"  Tag:  {r['full_tag']}\n")
else:
    print("\nSUCCESS: 100% of images have ALT attributes! ZERO missing ALTs found.")

# Let's inspect some representative rendered samples from index.php, fleet.php, static routes, and dynamic route
print("\n--- SAMPLE VALIDATED ALT ATTRIBUTES ---")
sample_files = ['index.php', 'about.php', 'fleet.php', 'testimonials.php', 'delhi-to-agra-urbania.php', 'delhi-to-jaipur-urbania.php', 'char-dham-urbania-package.php']
for sf in sample_files:
    if os.path.exists(sf):
        with open(sf, 'r', encoding='utf-8') as f:
            tags = extract_img_tags_robust(f.read())
        print(f"\n{sf}:")
        for t in tags:
            print(f"  src: {t['src']}")
            print(f"  alt: {t['alt']}")
