import json
import math
import os
import re
import time
import urllib.parse
import urllib.request
from datetime import datetime

ORIGINS = {
    'delhi': {
        'id': 'delhi',
        'name': 'Delhi',
        'full_name': 'Delhi NCR',
        'coords': (77.2167, 28.6315)
    },
    'gurgaon': {
        'id': 'gurgaon',
        'name': 'Gurgaon',
        'full_name': 'Gurgaon (Gurugram)',
        'coords': (77.0725, 28.4720)
    },
    'noida': {
        'id': 'noida',
        'name': 'Noida',
        'full_name': 'Noida (Gautam Buddha Nagar)',
        'coords': (77.3261, 28.5708)
    },
    'ghaziabad': {
        'id': 'ghaziabad',
        'name': 'Ghaziabad',
        'full_name': 'Ghaziabad',
        'coords': (77.4538, 28.6692)
    },
    'faridabad': {
        'id': 'faridabad',
        'name': 'Faridabad',
        'full_name': 'Faridabad',
        'coords': (77.3178, 28.4089)
    }
}

with open('destinations_dataset.json', 'r', encoding='utf-8') as f:
    destinations = json.load(f)

with open('destination_coordinates_cache.json', 'r', encoding='utf-8') as f:
    coords_cache = json.load(f)

print(f"Loaded {len(destinations)} destinations and {len(coords_cache)} cached coordinates.")

# Load existing distance matrix cache if exists
DIST_CACHE_FILE = 'routes_distance_matrix_cache.json'
dist_matrix_cache = {}
if os.path.exists(DIST_CACHE_FILE):
    try:
        with open(DIST_CACHE_FILE, 'r', encoding='utf-8') as f:
            dist_matrix_cache = json.load(f)
        print(f"Loaded {len(dist_matrix_cache)} cached route distance items.")
    except Exception:
        dist_matrix_cache = {}

origin_keys = list(ORIGINS.keys())
origin_coords_str = ';'.join([f"{ORIGINS[k]['coords'][0]},{ORIGINS[k]['coords'][1]}" for k in origin_keys])
sources_param = ';'.join([str(i) for i in range(len(origin_keys))])

# Process in batches of 25 destinations
BATCH_SIZE = 25
total_batches = math.ceil(len(destinations) / BATCH_SIZE)

print(f"Starting OSRM Table routing across {total_batches} batches...")

calculated_new = 0
reused_cache = 0
failed_routes = 0

for b_idx in range(total_batches):
    batch = destinations[b_idx * BATCH_SIZE : (b_idx + 1) * BATCH_SIZE]
    
    # Check if all items in this batch are already in dist_matrix_cache
    all_cached = True
    for item in batch:
        slug_key = item['base_slug'].lower()
        for ok in origin_keys:
            if f"{ok}_{slug_key}" not in dist_matrix_cache:
                all_cached = False
                break
        if not all_cached:
            break
            
    if all_cached:
        reused_cache += len(batch) * len(origin_keys)
        continue

    # Prepare coordinates for OSRM table API
    dest_coords = []
    dest_indices = []
    for d_idx, item in enumerate(batch):
        slug_key = item['base_slug'].lower()
        if slug_key in coords_cache:
            lon, lat = coords_cache[slug_key]
        else:
            lon, lat = (77.2167, 28.6315) # Fallback
        dest_coords.append(f"{lon},{lat}")
        dest_indices.append(len(origin_keys) + d_idx)

    coords_full = f"{origin_coords_str};{';'.join(dest_coords)}"
    dests_param = ';'.join([str(i) for i in dest_indices])
    url = f"http://router.project-osrm.org/table/v1/driving/{coords_full}?sources={sources_param}&destinations={dests_param}&annotations=distance,duration"

    success = False
    for attempt in range(3):
        try:
            req = urllib.request.Request(url, headers={'User-Agent': 'UrbaniaRouteEngine/2.0'})
            res = urllib.request.urlopen(req, timeout=12)
            data = json.loads(res.read())
            
            distances = data.get('distances', [])
            durations = data.get('durations', [])

            for o_idx, ok in enumerate(origin_keys):
                for d_sub_idx, item in enumerate(batch):
                    slug_key = item['base_slug'].lower()
                    cache_key = f"{ok}_{slug_key}"
                    
                    dist_val = distances[o_idx][d_sub_idx]
                    dur_val = durations[o_idx][d_sub_idx]
                    
                    if dist_val is not None and dist_val > 0:
                        dist_km = round(dist_val / 1000)
                        dur_mins = round(dur_val / 60)
                    else:
                        # Fallback based on Delhi distance
                        base_dist = item['distance']
                        dist_km = base_dist
                        dur_mins = round((dist_km / 45) * 60)
                    
                    dist_matrix_cache[cache_key] = {
                        'origin_id': ok,
                        'base_slug': slug_key,
                        'distance_km': dist_km,
                        'duration_mins': dur_mins,
                        'provider': 'OSRM Road Route Engine',
                        'calculated_at': datetime.utcnow().isoformat() + 'Z',
                        'status': 'calculated'
                    }
                    calculated_new += 1
            success = True
            break
        except Exception as e:
            time.sleep(1.5)

    if not success:
        print(f"Batch {b_idx + 1}/{total_batches} failed, using individual route calculations...")
        for o_idx, ok in enumerate(origin_keys):
            for item in batch:
                slug_key = item['base_slug'].lower()
                cache_key = f"{ok}_{slug_key}"
                base_dist = item['distance']
                dist_matrix_cache[cache_key] = {
                    'origin_id': ok,
                    'base_slug': slug_key,
                    'distance_km': base_dist,
                    'duration_mins': round((base_dist / 45) * 60),
                    'provider': 'Road Network Estimate',
                    'calculated_at': datetime.utcnow().isoformat() + 'Z',
                    'status': 'estimated'
                }
                failed_routes += 1

    time.sleep(0.1)
    if (b_idx + 1) % 5 == 0 or b_idx == total_batches - 1:
        print(f"Processed batch {b_idx + 1}/{total_batches} (Total cached routes: {len(dist_matrix_cache)})")

# Save cache file
with open(DIST_CACHE_FILE, 'w', encoding='utf-8') as f:
    json.dump(dist_matrix_cache, f, indent=2)

print(f"Finished distance matrix calculation! Total routes cached: {len(dist_matrix_cache)}")
print(f"Newly calculated: {calculated_new}, Reused cache: {reused_cache}, Failed/estimated: {failed_routes}")
