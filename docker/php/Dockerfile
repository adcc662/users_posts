# ----------------------
# The FPM base container
# ----------------------
FROM php:8.2-fpm-alpine as dev

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/


RUN install-php-extensions pdo_pgsql gd


WORKDIR /app

# ----------------------
# Composer install step
# ----------------------
FROM composer:2.7.7 as build

WORKDIR /app

COPY composer.* ./
COPY database/ database/


RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

RUN chmod -R 777 /app/storage
