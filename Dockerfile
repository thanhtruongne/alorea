FROM php:8.3.9-fpm-alpine3.20 AS base
WORKDIR /app

# Install Composer
COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Add and Enable PHP-PDO Extenstions
RUN docker-php-ext-install pdo pdo_mysql pcntl
RUN docker-php-ext-enable pdo_mysql

# Copy application files
COPY . .

# Install dependencies (with dev packages for local development)
RUN composer install --optimize-autoloader

# Create storage directories and fix permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} \
    && chmod -R 777 storage bootstrap/cache

FROM base AS reverb
CMD ["php", "artisan", "reverb:start"]

FROM base AS workers
CMD ["php", "artisan", "queue:work"]

FROM base AS nonroot
RUN addgroup -g 1000 myusergroup
RUN adduser -D -u 1000 myuser -G myusergroup
RUN chown -R myuser:myusergroup .
USER myuser

FROM nonroot AS reverb-nonroot
CMD ["php", "artisan", "reverb:start"]

FROM nonroot AS workers-nonroot
CMD ["php", "artisan", "queue:work"]
