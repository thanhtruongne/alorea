FROM php:8.3-fpm-alpine

RUN apk add --no-cache libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd exif zip pdo pdo_mysql mbstring

COPY --from=composer:2.8.3 /usr/bin/composer /usr/bin/composer

# Tạo user không phải root
RUN addgroup -g 1000 appgroup && adduser -D -u 1000 -G appgroup appuser

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader --no-interaction


# Copy source code
COPY . .

# Cài package PHP
# RUN composer install --no-dev --optimize-autoloader --no-interaction

# Tạo thư mục storage, phân quyền
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER appuser

EXPOSE 9000
CMD ["php-fpm"]
