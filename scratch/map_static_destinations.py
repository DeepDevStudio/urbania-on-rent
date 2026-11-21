import glob, re

files = sorted(glob.glob('delhi-to-*-urbania.php'))
print(f"Total static route files: {len(files)}")

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        content = fp.read()
    matches = re.findall(r'<img\s+[^>]*src=[\'"]([^\'"]+)[\'"][^>]*\balt=[\'"]([^\'"]*)[\'"][^>]*>', content)
    print(f"\n{f}:")
    for src, alt in matches:
        print(f"  src: {src} -> {alt}")
