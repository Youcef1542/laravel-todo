FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    zip unzip git \
    libzip-dev libpng-dev libonig-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# 🔴 CRITIQUE : enlever la config nginx par défaut
RUN rm -f /etc/nginx/sites-enabled/default

# 🔴 CRITIQUE : injecter TA config nginx Laravel
COPY docker/nginx/nginx.prod.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
