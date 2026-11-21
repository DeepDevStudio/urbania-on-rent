import json

with open(r"c:\xampp\htdocs\Urbaniaonrentdelhi\destinations_dataset.json", 'r', encoding='utf-8') as f:
    data = json.load(f)

first = data[0]
for k, v in first.items():
    print(f"{k}: {repr(v)[:100]}")
