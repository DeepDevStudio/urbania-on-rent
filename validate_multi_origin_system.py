import json

with open('includes/destinations_multi_origin.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

origins = ['delhi', 'gurgaon', 'noida', 'ghaziabad', 'faridabad']
routes_by_origin = data.get('routes_by_origin', {})
routes_by_slug = data.get('routes_by_slug', {})

print("==================================================")
print("MULTI-ORIGIN SYSTEM VALIDATION AUDIT")
print("==================================================")

report = {}
all_slugs = set()
duplicate_slugs = []
zero_distance = []
missing_images = []
fare_mismatches = []

sample_destinations = ["manali", "jaipur", "agra", "rishikesh", "amritsar", "shimla", "nainital"]
sample_matrix = {dest: {} for dest in sample_destinations}

for orig in origins:
    routes = routes_by_origin.get(orig, [])
    report[orig] = {
        'count': len(routes),
        'valid_distance': 0,
        'valid_images': 0,
        'valid_seo': 0,
        'valid_pricing': 0
    }
    
    for r in routes:
        slug = r['slug']
        if slug in all_slugs:
            duplicate_slugs.append(slug)
        all_slugs.add(slug)
        
        # Check distance
        dist = r.get('distance', 0)
        dur = r.get('estimated_duration_minutes', 0)
        if dist > 0 and dur > 0:
            report[orig]['valid_distance'] += 1
        else:
            zero_distance.append(slug)
            
        # Check image
        img = r.get('hero_image', '')
        if img and len(img) > 5:
            report[orig]['valid_images'] += 1
        else:
            missing_images.append(slug)
            
        # Check SEO
        if r.get('meta_title') and r.get('meta_description') and r.get('slug'):
            report[orig]['valid_seo'] += 1
            
        # Check pricing logic
        min_km = max(dist * 2, 500)
        f_9s = min_km * 40
        f_12s = min_km * 42
        f_16s = min_km * 42
        r_f9 = int(str(r.get('fare_9s', 0)).replace(',', ''))
        r_f12 = int(str(r.get('fare_12s', 0)).replace(',', ''))
        r_f16 = int(str(r.get('fare_16s', 0)).replace(',', ''))
        if r_f9 == f_9s and r_f12 == f_12s and r_f16 == f_16s:
            report[orig]['valid_pricing'] += 1
        else:
            fare_mismatches.append(slug)
            
        # Sample matrix
        dest_name_lower = r.get('destination', '').lower()
        if dest_name_lower in sample_matrix:
            sample_matrix[dest_name_lower][orig] = f"{dist} km ({r.get('estimated_travel_time')})"

print("\n--- ORIGIN ROUTE SUMMARY ---")
print(f"{'Origin':<12} | {'Expected':<8} | {'Completed':<10} | {'Valid Distance':<15} | {'Valid Images':<13} | {'Valid Fares':<12}")
print("-" * 80)
total_completed = 0
total_dist = 0
total_img = 0
total_fares = 0
for orig in origins:
    st = report[orig]
    total_completed += st['count']
    total_dist += st['valid_distance']
    total_img += st['valid_images']
    total_fares += st['valid_pricing']
    print(f"{orig.capitalize():<12} | 611      | {st['count']:<10} | {st['valid_distance']:<15} | {st['valid_images']:<13} | {st['valid_pricing']:<12}")
print("-" * 80)
print(f"{'TOTAL':<12} | 3,055    | {total_completed:<10} | {total_dist:<15} | {total_img:<13} | {total_fares:<12}")

print("\n--- SAMPLE INDEPENDENT ROUTE DISTANCE MATRIX ---")
print(f"{'Destination':<12} | {'Delhi':<18} | {'Gurgaon':<18} | {'Noida':<18} | {'Ghaziabad':<18} | {'Faridabad':<18}")
print("-" * 105)
for dest, orig_data in sample_matrix.items():
    print(f"{dest.capitalize():<12} | {orig_data.get('delhi', 'N/A'):<18} | {orig_data.get('gurgaon', 'N/A'):<18} | {orig_data.get('noida', 'N/A'):<18} | {orig_data.get('ghaziabad', 'N/A'):<18} | {orig_data.get('faridabad', 'N/A'):<18}")

print("\n--- INTEGRITY CHECKS ---")
print(f"Total Unique Route Slugs: {len(all_slugs)}")
print(f"Duplicate Slugs: {len(duplicate_slugs)}")
print(f"Routes with Zero Distance: {len(zero_distance)}")
print(f"Routes with Missing Images: {len(missing_images)}")
print(f"Routes with Pricing Mismatches: {len(fare_mismatches)}")
print(f"Routes by Slug Lookup Index Size: {len(routes_by_slug)}")
print("Validation finished successfully!")
