#!/bin/bash

[ ! -d "/var/www/vendor" ] &&  composer install

if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

if [ ! -z "$(php artisan migrate)" ]; then
    echo "The database probably has data, seeds not executed "
else
    php artisan db:seed
fi

su - www-data
php-fpm
