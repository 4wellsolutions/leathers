
import os

file_path = r'd:\workspace\leathers-pk\resources\views\layouts\admin.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

# Indetify range to replace
# Start at line 23 (0-indexed: 22) -> <div class="flex flex-col h-0 flex-1 bg-leather-900 border-r border-leather-800">
# End at line 239 (0-indexed: 238) -> </div> (closing the div above)

# Let's verify content
start_idx = 22
end_idx = 238

print(f"Line {start_idx+1}: {lines[start_idx].strip()}")
print(f"Line {end_idx+1}: {lines[end_idx].strip()}")

# Check if correct
if "bg-leather-900 border-r border-leather-800" in lines[start_idx] and "</div>" in lines[end_idx]:
    print("Found correct block.")
    # Replace lines [start_idx, end_idx] (inclusive) with include
    # Python slice is [start:end+1]
    
    # We want to keep indentation
    indent = lines[start_idx][:lines[start_idx].find('<')]
    
    new_lines = lines[:start_idx] + [indent + "@include('partials.admin-sidebar')\n"] + lines[end_idx+1:]
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.writelines(new_lines)
    print("Successfully updated admin.blade.php")
else:
    print("Could not verify block boundaries. Aborting.")
