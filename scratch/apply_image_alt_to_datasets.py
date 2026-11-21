import json, re

def clean_subject(subj):
    s = subj.strip()
    patterns = [
        r'^(?:it is\s+)?(?:known|famous|noted|renowned)\s+(?:for|as)\s+(?:the\s+|its\s+)?',
        r'^(?:the\s+)?(?:town|city|village|region|place|destination)\s+(?:features|is known for|is famous for)\s+(?:the\s+|its\s+)?',
    ]
    for p in patterns:
        s = re.sub(p, '', s, flags=re.IGNORECASE)
    s = s.strip()
    if s:
        s = s[0].upper() + s[1:]
    return s

audit_data = json.load(open('destination_image_audit_report.json', encoding='utf-8'))
audit_by_dest = {}
audit_by_file = {}

for item in audit_data:
    dest = item['destination'].strip()
    f = item['file'].strip()
    state = item['state'].strip()
    subj = clean_subject(item['subject'])
    
    alt = f"{subj} in {dest}, {state}" if state else f"{subj} in {dest}"
    audit_by_dest[dest.lower()] = alt
    audit_by_file[f.lower()] = alt

print(f"Loaded {len(audit_by_dest)} destination mappings from audit report.")

# Update destinations_multi_origin.json
multi_origin = json.load(open('includes/destinations_multi_origin.json', encoding='utf-8'))
total_routes = 0
updated_routes = 0

for origin_key, routes in multi_origin.get('routes_by_origin', {}).items():
    for r in routes:
        total_routes += 1
        hero = r.get('hero_image', '')
        fname = hero.split('/')[-1].lower() if hero else ''
        dest = r.get('destination', '').strip().lower()
        state = r.get('state', '').strip()
        
        alt = audit_by_file.get(fname) or audit_by_dest.get(dest)
        if not alt:
            alt = f"Scenic travel attractions and landmark landscape in {r.get('destination', '')}, {state}" if state else f"Scenic travel attractions and landmark landscape in {r.get('destination', '')}"
        
        r['image_alt'] = alt
        updated_routes += 1

# Update routes_by_slug index as well
if 'routes_by_slug' in multi_origin:
    for slug, r in multi_origin['routes_by_slug'].items():
        hero = r.get('hero_image', '')
        fname = hero.split('/')[-1].lower() if hero else ''
        dest = r.get('destination', '').strip().lower()
        state = r.get('state', '').strip()
        alt = audit_by_file.get(fname) or audit_by_dest.get(dest)
        if not alt:
            alt = f"Scenic travel attractions and landmark landscape in {r.get('destination', '')}, {state}" if state else f"Scenic travel attractions and landmark landscape in {r.get('destination', '')}"
        r['image_alt'] = alt

with open('includes/destinations_multi_origin.json', 'w', encoding='utf-8') as f:
    json.dump(multi_origin, f, indent=2, ensure_ascii=False)

print(f"Updated includes/destinations_multi_origin.json: {updated_routes}/{total_routes} routes given landmark ALT text.")

# Update destinations_dataset.json if it exists
try:
    legacy_dataset = json.load(open('destinations_dataset.json', encoding='utf-8'))
    for r in legacy_dataset:
        hero = r.get('hero_image', '')
        fname = hero.split('/')[-1].lower() if hero else ''
        dest = r.get('destination', '').strip().lower()
        state = r.get('state', '').strip()
        alt = audit_by_file.get(fname) or audit_by_dest.get(dest)
        if not alt:
            alt = f"Scenic travel attractions and landmark landscape in {r.get('destination', '')}, {state}" if state else f"Scenic travel attractions and landmark landscape in {r.get('destination', '')}"
        r['image_alt'] = alt
    with open('destinations_dataset.json', 'w', encoding='utf-8') as f:
        json.dump(legacy_dataset, f, indent=2, ensure_ascii=False)
    print(f"Updated destinations_dataset.json ({len(legacy_dataset)} routes).")
except Exception as e:
    print(f"Error updating destinations_dataset.json: {e}")
