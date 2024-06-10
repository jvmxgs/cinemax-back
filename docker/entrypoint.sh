#!/bin/bash

[ ! -d "/var/www/vendor" ] &&  composer install

if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
    php artisan storage:link
fi

migration_status=$(php artisan migrate:status)

if echo "$migration_status" | grep -q '^\s*[0-9]\+.*Ran'; then
    echo "The database probably has data, seeds not executed"
else
    echo "Running migrations..."
    php artisan migrate
    echo "Seeding database..."
    php artisan db:seed
fi

su - www-data
php-fpm
