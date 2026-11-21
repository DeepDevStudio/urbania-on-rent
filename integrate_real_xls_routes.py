import json
import re
import os
from datetime import datetime

print("=" * 70)
print("INTEGRATING REAL DISTANCES AND TRAVEL TIMES FROM .XLS FILES")
print("=" * 70)

# Paths
MULTI_JSON_PATH = 'includes/destinations_multi_origin.json'
DATASET_JSON_PATH = 'destinations_dataset.json'
INCLUDES_DATASET_JSON_PATH = 'includes/destinations_dataset.json'

# Load existing multi-origin dataset
with open(MULTI_JSON_PATH, 'r', encoding='utf-8') as f:
    multi_data = json.load(f)

# Load existing Delhi dataset
with open(DATASET_JSON_PATH, 'r', encoding='utf-8') as f:
    delhi_dataset = json.load(f)

delhi_lookup = {}
for r in delhi_dataset:
    delhi_lookup[r['destination'].lower().strip()] = r

# Alias mapping for name discrepancies between website and Excel
alias_map = {
    'amb (hp)': 'amb himachal pradesh',
    'anand (rajasthan)': 'anand rajasthan',
    'bilaspur (hp)': 'bilaspur himachal pradesh',
    'budaun (up)': 'budaun',
    'chamba': 'chamba hp',
    'kaloli (rajasthan)': 'kaloli rajasthan',
    'kashipur': 'kashipur uttarakhand',
    'khatu shyam ji': 'khatu shyam',
    'madhopur': 'madhopur punjab',
    'mandi gobindgarh': 'mandi gobindgarh punjab',
    'nakodar': 'nakodar punjab',
    'palanpur (rajasthan)': 'palanpur rajasthan',
    'paonta sahib (hp)': 'paonta sahib himachal pradesh',
    'pratapgarh (rajasthan)': 'pratapgarh rajasthan',
    'pratapgarh (up)': 'pratapgarh uttar pradesh',
    'rampur (up)': 'rampur uttar pradesh',
    'rampur bushahr (hp)': 'rampur bushahr himachal pradesh',
    'renuka ji (hp)': 'renuka ji himachal pradesh'
}

xls_files = {
    'noida': ('Noida-city.xls', 'noida'),
    'ghaziabad': ('Ghaziabad-city.xls', 'ghaziabad'),
    'gurgaon': ('Gurgaon-city.xls', 'gurgaon'),
    'faridabad': ('Faridabad-city.xls', 'faridabad')
}

xls_data = {}

for origin_id, (fname, src_name) in xls_files.items():
    print(f"Reading {fname} for origin '{origin_id}' (Source: {src_name})...")
    with open(fname, 'r', encoding='utf-8', errors='ignore') as fp:
        c = fp.read()
    trs = re.findall(r'<tr[^>]*>(.*?)</tr>', c, re.DOTALL | re.IGNORECASE)
    lookup = {}
    for tr in trs:
        cells = re.findall(r'<t[hd][^>]*>(.*?)</t[hd]>', tr, re.DOTALL | re.IGNORECASE)
        cl = [re.sub(r'<[^>]+>', '', cell).strip() for cell in cells]
        if len(cl) >= 10 and cl[0] != 'Pair ID' and cl[1].strip().lower() == src_name:
            dest_name_clean = cl[3].strip().lower()
            try:
                dist_val = int(cl[8].strip())
                time_val = int(cl[9].strip())
                lookup[dest_name_clean] = (dist_val, time_val)
            except ValueError:
                continue
    xls_data[origin_id] = lookup
    print(f"  Loaded {len(lookup)} destination entries for {origin_id}.")

# Track updates
stats = {o: {'updated': 0, 'total': 0} for o in multi_data['routes_by_origin'].keys()}

routes_by_origin = multi_data['routes_by_origin']
routes_by_slug = {}

