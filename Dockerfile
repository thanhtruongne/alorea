
FROM php:8.3-fpm-alpine AS base

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd exif zip pdo pdo_mysql mbstring opcache \
    && docker-php-ext-enable opcache

# Copy Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Create non-root user
RUN addgroup -g 1000 appgroup && adduser -D -u 1000 -G appgroup appuser

# Set working directory
WORKDIR /app

FROM base AS development

# Copy composer files first for better caching
COPY --chown=appuser:appgroup composer.json composer.lock ./

# Install dependencies (with dev packages)
RUN composer install --prefer-dist --no-scripts --no-autoloader

# Copy source code
COPY --chown=appuser:appgroup . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Create storage directories and set permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R appuser:appgroup storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER appuser

EXPOSE 9000
CMD ["php-fpm"]

FROM base AS production

# Copy composer files first for better caching
COPY --chown=appuser:appgroup composer.json composer.lock ./

# Install dependencies (no dev packages, optimized)
RUN composer install --no-dev --prefer-dist --no-scripts --no-autoloader --optimize-autoloader

# Copy source code
COPY --chown=appuser:appgroup . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize --classmap-authoritative

# Create storage directories and set permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R appuser:appgroup storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Set user
USER appuser

EXPOSE 9000
CMD ["php-fpm"]
