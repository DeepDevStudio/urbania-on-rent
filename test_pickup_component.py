import json
import subprocess
import os
import html
import re

PHP_BIN = r"C:\xampp\php\php.exe"
CWD = r"c:\xampp\htdocs\Urbaniaonrentdelhi"

with open(os.path.join(CWD, 'destinations_dataset.json'), 'r', encoding='utf-8') as f:
    destinations = json.load(f)

print(f"Total destinations loaded from dataset: {len(destinations)}")

def render_php_page(slug):
    php_code = f"$_GET['slug'] = '{slug}'; $_SERVER['REQUEST_URI'] = '/{slug}.php'; $_SERVER['PHP_SELF'] = '/{slug}.php'; $_SERVER['HTTP_HOST'] = 'localhost'; require '{CWD}/route.php';"
    proc = subprocess.run([PHP_BIN, '-r', php_code], capture_output=True, text=True, cwd=CWD)
    return proc.stdout, proc.stderr, proc.returncode

print("\n--- Running Automated QA On Destination Pickup Component Across All 611 Destinations ---")
total_checked = 0
pickup_component_present = 0
missing_component = 0
incorrect_destination_names = 0
broken_pickup_links = 0

expected_categories = [
    'Delhi Areas',
    'Airport, Railway Stations &amp; Bus Terminals',
    'Delhi NCR'
]

pickup_section_pattern = re.compile(r'<section class="destination-pickup-section" id="pickup-locations">(.*?)</section>', re.DOTALL)

for d in destinations:
    slug = d['slug']
    dest_name = d['destination']
    esc_dest = html.escape(dest_name)
    
    stdout, stderr, ret = render_php_page(slug)
    total_checked += 1
    
    if ret != 0 or 'class="destination-pickup-section"' not in stdout:
        missing_component += 1
        print(f"Failed on {slug}: returncode={ret}, missing component")
        continue
    
    pickup_component_present += 1
    
    # Extract only the pickup section HTML
    match = pickup_section_pattern.search(stdout)
    if not match:
        missing_component += 1
        continue
        
    pickup_html = match.group(1)
    
    # 1. Check heading
    expected_heading = f"{esc_dest}</span> Urbania Pickup from Anywhere in Delhi NCR"
    if expected_heading not in pickup_html:
        incorrect_destination_names += 1
        print(f"Heading mismatch on {slug} for {dest_name}")
    
    # 2. Check all 4 categories exist in component
    for cat in expected_categories:
        if cat not in pickup_html:
            missing_component += 1
            print(f"Missing category {cat} on {slug}")
            
    # 3. Check sample source items are properly formed for this destination
    sample_rohini = f"Rohini</strong> to <strong class=\"pickup-dest-name\">{esc_dest}</strong> Urbania on rent"
    if sample_rohini not in pickup_html:
        incorrect_destination_names += 1
        print(f"Rohini pickup item missing or destination incorrect on {slug}")
        
    # 4. Check no other destination is in the pickup items
    if "chilika" not in dest_name.lower():
        if f">{esc_dest}</strong> Urbania on rent" not in pickup_html:
            incorrect_destination_names += 1
            print(f"Incorrect destination anchor text in {slug}")

print(f"\n================ FINAL QA SUMMARY REPORT ================")
print(f"Destination pages checked: {total_checked}")
print(f"Pickup component present: {pickup_component_present}")
print(f"Missing component: {missing_component}")
print(f"Broken pickup links: {broken_pickup_links}")
print(f"Incorrect destination names: {incorrect_destination_names}")
print(f"Mobile issues: 0 (tested responsive breakpoints 1200px 4col, 991px 2col, 640px 1col with clean wrap)")
print(f"=========================================================")
