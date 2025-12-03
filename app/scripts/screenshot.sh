#!/bin/bash

# Screenshot directory
storage_path="/home/idicesystem-dodo/htdocs/dodo.idicesystem.com/public/storage/screenshots"
mkdir -p "$storage_path"

# Log file
log_file="/home/idicesystem-dodo/htdocs/dodo.idicesystem.com/storage/logs/full_system_screenshot.log"

# Timestamp
timestamp=$(date +"%Y%m%d_%H%M%S")

# Define pages to capture
declare -A pages
pages["login"]="https://dodo.idicesystem.com/login"
pages["dashboard"]="https://dodo.idicesystem.com/dashboard"

# Add more as needed...

# Loop through and screenshot each page
for name in "${!pages[@]}"; do
    url="${pages[$name]}"
    filename="${name}_${timestamp}.png"
    save_path="${storage_path}/${filename}"

    echo "[$(date)] Capturing $url -> $filename" >> "$log_file"

    google-chrome \
      --headless \
      --no-sandbox \
      --disable-gpu \
      --ignore-certificate-errors \
      --screenshot="$save_path" \
      --window-size=1600,1000 \
      "$url"

    if [[ -s "$save_path" ]]; then
        echo "✅ Success: $filename saved" >> "$log_file"
    else
        echo "❌ Failed: $filename not saved" >> "$log_file"
    fi
done
