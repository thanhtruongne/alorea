# ============================================
# Development Stage
# ============================================
FROM php:8.3-fpm-alpine AS development

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql

# Copy Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Create storage directories
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]

# ============================================
# Production Stage
# ============================================
FROM php:8.3-fpm-alpine AS production

# Install dependencies
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql opcache

# Configure opcache for production
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Copy Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Setup permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
