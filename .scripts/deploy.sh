#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

# Pull the latest version of the app
git pull origin main

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Clear OPcache
php artisan opcache:clear

# Recreate cache
php artisan optimize

# Pre-compile application files
php artisan opcache:compile --force

# Run database migrations
php artisan migrate:refresh --seed --force

# Exit maintenance mode
php artisan up

echo "Deployment finished!"