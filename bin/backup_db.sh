#!/bin/bash
# Database Backup Script
# Usage: ./bin/backup_db.sh

DB_USER="${DB_USERNAME:-root}"
DB_PASS="${DB_PASSWORD:-}"
DB_NAME="${DB_DATABASE:-moho}"
BACKUP_DIR="./storage/backups"
DATE=$(date +%Y-%m-%d_%H-%M-%S)
FILE="$BACKUP_DIR/$DB_NAME-$DATE.sql"

mkdir -p "$BACKUP_DIR"

if [ -z "$DB_PASS" ]; then
    mysqldump -u "$DB_USER" "$DB_NAME" > "$FILE"
else
    mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$FILE"
fi

# Gzip the backup
gzip "$FILE"

echo "Backup created at $FILE.gz"
