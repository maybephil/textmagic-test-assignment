FROM docker.io/php:8.3-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=docker.io/omposer:latest /usr/bin/composer /usr/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
