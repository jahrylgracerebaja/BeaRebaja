#!/bin/sh
set -eu

cd /var/www/html

if [ -n "${APP_KEY:-}" ] && [ "${APP_KEY#base64:}" = "$APP_KEY" ]; then
    export APP_KEY="base64:$APP_KEY"
fi

touch database/database.sqlite
chown www-data:www-data database database/database.sqlite
chmod 664 database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache

su -m -s /bin/sh www-data -c 'php artisan migrate --force'
su -m -s /bin/sh www-data -c 'php artisan optimize'

exec "$@"
