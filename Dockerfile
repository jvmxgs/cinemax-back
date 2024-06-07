FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
        $PHPIZE_DEPS \
        bash \
        postgresql-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        imagemagick-dev \
        imagemagick \
        && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
        && docker-php-ext-install -j$(nproc) gd \
        && pecl install imagick \
        && docker-php-ext-enable imagick \
        && docker-php-ext-install exif fileinfo \
        && apk del $PHPIZE_DEPS \
        && rm -rf /var/cache/apk/*


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql pgsql

USER 1000:1000

WORKDIR /var/www

COPY --chown=1000:1000 ./docker/entrypoint.sh /home/entrypoint.sh

RUN chmod +x /home/entrypoint.sh

CMD ["/home/entrypoint.sh"]
