FROM php:8.3-fpm-alpine

# System dependencies + PHP extensions
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql exif opcache

# Configure opcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini

# Copy Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/alorea

# Create storage directories
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
