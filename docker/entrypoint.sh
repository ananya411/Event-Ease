#!/bin/sh

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache

php-fpm &
nginx -g "daemon off;"

