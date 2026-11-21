import subprocess, re

routes_to_test = [
    'delhi-to-manali-urbania-on-rent',
    'gurgaon-to-jaipur-urbania-on-rent',
    'noida-to-agra-urbania-on-rent',
    'ghaziabad-to-haridwar-urbania-on-rent',
    'faridabad-to-shimla-urbania-on-rent'
]

print("TESTING DYNAMIC ROUTE RENDERING ACROSS 5 ORIGIN CITIES")
print("=" * 60)

for r in routes_to_test:
    cmd = [r'C:\xampp\php\php.exe', '-r', f'''
        \$_GET['slug'] = '{r}';
        ob_start();
        require 'route.php';
        \$html = ob_get_clean();
        preg_match_all('/<img\s+[^>]+>/i', \$html, \$matches);
        echo "ROUTE: {r}\\n";
        echo "Found " . count(\$matches[0]) . " images in rendered HTML:\\n";
        foreach (\$matches[0] as \$tag) {
            preg_match('/src=([\'"][^\'"]+[\'"])/i', \$tag, \$sm);
            preg_match('/alt=([\'"][^\'"]*[\'"])/i', \$tag, \$am);
            \$s = \$sm[1] ?? 'NO_SRC';
            \$a = \$am[1] ?? 'NO_ALT';
            echo "  src=" . \$s . "  alt=" . \$a . "\\n";
        }
    ''']
    res = subprocess.run(cmd, capture_output=True, text=True)
    if res.returncode == 0:
        print(res.stdout)
    else:
        print(f"Error on {r}:", res.stderr)
