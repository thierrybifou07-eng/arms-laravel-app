#!/usr/bin/env bash
set -euo pipefail

php artisan config:clear
php artisan route:clear
php artisan view:clear

# Do not run `php artisan cache:clear` here: when CACHE_STORE=database,
# Laravel clears the `cache` table and the container can crash before the app
# is started if Railway's private MySQL DNS is still warming up.
php artisan migrate --force
php artisan storage:link --force

exec php -S 0.0.0.0:"${PORT:-8000}" -t public
