#
# This file defines the Docker image used to create a Docker container
#

# Base image: Apache with PHP 8.3 (official)
FROM php:8.3-apache

# Install Xdebug
RUN apt-get update \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy the local xdebug.ini file to the specified location in the container
COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini