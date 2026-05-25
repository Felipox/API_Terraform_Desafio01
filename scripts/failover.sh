#!/bin/bash

ENV_FILE="$(dirname "$0")/../.env"
LOG_FILE="$(dirname "$0")/../storage/logs/failover.log"

SECONDARY_HOST="10.0.0.30"

timestamp() { date '+%Y-%m-%d %H:%M:%S'; }
log() { echo "[$(timestamp)] $1" | tee -a "$LOG_FILE"; }

log "FAILOVER: trocando para banco local ($SECONDARY_HOST)"

cp "$ENV_FILE" "${ENV_FILE}.bak.$(date +%s)"

sed -i "s/^DB_HOST=.*/DB_HOST=${SECONDARY_HOST}/" "$ENV_FILE"
log "DB_HOST alterado para: $SECONDARY_HOST"

php "$(dirname "$0")/../artisan" config:clear >> "$LOG_FILE" 2>&1

DB_NAME=$(grep '^DB_DATABASE=' "$ENV_FILE" | cut -d '=' -f2)
DB_USER=$(grep '^DB_USERNAME=' "$ENV_FILE" | cut -d '=' -f2)
DB_PASS=$(grep '^DB_PASSWORD=' "$ENV_FILE" | cut -d '=' -f2)

PGPASSWORD="$DB_PASS" psql -h "$SECONDARY_HOST" -U "$DB_USER" -d "$DB_NAME" -c "SELECT 1;" > /dev/null 2>&1

if [[ $? -eq 0 ]]; then
    log "Failover concluído. Conectado em $SECONDARY_HOST"
else
    log "Falha ao conectar no secundário."
    cp "${ENV_FILE}.bak."* "$ENV_FILE"
    php "$(dirname "$0")/../artisan" config:clear >> "$LOG_FILE" 2>&1
fi