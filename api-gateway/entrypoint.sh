#!/bin/sh

# echo "Waiting for mysql"
# until mysqladmin ping -h database --silent; do
#   echo "."
#   sleep 1
# done
# echo "MySQL is up - executing command"

cd /var/www
php artisan migrate --force

php-fpm