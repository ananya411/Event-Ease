#!/bin/sh

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database migrate (MongoDB ke liye bhi kaam karta hai)
php artisan migrate --force

php-fpm &
nginx -g "daemon off;"
