import glob, re

delhi_files = glob.glob('delhi-to-*-urbania.php')
for fname in sorted(delhi_files):
    with open(fname, 'r', encoding='utf-8') as f:
        text = f.read()
    # match all img tags
    img_tags = re.findall(r'<img\s+[^>]+>', text)
    print(f"=== {fname} ({len(img_tags)} images) ===")
    for tag in img_tags:
        print("  ", tag)
