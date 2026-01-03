
import os
import glob

directory = r'd:\workspace\leathers-pk\database\migrations'
files = glob.glob(os.path.join(directory, '*.php'))

print(f"Scanning {len(files)} files...")

for file_path in files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    if "Schema::table('products'" in content or 'Schema::table("products"' in content:
        if "is_active" in content:
            print(f"Suspicious file: {os.path.basename(file_path)}")
            # Check context
            lines = content.split('\n')
            in_product_table = False
            for line in lines:
                if "Schema::table('products'" in line or 'Schema::table("products"' in line:
                    in_product_table = True
                if in_product_table and "is_active" in line and "boolean" in line:
                    print(f"  -> Found 'is_active' inside Schema::table('products') block? Maybe.")
                    print(f"  -> Line: {line.strip()}")
                if in_product_table and ("});" in line or "}" in line and line.strip() == "}"):
                    # heuristic closing
                    pass
