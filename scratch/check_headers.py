files = [
    'Location Pair-Delhi.xlsx',
    'Noida-city.xls',
    'Ghaziabad-city.xls',
    'Gurgaon-city.xls',
    'Faridabad-city.xls'
]

for f in files:
    with open(f, 'rb') as fp:
        header = fp.read(300)
        print(f"\nFile: {f} (size: {len(header)} bytes sample)")
        print(f"Hex: {header[:16].hex()}")
        try:
            print("Text preview:")
            print(header.decode('utf-8')[:200])
        except Exception:
            try:
                print(header.decode('latin1')[:200])
            except Exception as e:
                print(f"Binary: {e}")
