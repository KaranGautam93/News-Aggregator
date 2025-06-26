#!/bin/bash

# Wait for MySQL
until bash -c "echo > /dev/tcp/mysql/3306" 2>/dev/null; do
  echo "Waiting for MySQL..."
  sleep 2
done

# Wait for Mongo
until bash -c "echo > /dev/tcp/mongo/27017" 2>/dev/null; do
  echo "Waiting for MongoDB..."
  sleep 2
done

# Laravel setup
cd /var/www

echo "Running migrations"
php artisan migrate
php artisan l5-swagger:generate

# Start PHP-FPM
exec php-fpm

