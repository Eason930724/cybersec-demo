FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pgsql

COPY . /var/www/html/

RUN a2enmod rewrite
