import json

with open(r"c:\xampp\htdocs\Urbaniaonrentdelhi\destination_image_audit_report.json", 'r', encoding='utf-8') as f:
    audit = json.load(f)

print(f"Total audit items: {len(audit)}")
types = {}
for item in audit:
    t = item.get('type')
    types[t] = types.get(t, 0) + 1
print("Audit types breakdown:", types)

print("\nFirst 10 items:")
for item in audit[:10]:
    print(f"  {item.get('destination')} ({item.get('state')}): subject='{item.get('subject')}', file='{item.get('file')}', type='{item.get('type')}'")
