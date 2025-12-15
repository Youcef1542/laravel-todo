FROM php:8.2-fpm

# Installer dépendances + nginx
RUN apt-get update && apt-get install -y \
    nginx \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Installer Composer manuellement (sans Docker Hub)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php


WORKDIR /var/www

# Copier le projet
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Config nginx
COPY docker/nginx/nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD ["sh", "-c", "nginx -g 'daemon off;' & php-fpm -F"]

