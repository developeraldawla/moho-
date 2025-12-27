#!/bin/bash
set -e

echo "Deploying application..."

# Enter maintenance mode
(php artisan down) || true

# Update codebase
git pull origin main

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Migrate database
php artisan migrate --force

# Clear and cache config/routes/views
php artisan optimize
php artisan view:cache

# Build assets
npm run build

# Exit maintenance mode
php artisan up

echo "Deployment finished successfully!"
