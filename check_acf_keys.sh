#!/bin/bash
# filepath: /Users/pfloerl/Local Sites/wp-starter-theme/app/public/wp-content/themes/wp-starter-tw/check_keys.sh

# Define the directory to scan
ACF_DIR="theme/config/acf-fields"

# Create a temporary file to store key:file:line information
temp_file=$(mktemp)

echo "Scanning ACF field files for duplicate keys..."
echo "-------------------------------------"

# Find all keys in PHP files and save to temp file
find "$ACF_DIR" -type f -name "*.php" | while read -r file; do
  # Use grep to find lines with 'key' => and extract the key value
  grep -n "'key' =>" "$file" | while read -r line_info; do
    line_num=$(echo "$line_info" | cut -d: -f1)
    # Extract the key value (handling both single and double quotes)
    key=$(echo "$line_info" | sed -E "s/.*'key'[ ]*=>[ ]*['\"](.*)['\"].*/\1/")
    echo "$key:$file:$line_num" >> "$temp_file"
  done
done

# Find duplicate keys and display them
echo "Checking for duplicates..."

# First, identify the duplicate keys
duplicate_keys=$(sort "$temp_file" | cut -d: -f1 | uniq -d)

# If there are duplicates, process and display them
if [ -n "$duplicate_keys" ]; then
  echo "Found duplicate keys:"
  echo "-------------------------------------"
  
  # For each duplicate key, show all occurrences
  echo "$duplicate_keys" | while read -r key; do
    echo "DUPLICATE KEY: $key"
    grep "^$key:" "$temp_file" | while read -r entry; do
      file=$(echo "$entry" | cut -d: -f2)
      line=$(echo "$entry" | cut -d: -f3)
      echo "  - Found in: $file (line $line)"
    done
    echo ""
  done
else
  echo "No duplicate keys found."
fi

# Print summary
total_keys=$(wc -l < "$temp_file")
unique_keys=$(sort "$temp_file" | cut -d: -f1 | uniq | wc -l)
duplicate_count=$((total_keys - unique_keys))

echo "-------------------------------------"
echo "SUMMARY:"
echo "Total keys found: $total_keys"
echo "Unique keys: $unique_keys"
echo "Duplicate keys: $((total_keys - unique_keys))"

# Clean up
rm "$temp_file"

echo "-------------------------------------"
echo "Script completed."