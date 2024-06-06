FROM php:8.2-fpm-alpine

RUN apk update && apk add bash postgresql-dev --no-cache && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql pgsql

USER 1000:1000

WORKDIR /var/www

COPY --chown=1000:1000 ./docker/entrypoint.sh /home/entrypoint.sh

RUN chmod +x /home/entrypoint.sh

CMD ["/home/entrypoint.sh"]
