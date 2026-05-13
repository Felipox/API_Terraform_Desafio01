# Stage 1 - Composer
FROM composer:2 AS builder

WORKDIR /app

COPY composer.json composer.lock ./

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction



# Stage 2 - Runtime
FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip

WORKDIR /var/www

COPY --from=builder /app /var/www

CMD ["php-fpm"]