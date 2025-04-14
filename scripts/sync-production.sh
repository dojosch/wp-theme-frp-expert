#!/bin/bash

GREEN="\033[1;32m"
NOCOLOR="\033[0m"

echo -e "${GREEN}\nUploading theme via FTP...\n${NOCOLOR}"

# Move to the root directory of your theme (one level up from scripts)
cd "$(dirname "$0")/.."

# Load env variables
set -a
source .env
set +a

# Run lftp from root, using excludesFile from scripts
lftp -u "$FTP_USER","$FTP_PASS" "$FTP_HOST" <<EOF
set ftp:list-options -a
set ssl:verify-certificate no
mirror -R ./ "$FTP_REMOTE_PATH" \
  --exclude-glob-from=scripts/excludesFile \
  --delete \
  --verbose
quit
EOF

echo -e "${GREEN}\nUpload complete. 🎉\n${NOCOLOR}"
