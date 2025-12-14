FROM php:8.3.9-fpm-alpine3.20 AS base

WORKDIR /app

# Install PHP extensions
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    bzip2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    pcntl \
    gd \
    exif \
    zip \
    bz2 \
    && docker-php-ext-enable gd exif
