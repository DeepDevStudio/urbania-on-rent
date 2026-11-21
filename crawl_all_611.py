import urllib.request
import ssl
import re
import json
import time
from concurrent.futures import ThreadPoolExecutor, as_completed

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

with open('extracted_raw_destinations.json', 'r', encoding='utf-8') as f:
    dests = json.load(f)

print(f"Starting crawl of all {len(dests)} destination pages...")

def fetch_dest(d):
    url = f"https://innovacrystarent.com/{d['source_href']}"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'})
    for attempt in range(3):
        try:
            with urllib.request.urlopen(req, timeout=12, context=ctx) as r:
                html = r.read().decode('utf-8', errors='ignore')
                
                # Extract Title, H1, Meta Description
                title_m = re.search(r'<title>(.*?)</title>', html, re.I | re.DOTALL)
                h1_m = re.search(r'<h1[^>]*>(.*?)</h1>', html, re.I | re.DOTALL)
                desc_m = re.search(r'<meta[^>]+name=[\"\']description[\"\'][^>]+content=[\"\'](.*?)[\"\']', html, re.I)
                
                # Extract distance, time
                # Example: distance is approximately 395 km, which takes about 7-8 hours
                dist_m = re.search(r'approximately\s*<strong[^>]*>([\d,]+\s*(?:km|kms))</strong>', html, re.I)
                if not dist_m:
                    dist_m = re.search(r'(\d+)\s*(?:km|kms)', html, re.I)
                
                time_m = re.search(r'about\s*<strong[^>]*>([\d\-.]+\s*(?:hours|hrs|hr))</strong>', html, re.I)
                if not time_m:
                    time_m = re.search(r'([\d\-.]+\s*(?:hours|hrs|hr))', html, re.I)
                
                # Extract all informative paragraphs
                p_tags = re.findall(r'<p[^>]*>(.*?)</p>', html, re.DOTALL)
                clean_ps = []
                for p in p_tags:
                    clean = re.sub(r'<[^>]+>', '', p).strip()
                    clean = re.sub(r'\s+', ' ', clean)
                    # Exclude footer/cookie/pricing boilerplate
                    if len(clean) > 30 and 'cookie' not in clean.lower() and 'copyright' not in clean.lower() and 'crysta' not in clean.lower()[:20]:
                        clean_ps.append(clean)
                
                # Extract any list items (e.g. attractions or places)
                li_tags = re.findall(r'<li[^>]*>(.*?)</li>', html, re.DOTALL)
                clean_lis = []
                for li in li_tags:
                    clean_li = re.sub(r'<[^>]+>', '', li).strip()
                    clean_li = re.sub(r'\s+', ' ', clean_li)
                    if len(clean_li) > 4 and len(clean_li) < 100:
                        clean_lis.append(clean_li)

                # State detection from text
                state = None
                text_block = " ".join(clean_ps)
                state_match = re.search(r'in (?:the )?([A-Za-z\s]+) state of India', text_block, re.I)
                if state_match:
                    state = state_match.group(1).strip()
                elif 'Rajasthan' in text_block:
                    state = 'Rajasthan'
                elif 'Himachal Pradesh' in text_block or 'Himachal' in text_block:
                    state = 'Himachal Pradesh'
                elif 'Uttarakhand' in text_block:
                    state = 'Uttarakhand'
                elif 'Uttar Pradesh' in text_block:
                    state = 'Uttar Pradesh'
                elif 'Punjab' in text_block:
                    state = 'Punjab'
                elif 'Haryana' in text_block:
                    state = 'Haryana'
                elif 'Jammu' in text_block or 'Kashmir' in text_block:
                    state = 'Jammu & Kashmir'
                elif 'Madhya Pradesh' in text_block:
                    state = 'Madhya Pradesh'
                elif 'Gujarat' in text_block:
                    state = 'Gujarat'
                elif 'Maharashtra' in text_block:
                    state = 'Maharashtra'

                return {
                    'slug': d['source_slug'],
                    'destination': d['destination_name'],
                    'source_href': d['source_href'],
                    'raw_distance': dist_m.group(1).strip() if dist_m and hasattr(dist_m, 'group') and dist_m.lastindex else (dist_m.group(0).strip() if dist_m else None),
                    'raw_duration': time_m.group(1).strip() if time_m and hasattr(time_m, 'group') and time_m.lastindex else (time_m.group(0).strip() if time_m else None),
                    'state_detected': state,
                    'paragraphs': clean_ps[:5],
                    'list_items': clean_lis[:10],
                    'status': 'success'
                }
        except Exception as e:
            time.sleep(0.5)
            if attempt == 2:
                return {
                    'slug': d['source_slug'],
                    'destination': d['destination_name'],
                    'source_href': d['source_href'],
                    'status': 'failed',
                    'error': str(e)
                }

start_time = time.time()
results = []
with ThreadPoolExecutor(max_workers=20) as executor:
    futures = {executor.submit(fetch_dest, d): d for d in dests}
    for future in as_completed(futures):
        res = future.result()
        results.append(res)
        if len(results) % 50 == 0:
            print(f"Fetched {len(results)} / {len(dests)} ({time.time()-start_time:.1f}s)")

print(f"Completed fetch of {len(results)} destinations in {time.time()-start_time:.1f}s")

successes = [r for r in results if r['status'] == 'success']
failures = [r for r in results if r['status'] != 'success']

print(f"Success: {len(successes)} | Failures: {len(failures)}")

with open('source_crawled_611.json', 'w', encoding='utf-8') as f:
    json.dump(results, f, indent=2)

print("Saved to source_crawled_611.json")
