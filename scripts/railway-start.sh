#!/usr/bin/env bash
set -euo pipefail

configure_database_url() {
    if [ -n "${DB_URL:-}" ]; then
        echo "Using DB_URL for the database connection."
        return
    fi

    for variable in DATABASE_PUBLIC_URL MYSQL_PUBLIC_URL DATABASE_URL MYSQL_URL; do
        value="${!variable:-}"

        if [ -n "$value" ]; then
            export DB_URL="$value"
            echo "Using $variable as DB_URL for the database connection."
            return
        fi
    done
}

run_migrations() {
    if [ "${RUN_MIGRATIONS:-true}" != "true" ]; then
        echo "Skipping migrations because RUN_MIGRATIONS is not true."
        return
    fi

    local attempts="${DB_MIGRATION_ATTEMPTS:-12}"
    local delay="${DB_MIGRATION_SLEEP_SECONDS:-5}"

    for attempt in $(seq 1 "$attempts"); do
        echo "Running database migrations (attempt $attempt/$attempts)..."

        if php artisan migrate --force; then
            return
        fi

        if [ "$attempt" -lt "$attempts" ]; then
            echo "Database is not reachable yet; retrying in ${delay}s..."
            sleep "$delay"
        fi
    done

    echo "WARNING: Database migrations failed after $attempts attempts."
    echo "The web server will still start so Railway does not keep crash-looping."
    echo "Verify that the app and MySQL services are in the same Railway project/environment,"
    echo "or set DB_URL to the MySQL public connection URL if private DNS is unavailable."
}

configure_database_url

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan storage:link --force

run_migrations

exec php -S 0.0.0.0:"${PORT:-8000}" -t public