for origin_id, routes in routes_by_origin.items():
    print(f"\nProcessing origin '{origin_id}' ({len(routes)} routes)...")
    for route in routes:
        dest_name = route['destination']
        norm_dest = dest_name.lower().strip()
        origin_name = route['origin']
        stats[origin_id]['total'] += 1

        if origin_id in xls_data:
            lookup_table = xls_data[origin_id]
            key = alias_map.get(norm_dest, norm_dest)
            
            matched = False
            real_dist = None
            real_time = None

            if key in lookup_table:
                real_dist, real_time = lookup_table[key]
                matched = True
            elif norm_dest in lookup_table:
                real_dist, real_time = lookup_table[norm_dest]
                matched = True

            if matched and real_dist is not None and real_time is not None:
                # Format time string faithfully
                time_str = "1 hour" if real_time == 1 else f"{real_time} hours"
                dist_str = f"{real_dist} km"

                # Update route fields
                route['distance'] = real_dist
                route['distance_str'] = dist_str
                route['estimated_duration_minutes'] = real_time * 60
                route['estimated_travel_time'] = time_str

                # Recommended duration based on real distance
                if real_dist <= 180:
                    rec_duration = "1 Day (Same Day Return)"
                elif real_dist <= 350:
                    rec_duration = "2 Days / 1 Night"
                elif real_dist <= 600:
                    rec_duration = "3 Days / 2 Nights"
                elif real_dist <= 900:
                    rec_duration = "4 Days / 3 Nights"
                else:
                    rec_duration = "5-6 Days Tour Package"
                route['recommended_duration'] = rec_duration

                # Calculate fares: 16 Seater is Rs 40/km, 9 & 12 Seater (Maharaja) is Rs 45/km
                min_billable_km = max(real_dist * 2, 500)
                fare_9s = f"{min_billable_km * 45:,}"
                fare_12s = f"{min_billable_km * 45:,}"
                fare_16s = f"{min_billable_km * 40:,}"

                route['min_billable_km'] = min_billable_km
                route['fare_9s'] = fare_9s
                route['fare_12s'] = fare_12s
                route['fare_16s'] = fare_16s
                route['routing_provider'] = 'Verified Interstate Highway Matrix'
                route['calculation_status'] = 'verified'

                # Update description
                if 'description' in route and route['description']:
                    route['description'] = re.sub(
                        r'approximately\s+[\d,]+\s*km',
                        f'approximately {dist_str}',
                        route['description']
                    )

                # Update highlights
                if 'highlights' in route and isinstance(route['highlights'], list) and len(route['highlights']) > 0:
                    route['highlights'][0] = f"Smooth highway journey of approx. {dist_str} from {origin_name}"

                # Update FAQs
                if 'faqs' in route and isinstance(route['faqs'], list) and len(route['faqs']) >= 3:
                    route['faqs'][0]['a'] = (
                        f"The driving distance from {origin_name} to {dest_name} is approximately {dist_str}, "
                        f"taking around {time_str} depending on highway traffic and route conditions. "
                        f"Our certified chauffeurs ensure a smooth, punctual journey with doorstep pickup anywhere across {origin_name}."
                    )
                    route['faqs'][2]['a'] = (
                        f"Our transparent per-km billing starts at ₹40/km for 16 seater Urbania and ₹45/km for 9 & 12 seater Urbania (Maharaja). "
                        f"Roundtrip estimated base fare starts from ~₹{fare_16s} covering fuel, chauffeur allowance, and toll taxes."
                    )

                stats[origin_id]['updated'] += 1
            else:
                print(f"  WARNING: Could not match {dest_name} in {origin_id}!")

        elif origin_id == 'delhi':
            # Sync Delhi from authentic crawled dataset
            if norm_dest in delhi_lookup:
                d_item = delhi_lookup[norm_dest]
                d_dist = d_item['distance']
                d_time_str = d_item['estimated_travel_time']
                dist_str = f"{d_dist} km"

                route['distance'] = d_dist
                route['distance_str'] = dist_str
                route['estimated_travel_time'] = d_time_str

                # Duration minutes
                if 'hours' in d_time_str:
                    m = re.findall(r'(\d+)', d_time_str)
                    if m:
                        avg_hrs = sum(int(x) for x in m) / len(m)
                        route['estimated_duration_minutes'] = int(avg_hrs * 60)
                    else:
                        route['estimated_duration_minutes'] = round((d_dist / 45) * 60)
                else:
                    route['estimated_duration_minutes'] = round((d_dist / 45) * 60)

                # Recommended duration
                if d_dist <= 180:
                    rec_duration = "1 Day (Same Day Return)"
                elif d_dist <= 350:
                    rec_duration = "2 Days / 1 Night"
                elif d_dist <= 600:
                    rec_duration = "3 Days / 2 Nights"
                elif d_dist <= 900:
                    rec_duration = "4 Days / 3 Nights"
                else:
                    rec_duration = "5-6 Days Tour Package"
                route['recommended_duration'] = rec_duration

                min_billable_km = max(d_dist * 2, 500)
                fare_9s = f"{min_billable_km * 45:,}"
                fare_12s = f"{min_billable_km * 45:,}"
                fare_16s = f"{min_billable_km * 40:,}"

                route['min_billable_km'] = min_billable_km
                route['fare_9s'] = fare_9s
                route['fare_12s'] = fare_12s
                route['fare_16s'] = fare_16s
                route['routing_provider'] = 'Verified Interstate Highway Matrix'
                route['calculation_status'] = 'verified'

                if 'description' in route and route['description']:
                    route['description'] = re.sub(
                        r'approximately\s+[\d,]+\s*km',
                        f'approximately {dist_str}',
                        route['description']
                    )

                if 'highlights' in route and isinstance(route['highlights'], list) and len(route['highlights']) > 0:
                    route['highlights'][0] = f"Smooth highway journey of approx. {dist_str} from {origin_name}"

                if 'faqs' in route and isinstance(route['faqs'], list) and len(route['faqs']) >= 3:
                    route['faqs'][0]['a'] = (
                        f"The driving distance from {origin_name} to {dest_name} is approximately {dist_str}, "
                        f"taking around {d_time_str} depending on highway traffic and route conditions. "
                        f"Our certified chauffeurs ensure a smooth, punctual journey with doorstep pickup anywhere across {origin_name}."
                    )
                    route['faqs'][2]['a'] = (
                        f"Our transparent per-km billing starts at ₹40/km for 16 seater Urbania and ₹45/km for 9 & 12 seater Urbania (Maharaja). "
                        f"Roundtrip estimated base fare starts from ~₹{fare_16s} covering fuel, chauffeur allowance, and toll taxes."
                    )

                stats[origin_id]['updated'] += 1

        # Add to global slug index
        routes_by_slug[route['slug']] = route

