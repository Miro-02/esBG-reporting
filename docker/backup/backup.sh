#!/bin/sh
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
echo "=== Backup started at $TIMESTAMP ==="

# Set postgres password (works whether called from entrypoint or docker exec)
export PGPASSWORD="$DB_PASSWORD"

# Database
pg_dump -h "$DB_HOST" -U "$DB_USER" -d "$DB_NAME" -F c \
  -f "/backups/db_${TIMESTAMP}.dump" \
  && echo "DB dump OK" || echo "DB dump FAILED"

# Public storage
if [ -d "/storage/public" ]; then
  tar -czf "/backups/storage_public_${TIMESTAMP}.tar.gz" -C /storage/public . \
    && echo "Public storage backup OK" || echo "Public storage backup FAILED"
fi

# Private storage
if [ -d "/storage/private" ]; then
  tar -czf "/backups/storage_private_${TIMESTAMP}.tar.gz" -C /storage/private . \
    && echo "Private storage backup OK" || echo "Private storage backup FAILED"
fi

# Cleanup older than 7 days
find /backups -type f -mtime +7 -delete
echo "=== Backup complete at $TIMESTAMP ==="
