import os, re

blog_alts = {
    'blog-delhi-to-agra.php': 'Taj Mahal marble monument in Agra, Uttar Pradesh',
    'blog-delhi-to-amritsar.php': 'Golden Temple sanctum and holy sarovar in Amritsar, Punjab',
    'blog-delhi-to-chardham.php': 'Ancient Kedarnath Temple against Himalayan snow peaks in Uttarakhand',
    'blog-delhi-to-haridwar.php': 'Ganga river ghats at Har Ki Pauri in Haridwar, Uttarakhand',
    'blog-delhi-to-jaipur.php': 'Hawa Mahal Palace of Winds in Jaipur, Rajasthan',
    'blog-delhi-to-manali.php': 'Snow-covered mountain peaks in Manali, Himachal Pradesh',
    'blog-delhi-to-mussoorie.php': 'Kempty Falls and scenic mountain valley in Mussoorie, Uttarakhand',
    'blog-delhi-to-nainital.php': 'Naini Lake and surrounding green hills in Nainital, Uttarakhand',
    'blog-delhi-to-rishikesh.php': 'Laxman Jhula suspension bridge over river Ganga in Rishikesh, Uttarakhand',
    'blog-delhi-to-shimla.php': 'Mall Road and Ridge hill station vista in Shimla, Himachal Pradesh',
    'blog-delhi-to-udaipur.php': 'City Palace and Lake Pichola in Udaipur, Rajasthan',
    'blog-delhi-to-varanasi.php': 'Ganga Aarti evening prayer ritual at Dashashwamedh Ghat in Varanasi, Uttar Pradesh',
}

for fname, alt_text in blog_alts.items():
    if not os.path.exists(fname):
        print(f"File {fname} not found!")
        continue
    with open(fname, 'r', encoding='utf-8') as f:
        content = f.read()

    # Match <img src="images/blog_delhi_...jpg" alt="..." ...>
    regex = r'(<img\s+[^>]*src=[\'"]images/blog_delhi_[a-z0-9_\-]+\.jpg[\'"][^>]*\balt=[\'"])([^\'"]*)([\'"][^>]*>)'
    if re.search(regex, content):
        new_content = re.sub(regex, r'\g<1>' + alt_text + r'\g<3>', content, count=1)
        with open(fname, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"[{fname}] Updated alt to: {alt_text}")
    else:
        print(f"[{fname}] Pattern not found!")
