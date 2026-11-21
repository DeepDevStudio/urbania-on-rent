with open('delhi-to-agra-urbania.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# Replace PHP tags temporarily with a placeholder to avoid premature '>' closing
def extract_img_tags(html):
    # Mask PHP tags
    php_blocks = []
    def mask_php(m):
        php_blocks.append(m.group(0))
        return f"__PHP_BLOCK_{len(php_blocks)-1}__"

    masked = re.sub(r'<\?.*?\?>', mask_php, html, flags=re.DOTALL)
    
    tags = []
    for m in re.finditer(r'<img\s+[^>]+>', masked, flags=re.IGNORECASE):
        tag = m.group(0)
        # Unmask PHP tags
        for i, block in enumerate(php_blocks):
            tag = tag.replace(f"__PHP_BLOCK_{i}__", block)
        tags.append(tag)
    return tags

tags = extract_img_tags(text)
print(f"Extracted {len(tags)} tags from delhi-to-agra-urbania.php:")
for t in tags:
    print(" ", t)
