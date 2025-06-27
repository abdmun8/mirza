FROM php:8.4-fpm-alpine

LABEL maintainer="Abdul"

WORKDIR /var/www

# Install system & PHP dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    git \
    sqlite \
    sqlite-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    icu-dev \
    shadow \
    nodejs-current \
    npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip intl opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Laravel app
COPY . .

# Install PHP and Node dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build

# Laravel optimizations
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache database
# RUN mkdir -p /run/nginx \
#  && chown -R www-data:www-data /var/www \
#  && adduser -D -g 'www' www

# Copy configs
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Ensure storage & database file exist
# RUN touch database/database.sqlite \
#  && chown -R www-data:www-data database storage bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
