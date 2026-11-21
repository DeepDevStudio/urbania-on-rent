import os, glob, re

def audit_file(filepath):
    with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    # Find all <img> tags
    img_matches = re.finditer(r'<img\s+([^>]+)>', content, flags=re.IGNORECASE)
    results = []
    for m in img_matches:
        raw_tag = m.group(0)
        attrs = m.group(1)

        # Extract src
        src_m = re.search(r'\bsrc=[\'"]([^\'"]+)[\'"]', attrs, flags=re.IGNORECASE)
        src = src_m.group(1) if src_m else 'NO_SRC'

        # Extract alt
        alt_m = re.search(r'\balt=[\'"]([^\'"]*)[\'"]', attrs, flags=re.IGNORECASE)
        alt = alt_m.group(1) if alt_m else None

        results.append({
            'tag': raw_tag,
            'src': src,
            'alt': alt,
            'has_alt': alt is not None,
            'empty_alt': alt == ''
        })
    return results

all_files = glob.glob('*.php') + glob.glob('includes/**/*.php', recursive=True)

total_images = 0
missing_alt = []
duplicate_descriptions = {}
files_with_images = 0

for f in sorted(all_files):
    if f.startswith('scratch'):
        continue
    res = audit_file(f)
    if res:
        files_with_images += 1
        total_images += len(res)
        for item in res:
            if not item['has_alt']:
                missing_alt.append((f, item['tag']))
            else:
                a = item['alt']
                if a != '':
                    duplicate_descriptions[a] = duplicate_descriptions.get(a, 0) + 1

print(f"Total files audited: {len(all_files)}")
print(f"Files with images: {files_with_images}")
print(f"Total <img> tags: {total_images}")
print(f"Missing ALT attributes: {len(missing_alt)}")
if missing_alt:
    for f, tag in missing_alt:
        print(f"  Missing in {f}: {tag}")

print("\n--- Summary of ALT frequency ---")
singletons = sum(1 for c in duplicate_descriptions.values() if c == 1)
print(f"Unique ALT descriptions: {len(duplicate_descriptions)}")
print(f"ALT descriptions used only once: {singletons}")

# Check any instances of repetitive vehicle keywords on destination images
stuffed_checks = ['urbania on rent delhi', 'force urbania on rent', 'urbania hire']
print("\n--- Check for keyword stuffing across images ---")
for f in sorted(all_files):
    if f.startswith('scratch'):
        continue
    res = audit_file(f)
    for item in res:
        a = (item['alt'] or '').lower()
        s = item['src'].lower()
        if 'destinations/' in s and any(k in a for k in stuffed_checks):
            print(f"Warning - Vehicle keyword in destination image on {f}: src={item['src']} alt='{item['alt']}'")
