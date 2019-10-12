# Heavily based on https://www.cloudreach.com/en/insights/blog/containerize-this-how-to-use-php-apache-mysql-within-docker-containers/
ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

RUN apk update; \
    apk upgrade;

COPY db.ini /etc/opt/ticket-recognition-web/db.ini

RUN docker-php-ext-install pdo_mysql
