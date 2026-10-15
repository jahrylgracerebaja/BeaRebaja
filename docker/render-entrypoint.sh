#!/bin/sh
set -eu

cd /var/www/html

touch database/database.sqlite
chown www-data:www-data database database/database.sqlite
chmod 664 database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache

su -s /bin/sh www-data -c 'php artisan migrate --force'
su -s /bin/sh www-data -c 'php artisan optimize'

exec "$@"
