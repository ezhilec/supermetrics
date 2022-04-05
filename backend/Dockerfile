FROM php:8.0-fpm

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install opcache

RUN apt-get update && apt-get install -y \
    git

WORKDIR /app/

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json /app/composer.json

RUN composer install --no-interaction