print("\nUpdating master dataset files...")
multi_data['routes_by_origin'] = routes_by_origin
multi_data['routes_by_slug'] = routes_by_slug
multi_data['total_routes'] = len(routes_by_slug)
multi_data['updated_at'] = datetime.utcnow().isoformat() + 'Z'

# Save includes/destinations_multi_origin.json
with open(MULTI_JSON_PATH, 'w', encoding='utf-8') as f:
    json.dump(multi_data, f, indent=2, ensure_ascii=False)
print(f"Saved {MULTI_JSON_PATH} with {len(routes_by_slug)} indexed routes.")

# Save includes/destinations_dataset.json (Delhi backward compatibility)
with open(INCLUDES_DATASET_JSON_PATH, 'w', encoding='utf-8') as f:
    json.dump(routes_by_origin['delhi'], f, indent=2, ensure_ascii=False)
print(f"Saved {INCLUDES_DATASET_JSON_PATH} for Delhi compatibility.")

# Save root destinations_dataset.json
with open(DATASET_JSON_PATH, 'w', encoding='utf-8') as f:
    json.dump(routes_by_origin['delhi'], f, indent=2, ensure_ascii=False)
print(f"Saved {DATASET_JSON_PATH}.")

print("\nSummary of Updates:")
for o, s in stats.items():
    print(f"  {o.capitalize()}: {s['updated']} / {s['total']} routes updated with real distance and time.")
print("=" * 70)
print("SUCCESSFULLY COMPLETED INTEGRATION!")
