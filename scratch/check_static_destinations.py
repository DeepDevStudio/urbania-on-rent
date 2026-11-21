import glob
import re
import os

files = glob.glob(r"c:\xampp\htdocs\Urbaniaonrentdelhi\delhi-to-*-urbania.php")
print(f"Total static destination files: {len(files)}")

img_pattern = re.compile(r'<img\s+src=["\']([^"\']+)["\']\s+alt=["\']([^"\']*)["\']', re.IGNORECASE)

for f in sorted(files):
    with open(f, 'r', encoding='utf-8', errors='ignore') as fp:
        content = fp.read()
    matches = img_pattern.findall(content)
    base_f = os.path.basename(f)
    if matches:
        print(f"\n--- {base_f} ---")
        for src, alt in matches:
            print(f"  src={src} | alt={alt}")
