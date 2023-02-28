FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    supervisor

RUN docker-php-ext-install bcmath pdo_mysql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www
