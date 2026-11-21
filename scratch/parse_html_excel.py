import re
from bs4 import BeautifulSoup

# We can parse HTML table using re or html.parser
for name in ['Noida-city.xls', 'Ghaziabad-city.xls', 'Gurgaon-city.xls', 'Faridabad-city.xls']:
    with open(name, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()
    
    # Extract table rows
    rows = re.findall(r'<tr[^>]*>(.*?)</tr>', content, re.DOTALL | re.I)
    print(f"\n==================== {name} ====================")
    print(f"Total rows found: {len(rows)}")
    
    # Extract first 5 rows
    for idx, r in enumerate(rows[:5]):
        cols = re.findall(r'<t[dh][^>]*>(.*?)</t[dh]>', r, re.DOTALL | re.I)
        clean_cols = [re.sub(r'<[^>]+>', '', c).strip() for c in cols]
        print(f"Row {idx}: {clean_cols}")
