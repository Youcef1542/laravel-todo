# Image de base avec PHP-FPM
FROM php:8.2-fpm

# Installer Nginx + dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql gd \
 && rm -rf /var/lib/apt/lists/*

# Répertoire de travail
WORKDIR /var/www/html

# Copier le projet Laravel dans le conteneur
COPY . /var/www/html

# Installer Composer (depuis l'image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

# Copier la configuration Nginx
COPY docker/app/nginx.conf /etc/nginx/nginx.conf

# Donner les bonnes permissions à Laravel
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 storage bootstrap/cache

# Exposer le port 80 à l'intérieur du conteneur
EXPOSE 80

# Lancer PHP-FPM en arrière-plan puis Nginx au premier plan
CMD ["bash", "-c", "php-fpm & nginx -g 'daemon off;'"]
