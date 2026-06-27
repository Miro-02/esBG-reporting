#!/bin/sh
export PGPASSWORD="$DB_PASSWORD"
while true; do
  H=$(date +%H | sed 's/^0*//'); H=${H:-0}
  M=$(date +%M | sed 's/^0*//'); M=${M:-0}
  S=$(date +%S | sed 's/^0*//'); S=${S:-0}
  SINCE_MIDNIGHT=$((H * 3600 + M * 60 + S))
  TARGET=7200  # 02:00
  if [ "$SINCE_MIDNIGHT" -lt "$TARGET" ]; then
    SLEEP=$((TARGET - SINCE_MIDNIGHT))
  else
    SLEEP=$((86400 - SINCE_MIDNIGHT + TARGET))
  fi
  echo "Next backup in ${SLEEP}s (at 02:00)"
  sleep "$SLEEP"
  /backup.sh
done
