import json

audit_data = json.load(open('destination_image_audit_report.json', encoding='utf-8'))
print(f"Total audit items: {len(audit_data)}")

# Create mapping by filename and destination name
dest_map = {}
file_map = {}

for item in audit_data:
    d = item['destination'].strip()
    f = item['file'].strip()
    s = item['subject'].strip()
    st = item['state'].strip()
    t = item.get('type', 'MONUMENT')
    dest_map[d.lower()] = item
    file_map[f.lower()] = item

multi_origin = json.load(open('includes/destinations_multi_origin.json', encoding='utf-8'))
delhi_routes = multi_origin['routes_by_origin']['delhi']
print(f"Total Delhi routes: {len(delhi_routes)}")

matched = 0
for r in delhi_routes:
    hero = r.get('hero_image', '')
    fname = hero.split('/')[-1].lower() if hero else ''
    dest = r.get('destination', '').strip().lower()
    if fname in file_map or dest in dest_map:
        matched += 1

print(f"Matched routes with verified audit subjects: {matched} / {len(delhi_routes)}")
