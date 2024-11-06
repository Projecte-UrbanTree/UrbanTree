# Base image: Apache with PHP 8.3 (official)
FROM php:8.3-apache

# Install Xdebug and MySQL extension with cleanup
RUN apt-get update && apt-get install -y --no-install-recommends \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install mysqli pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Set permissions for the public directory
RUN chown -R www-data:www-data /var/www/html

# Set up working directory
WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the local xdebug.ini file to the specified location in the container
COPY ./docker/website/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Copy custom-apache.conf to the container
COPY ./docker/website/conf.d/custom-apache.conf /etc/apache2/sites-available/000-default.conf