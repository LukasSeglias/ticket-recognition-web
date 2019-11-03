# Heavily based on https://www.cloudreach.com/en/insights/blog/containerize-this-how-to-use-php-apache-mysql-within-docker-containers/
ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

RUN apk update; \
    apk upgrade;

ARG CTI_IMAGE_DIRECTORY=""
RUN mkdir -p ${CTI_IMAGE_DIRECTORY}; \
    chown -R www-data:www-data ${CTI_IMAGE_DIRECTORY};

ARG CTI_IMAGE_DIRECTORY=""
COPY data/* ${CTI_IMAGE_DIRECTORY}

# See: https://github.com/docker-library/php/issues/221
RUN apk --no-cache add postgresql-dev; \
    docker-php-ext-install pdo_pgsql;
