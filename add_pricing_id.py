import glob

files = glob.glob('*.php')
updated = 0
for f in files:
    with open(f, 'r', encoding='utf-8', errors='ignore') as fp:
        content = fp.read()
    if '<section class="premium-pricing">' in content:
        content = content.replace('<section class="premium-pricing">', '<section class="premium-pricing" id="pricing" style="scroll-margin-top: 80px;">')
        with open(f, 'w', encoding='utf-8') as fp:
            fp.write(content)
        updated += 1
        print('Updated id=pricing in', f)

print(f"Done updating {updated} files.")
