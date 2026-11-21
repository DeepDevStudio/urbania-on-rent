import glob, re

def extract_img_tags(html):
    php_blocks = []
    def mask_php(m):
        php_blocks.append(m.group(0))
        return f"__PHP_BLOCK_{len(php_blocks)-1}__"

    masked = re.sub(r'<\?.*?\?>', mask_php, html, flags=re.DOTALL)
    tags = []
    for m in re.finditer(r'<img\s+[^>]+>', masked, flags=re.IGNORECASE):
        tag = m.group(0)
        for i, block in enumerate(php_blocks):
            tag = tag.replace(f"__PHP_BLOCK_{i}__", block)
        tags.append(tag)
    return tags

files = sorted(glob.glob('delhi-to-*-urbania.php'))
needs_update = []
for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        content = fp.read()
    tags = extract_img_tags(content)
    for t in tags:
        if 'Urbania on Rent' in t or 'Urbania Hire' in t or 'Urbania for' in t:
            needs_update.append((f, t))

print(f"Tags still needing update: {len(needs_update)}")
for f, t in needs_update:
    print(f"{f}: {t}")
