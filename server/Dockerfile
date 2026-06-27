FROM php:8.4-fpm-alpine

# Install dependencies and extensions
RUN apk add --no-cache \
    postgresql-dev \
    autoconf \
    g++ \
    make \
    linux-headers

RUN docker-php-ext-install pdo pdo_pgsql

# Install redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# We will mount this folder in docker-compose, but we need
# to make sure www-data has correct permissions
RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]
