import json

with open(r"c:\xampp\htdocs\Urbaniaonrentdelhi\destinations_dataset.json", 'r', encoding='utf-8') as f:
    data = json.load(f)

print(f"Total destinations in destinations_dataset.json: {len(data)}")
has_image_alt = 0
for v in data:
    if isinstance(v, dict) and 'image_alt' in v:
        has_image_alt += 1

print(f"Total entries with image_alt: {has_image_alt}")
for v in data[:5]:
    print(v.get('slug'), "| destination:", v.get('destination'), "| image_alt:", v.get('image_alt'), "| hero_image:", v.get('hero_image'))

