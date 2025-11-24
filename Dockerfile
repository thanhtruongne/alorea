FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy package files first for better caching
COPY package*.json ./

# Install dependencies with cache mount
RUN --mount=type=cache,target=/root/.npm \
    npm ci --prefer-offline --no-audit --omit=dev

# Build assets
RUN npm run build

# ============================================
# Base Stage - Common Dependencies
# ============================================
FROM php:8.3-fpm-alpine AS base

# Install system dependencies and PHP extensions in one layer
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    mysql-client \
    nginx \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd exif zip pdo pdo_mysql mbstring opcache \
    && docker-php-ext-enable opcache

# Configure PHP-FPM
RUN sed -i 's/pm.max_children = 5/pm.max_children = 20/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/pm.start_servers = 2/pm.start_servers = 5/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/pm.min_spare_servers = 1/pm.min_spare_servers = 3/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/pm.max_spare_servers = 3/pm.max_spare_servers = 10/' /usr/local/etc/php-fpm.d/www.conf

# Configure opcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=16" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Copy Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Create non-root user
RUN addgroup -g 1000 appgroup && adduser -D -u 1000 -G appgroup appuser

WORKDIR /app

# ============================================
# Development Stage
# ============================================
FROM base AS development

# Copy composer files first
COPY --chown=appuser:appgroup composer.json composer.lock ./

# Install dependencies with cache mount
RUN --mount=type=cache,target=/tmp/cache \
    composer install --prefer-dist --no-scripts --no-autoloader

# Copy application code
COPY --chown=appuser:appgroup . .

# Copy built assets
COPY --from=node-builder --chown=appuser:appgroup /app/public/build ./public/build

# Generate autoload
RUN composer dump-autoload --optimize

# Setup storage
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R appuser:appgroup storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER appuser

EXPOSE 9000
CMD ["php-fpm"]

# ============================================
# Production Stage
# ============================================
FROM base AS production

# Copy composer files first
COPY --chown=appuser:appgroup composer.json composer.lock ./

# Install production dependencies with cache mount
RUN --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --prefer-dist --no-scripts --no-autoloader --optimize-autoloader

# Copy application code (exclude dev files)
COPY --chown=appuser:appgroup app ./app
COPY --chown=appuser:appgroup bootstrap ./bootstrap
COPY --chown=appuser:appgroup config ./config
COPY --chown=appuser:appgroup database ./database
COPY --chown=appuser:appgroup public ./public
COPY --chown=appuser:appgroup resources ./resources
COPY --chown=appuser:appgroup routes ./routes
COPY --chown=appuser:appgroup artisan ./

# Copy built assets
COPY --from=node-builder --chown=appuser:appgroup /app/public/build ./public/build

# Generate optimized autoload
RUN composer dump-autoload --optimize --classmap-authoritative

# Setup storage with optimal permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chown -R appuser:appgroup storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Remove unnecessary files
RUN rm -rf tests *.md .git* .editorconfig .env.example

USER appuser

EXPOSE 9000
CMD ["php-fpm"]
