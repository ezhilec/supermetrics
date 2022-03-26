FROM php:8.0-fpm

WORKDIR /app/

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json /app/composer.json

RUN composer install --prefer-source --no-interaction


#COPY . /app


#RUN [ "php", "./index.php" ]
#RUN usermod -u 1000 www-data && groupmod -g 1000 www-data