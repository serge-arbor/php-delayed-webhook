FROM php:alpine

RUN set -eux; \
    apk add --no-cache icu-dev icu-libs $PHPIZE_DEPS; \
    docker-php-ext-install -j$(nproc) intl; \
    pecl install redis; \
    pecl clear-cache; \
    apk del icu-dev $PHPIZE_DEPS; \
    docker-php-ext-enable opcache redis; \
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    KERNEL_CLASS='App\Kernel'

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./

RUN set -eux; \
    composer install --optimize-autoloader --no-scripts; \
    composer clear-cache

COPY bin bin
COPY config config
COPY public public
COPY src src
COPY templates templates
COPY tests tests
COPY phpunit.xml.dist ./

RUN set -eux; \
    composer dump-env test --empty; \
    composer install --optimize-autoloader; \
    composer clear-cache; \
    php bin/console cache:clear

CMD [ "php", "bin/phpunit" ]
