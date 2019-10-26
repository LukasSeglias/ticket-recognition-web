# Heavily based on https://www.cloudreach.com/en/insights/blog/containerize-this-how-to-use-php-apache-mysql-within-docker-containers/
ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

RUN apk update; \
    apk upgrade;

# See: https://github.com/docker-library/php/issues/221
RUN apk --no-cache add postgresql-dev; \
    docker-php-ext-install pdo_pgsql;
