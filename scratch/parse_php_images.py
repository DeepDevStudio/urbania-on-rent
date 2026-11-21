import os
import re

root_dir = r"c:\xampp\htdocs\Urbaniaonrentdelhi"

# Regex to match <img> tag across lines and through PHP blocks
img_full_regex = re.compile(r'<img\b(?:\s+[^>]*?|\s+<\?php.*?\?>)*?>', re.DOTALL | re.IGNORECASE)

files_with_images = []

for dirpath, dirnames, filenames in os.walk(root_dir):
    if any(p in dirpath for p in ['.git', '__pycache__', 'scratch']):
        continue
    for fname in filenames:
        if fname.endswith(('.php', '.html')):
            fpath = os.path.join(dirpath, fname)
            with open(fpath, 'r', encoding='utf-8', errors='ignore') as f:
                content = f.read()
            matches = list(re.finditer(r'<img\b[\s\S]*?>', content, re.IGNORECASE))
            if matches:
                # filter true tags
                clean_matches = []
                for m in matches:
                    text = m.group(0)
                    # make sure closing > is not just inside <?php ... ?>
                    pos = m.start()
                    # find matching closing > that is not in a php block or quotes
                    i = pos + 4
                    in_php = False
                    in_quote = False
                    quote_char = ''
                    while i < len(content):
                        if not in_php and content[i:i+5] == '<?php':
                            in_php = True
                            i += 5
                            continue
                        if in_php and content[i:i+2] == '?>':
                            in_php = False
                            i += 2
                            continue
                        if not in_php:
                            if not in_quote and content[i] in ['"', "'"]:
                                in_quote = True
                                quote_char = content[i]
                            elif in_quote and content[i] == quote_char:
                                in_quote = False
                            elif not in_quote and content[i] == '>':
                                clean_matches.append(content[pos:i+1])
                                break
                        i += 1
                if clean_matches:
                    files_with_images.append((os.path.relpath(fpath, root_dir), clean_matches))

print(f"Total files with images: {len(files_with_images)}")
total_imgs = sum(len(imgs) for _, imgs in files_with_images)
print(f"Total img tags: {total_imgs}\n")

for f, imgs in sorted(files_with_images):
    print(f"=== {f} ({len(imgs)} images) ===")
    for tag in imgs:
        print("  " + " ".join(tag.split()))
