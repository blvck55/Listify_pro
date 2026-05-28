#!/bin/bash
set -e

cd /var/app/current

# Run pending migrations. --force skips the production confirmation prompt.
php artisan migrate --force
