FROM php:8.3.9-fpm-alpine3.20 AS base
WORKDIR /app

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd exif zip pdo pdo_mysql pcntl opcache \
    && docker-php-ext-enable opcache

# Install Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install dependencies (with dev packages for local development)
RUN composer install --optimize-autoloader

# Create storage directories and fix permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} \
    && chmod -R 777 storage bootstrap/cache

CMD ["php-fpm"]

FROM base AS reverb
CMD ["php", "artisan", "reverb:start"]

FROM base AS workers
CMD ["php", "artisan", "queue:work"]

FROM base AS nonroot
RUN addgroup -g 1000 myusergroup
RUN adduser -D -u 1000 myuser -G myusergroup
RUN chown -R myuser:myusergroup .
USER myuser
CMD ["php-fpm"]  # ⭐ Thêm luôn cho stage này

FROM nonroot AS reverb-nonroot
CMD ["php", "artisan", "reverb:start"]

FROM nonroot AS workers-nonroot
CMD ["php", "artisan", "queue:work"]
