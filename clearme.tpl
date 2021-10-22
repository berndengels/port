#!/bin/bash
php="/usr/local/bin/php"
composer="/usr/local/bin/composer"
#php="/opt/plesk/php/8.0/bin/php"
#composer="$php /usr/local/psa/var/modules/composer/composer.phar"

echo "clear all caches"
$php artisan cache:clear
$php artisan config:clear
$php artisan route:clear
$php artisan view:clear
$php artisan responsecache:clear
redis-cli FLUSHALL
composer dumpautoload
printf 'all DONE \360\237\230\216\n'
