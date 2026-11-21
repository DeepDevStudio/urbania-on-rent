import openpyxl
import xlrd
import os

files = {
    'delhi': 'Location Pair-Delhi.xlsx',
    'noida': 'Noida-city.xls',
    'ghaziabad': 'Ghaziabad-city.xls',
    'gurgaon': 'Gurgaon-city.xls',
    'faridabad': 'Faridabad-city.xls'
}

for origin, filename in files.items():
    print(f"\n==================== {origin.upper()}: {filename} ====================")
    if not os.path.exists(filename):
        print("FILE NOT FOUND!")
        continue
    
    if filename.endswith('.xlsx'):
        wb = openpyxl.load_workbook(filename, data_only=True)
        sheet_names = wb.sheetnames
        print(f"Sheets: {sheet_names}")
        sheet = wb[sheet_names[0]]
        print(f"Dimensions: {sheet.max_row} rows x {sheet.max_column} cols")
        for r in range(1, min(6, sheet.max_row + 1)):
            row_vals = [sheet.cell(r, c).value for c in range(1, min(10, sheet.max_column + 1))]
            print(f"Row {r}: {row_vals}")
    else:
        # .xls
        # Note: sometimes an .xls is actually an .xlsx or HTML or real BIFF8 .xls
        try:
            wb = xlrd.open_workbook(filename)
            sheet = wb.sheet_by_index(0)
            print(f"Sheets: {wb.sheet_names()}")
            print(f"Dimensions: {sheet.nrows} rows x {sheet.ncols} cols")
            for r in range(min(5, sheet.nrows)):
                print(f"Row {r+1}: {sheet.row_values(r)[:10]}")
        except Exception as e:
            print(f"xlrd failed with: {e}, trying openpyxl...")
            try:
                wb = openpyxl.load_workbook(filename, data_only=True)
                sheet = wb.active
                print(f"Dimensions: {sheet.max_row} rows x {sheet.max_column} cols")
                for r in range(1, min(6, sheet.max_row + 1)):
                    row_vals = [sheet.cell(r, c).value for c in range(1, min(10, sheet.max_column + 1))]
                    print(f"Row {r}: {row_vals}")
            except Exception as e2:
                print(f"openpyxl failed too: {e2}")
