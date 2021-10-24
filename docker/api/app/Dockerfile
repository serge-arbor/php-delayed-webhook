FROM php:fpm-alpine

RUN set -eux; \
    apk add --no-cache icu-dev icu-libs $PHPIZE_DEPS; \
    docker-php-ext-install -j$(nproc) intl; \
    pecl install redis; \
    pecl clear-cache; \
    apk del icu-dev $PHPIZE_DEPS; \
    docker-php-ext-enable opcache redis; \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY docker/api/app/preload.ini /usr/local/etc/php/conf.d/

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./

RUN set -eux; \
    composer install --no-dev --optimize-autoloader --no-scripts; \
    composer clear-cache

COPY bin bin
COPY config config
COPY public public
COPY src src

RUN set -eux; \
    composer dump-env prod --empty; \
    composer install --no-dev --optimize-autoloader; \
    composer clear-cache; \
    APP_ENV=prod APP_DEBUG=0 APP_SECRET=f679b4db48fa47bbb36110a3ddc9c2c1 php bin/console cache:clear; \
    chown -R www-data:www-data .
