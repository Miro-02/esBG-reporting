#!/bin/sh
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
echo "=== Backup started at $TIMESTAMP ==="
pg_dump -h "$DB_HOST" -U "$DB_USER" -d "$DB_NAME" -F c \
  -f "/backups/flyaway_db_${TIMESTAMP}.dump" \
  && echo "DB dump OK" || echo "DB dump FAILED"
tar -czf "/backups/flyaway_storage_${TIMESTAMP}.tar.gz" -C /storage . \
  && echo "Storage backup OK" || echo "Storage backup FAILED"
find /backups -type f -mtime +7 -delete
echo "=== Backup complete at $TIMESTAMP ==="
