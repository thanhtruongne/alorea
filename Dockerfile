FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd exif zip \
    && docker-php-ext-enable exif


COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
# Add and Enable PHP-PDO Extenstions
RUN docker-php-ext-install pdo pdo_mysql pcntl
RUN docker-php-ext-enable pdo_mysql


# Set working directory
WORKDIR /var/www

# Tạo user và group không phải root để tăng bảo mật
RUN addgroup --gid 1000 appgroup \
    && adduser --disabled-password --gecos '' --uid 1000 --gid 1000 appuser \
    && chown -R appuser:appgroup /var/www

# Copy source code
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
# RUN npm install && npm run build

# Create storage directories and fix permissions
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} \
    && chmod -R 777 storage bootstrap/cache

# Set permissions
RUN chown -R appuser:appgroup /var/www \
    && chmod -R 755 /var/www/storage

# Chạy container với user không phải root
USER appuser

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
