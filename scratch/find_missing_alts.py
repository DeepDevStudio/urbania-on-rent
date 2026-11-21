import os
import re

root_dir = r"c:\xampp\htdocs\Urbaniaonrentdelhi"
img_regex = re.compile(r'<img\s+([^>]*?)>', re.IGNORECASE)
alt_regex = re.compile(r'alt=["\']([^"\']*)["\']', re.IGNORECASE)
src_regex = re.compile(r'src=["\']([^"\']+)["\']', re.IGNORECASE)

for dirpath, dirnames, filenames in os.walk(root_dir):
    if any(p in dirpath for p in ['.git', '__pycache__', 'scratch']):
        continue
    for fname in filenames:
        if fname.endswith(('.php', '.html')):
            fpath = os.path.join(dirpath, fname)
            with open(fpath, 'r', encoding='utf-8', errors='ignore') as f:
                content = f.read()
            for m in img_regex.findall(content):
                if not alt_regex.search(m):
                    src_m = src_regex.search(m)
                    src = src_m.group(1) if src_m else 'NO_SRC'
                    print(f"Missing ALT in {os.path.relpath(fpath, root_dir)}: src={src}")
