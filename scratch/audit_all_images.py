import os
import re
from collections import defaultdict

root_dir = r"c:\xampp\htdocs\Urbaniaonrentdelhi"
img_regex = re.compile(r'<img\s+([^>]*?)>', re.IGNORECASE)
src_regex = re.compile(r'src=["\']([^"\']+)["\']', re.IGNORECASE)
alt_regex = re.compile(r'alt=["\']([^"\']*)["\']', re.IGNORECASE)

results = []
file_count = 0
all_alts = defaultdict(list)

for dirpath, dirnames, filenames in os.walk(root_dir):
    # skip .git, __pycache__, scratch
    if any(p in dirpath for p in ['.git', '__pycache__', 'scratch']):
        continue
    for fname in filenames:
        if fname.endswith(('.php', '.html')):
            file_count += 1
            fpath = os.path.join(dirpath, fname)
            try:
                with open(fpath, 'r', encoding='utf-8', errors='ignore') as f:
                    content = f.read()
            except Exception as e:
                continue

            matches = img_regex.findall(content)
            for m in matches:
                src_m = src_regex.search(m)
                alt_m = alt_regex.search(m)
                src = src_m.group(1) if src_m else 'NO_SRC'
                alt = alt_m.group(1) if alt_m else 'NO_ALT'
                rel_path = os.path.relpath(fpath, root_dir)
                results.append({
                    'file': rel_path,
                    'tag': m,
                    'src': src,
                    'alt': alt
                })
                all_alts[alt].append((rel_path, src))

print(f"Scanned {file_count} files.")
print(f"Found {len(results)} total <img> tags.")

no_alt = [r for r in results if r['alt'] == 'NO_ALT']
empty_alt = [r for r in results if r['alt'] == '']
has_alt = [r for r in results if r['alt'] not in ['NO_ALT', '']]

print(f"Tags with missing alt attribute: {len(no_alt)}")
print(f"Tags with empty alt (alt=\"\"): {len(empty_alt)}")
print(f"Tags with non-empty alt: {len(has_alt)}")

# Group by unique file types
templates = defaultdict(list)
for r in results:
    templates[r['file']].append(r)

print(f"\nUnique files containing <img> tags: {len(templates)}")
for f, items in sorted(templates.items()):
    if not f.startswith(('delhi-to-', 'gurgaon-to-', 'noida-to-')) or f in ['delhi-to-jaipur-urbania.php', 'delhi-to-manali-urbania.php']:
        print(f"  {f}: {len(items)} images")
