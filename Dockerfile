FROM php:8.2-fpm

# Installer dépendances système + MySQL + PHP extensions
RUN apt-get update && apt-get install -y \
    nginx \
    zip \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Dossier de travail
WORKDIR /var/www

# Copier le projet Laravel
COPY . .

# Installer dépendances PHP Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissions Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exposer le port
EXPOSE 80

# Démarrer Nginx + PHP-FPM
CMD ["sh", "-c", "service nginx start && php-fpm"]
